<?php

namespace App\Services;

use App\Services\Service;

use DB;
use Notifications;
use Config;

use App\Models\User\User;
use App\Models\User\UserItem;
use App\Models\User\UserCurrency;
use App\Models\User\UserRecipe;

use App\Models\Recipe\Recipe;
use App\Models\Recipe\RecipeIngredient;
use App\Models\Recipe\RecipeReward;

use App\Models\Currency\Currency;
use App\Models\User\UserPet;
use App\Services\InventoryManager;
use App\Services\CurrencyManager;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Recipe\RecipeLog;

class RecipeManager extends Service {

    /**********************************************************************************************

     RECIPE CRAFTING

     **********************************************************************************************/

    /**
     * Attempts to craft the specified recipe.
     *
     * @param  array                        $data
     * @param  \App\Models\Recipe\Recipe    $recipe
     * @param  \App\Models\User\User        $user
     * @return bool
     */
    public function craftRecipe($data, $recipe, $user) {
        DB::beginTransaction();

        try {
            // Check user has all limits
            if ($recipe->is_limited) {
                foreach ($recipe->limits as $limit) {
                    $limitType = $limit->limit_type;
                    $check = NULL;
                    switch ($limitType) {
                        case 'Item':
                            $check = UserItem::where('item_id', $limit->reward->id)->where('user_id', $user->id)->where('count', '>=', $limit->quantity)->first();
                            break;
                        case 'Currency':
                            $check = UserCurrency::where('currency_id', $limit->reward->id)->where('user_id', $user->id)->where('quantity', '>=', $limit->quantity)->first();
                            break;
                        case 'Recipe':
                            $check = UserRecipe::where('recipe_id', $limit->reward->id)->where('user_id', $user->id)->first();
                            break;
                    }

                    if (!$check) throw new \Exception('You require ' . $limit->reward->name . ' x ' . $limit->quantity . ' to cast this');
                }
            }

            //then check the individual completion limit +timeframe
            if ($recipe->limit) {
                if (!$recipe->checkLimit($recipe, $user)) {
                    throw new \Exception("You have already crafted this recipe the maximum number of times.");
                }

            }

            // Check for sufficient currencies
            $user_currencies = $user->getCurrencies(true);
            $currency_ingredients = $recipe->ingredients->where('ingredient_type', 'Currency');
            foreach ($currency_ingredients as $ingredient) {
                $currency = $user_currencies->where('id', $ingredient->data[0])->first();
                if ($currency->quantity < $ingredient->quantity) throw new \Exception('Insufficient currency.');
            }

            // If there are non-Currency ingredients.
            if (isset($data['stack_id']) || isset($data['pet_stack_id'])) {
                // Fetch the stacks from DB
                $stacks = isset($data['stack_id']) ? UserItem::whereIn('id', $data['stack_id'])->get()->map(function ($stack) use ($data) {
                    $stack->count = (int)$data['stack_quantity'][$stack->id];
                    return $stack;
                }) : null;

                if (isset($data['pet_stack_id'])) {
                    // Fetch the stacks from DB
                    $petStacks = UserPet::whereIn('id', $data['pet_stack_id'])->get();
                    isset($stacks) ? $stacks = $stacks->concat($petStacks) : $stacks = $petStacks;
                }

                // Check for sufficient ingredients
                $plucked = $this->pluckIngredients($user, $recipe, $stacks);
                if (!$plucked) throw new \Exception('Insufficient subjects selected.');

                // Debit the ingredients
                $service = new InventoryManager();
                $petService = new PetManager();
                foreach ($plucked as $id => $quantity) {
                    $stack = str_contains($id, 'pet') ? UserPet::find(str_replace('pet', '', $id)) : UserItem::find($id);
                    if (!(str_contains($id, 'pet') ? $petService : $service)->debitStack($user, 'Spellcasting', ['data' => 'Part of ' . $recipe->name . ''], $stack, $quantity)) throw new \Exception('Subjects could not be used.');
                }
            } else {
                $items = $recipe->ingredients->whereIn('ingredient_type', ['Item', 'Pet']);
                if (count($items) > 0) throw new \Exception('Insufficient subjects selected.');
            }

            // Debit the currency
            $service = new CurrencyManager();
            foreach ($currency_ingredients as $ingredient) {
                if (!$service->debitCurrency($user, null, 'Spellcasting', 'Part of ' . $recipe->name . '', Currency::find($ingredient->data[0]), $ingredient->quantity)) throw new \Exception('Currency could not be debited.');
            }

            // Credit rewards
            $logType = 'Spellcasted';
            $craftingData = [
                'data' => 'Result from ' . $recipe->displayName . ''
            ];

            if (!($rewards = fillUserAssets($recipe->rewardItems, null, $user, $logType, $craftingData))) {
                throw new \Exception('Failed to distribute rewards to user.');
            }

            flash($this->getRewardsString($rewards))->success();

            // make a log of the action.
            $Log = RecipeLog::create([
            'recipe_id' => $recipe->id,
            'user_id' => $user->id,
            ]);

            return $this->commitReturn(true);
        } catch (\Exception $e) {
            $this->setError('error', $e->getMessage());
        }
        return $this->rollbackReturn(false);
    }

    /**     
    *Returns a string of the rewards so the user can see what they have received.
    *
* @param mixed $rewards
*/
private function getRewardsString($rewards) {
    return 'You have received: '.createRewardsString($rewards);
}

    /**
     * Plucks stacks from a given Collection of user items that meet the crafting requirements of a recipe
     * If there are insufficient ingredients, null is returned
     *
     * @param  \Illuminate\Database\Eloquent\Collection     $user_items
     * @param  \App\Models\Recipe\Recipe                    $recipe
     * @return array|null
     */
    public function pluckIngredients($user, $recipe, $selectedStacks = null) {
        $user_items = UserItem::with('item')->whereNull('deleted_at')->where('count', '>', '0')->where('user_id', $user->id)->get();
        $user_pets = UserPet::with('pet')->whereNull('deleted_at')->where('count', '>', '0')->where('user_id', $user->id)->get();
        $plucked = [];
        // foreach ingredient, search for a qualifying item, and select items up to the quantity, if insufficient continue onto the next entry
        foreach ($recipe->ingredients->sortBy('ingredient_type') as $ingredient) {
            $prefix = '';
            if ($selectedStacks) {
                switch ($ingredient->ingredient_type) {
                    case 'Item':
                        $stacks = $selectedStacks->where('item.id', $ingredient->data[0]);
                        break;
                    case 'MultiItem':
                        $stacks = $selectedStacks->whereIn('item.id', $ingredient->data);
                        break;
                    case 'Category':
                        $stacks = $selectedStacks->where('item.item_category_id', $ingredient->data[0]);
                        break;
                    case 'MultiCategory':
                        $stacks = $selectedStacks->whereIn('item.item_category_id', $ingredient->data);
                        break;
                    case 'Pet':
                        $stacks = $selectedStacks->where('pet.id', $ingredient->data[0]);
                        $prefix = 'pet';
                        break;
                    case 'MultiPet':
                        $stacks = $selectedStacks->whereIn('pet.id', $ingredient->data);
                        $prefix = 'pet';
                        break;
                    case 'PetCategory':
                        $stacks = $selectedStacks->where('pet.pet_category_id', $ingredient->data[0]);
                        $prefix = 'pet';
                        break;
                    case 'MultiPetCategory':
                        $stacks = $selectedStacks->whereIn('pet.pet_category_id', $ingredient->data);
                        $prefix = 'pet';
                        break;
                    case 'Currency':
                        continue 2;
                }
            } else {
                switch ($ingredient->ingredient_type) {
                    case 'Item':
                        $stacks = $user_items->where('item.id', $ingredient->data[0]);
                        break;
                    case 'MultiItem':
                        $stacks = $user_items->whereIn('item.id', $ingredient->data);
                        break;
                    case 'Category':
                        $stacks = $user_items->where('item.item_category_id', $ingredient->data[0]);
                        break;
                    case 'MultiCategory':
                        $stacks = $user_items->whereIn('item.item_category_id', $ingredient->data);
                        break;
                    case 'Pet':
                        $stacks = $user_pets->where('pet.id', $ingredient->data[0]);
                        $prefix = 'pet';
                        break;
                    case 'MultiPet':
                        $stacks = $user_pets->whereIn('pet.id', $ingredient->data);
                        $prefix = 'pet';
                        break;
                    case 'PetCategory':
                        $stacks = $user_pets->where('pet.pet_category_id', $ingredient->data[0]);
                        $prefix = 'pet';
                        break;
                    case 'MultiPetCategory':
                        $stacks = $user_pets->whereIn('pet.pet_category_id', $ingredient->data);
                        $prefix = 'pet';
                        break;
                    case 'Currency':
                        continue 2;
                }
            }

            $quantity_left = $ingredient->quantity;
            while ($quantity_left > 0 && count($stacks) > 0) {
                $stack = $stacks->pop();
                $plucked[$prefix . $stack->id] = $stack->count >= $quantity_left ? $quantity_left : $stack->count;
                // Update the larger collection
                $user_items = $user_items->map(function ($s) use ($stack, $plucked, $prefix) {
                    if ($s->id == $stack->id) $s->count -= $plucked[$prefix . $stack->id];
                    if ($s->count) return $s;
                    else return null;
                })->filter();
                $quantity_left -= $plucked[$prefix . $stack->id];
            }
            // If there are no more eligible ingredients but the requirement is not fulfilled, the pluck fails
            if ($quantity_left > 0) return null;
        }
        return $plucked;
    }
}
