<?php

namespace App\Http\Controllers\Admin\Data;

use Illuminate\Http\Request;

use Auth;

use App\Models\Item\Item;
use App\Models\Item\ItemCategory;
use App\Models\Loot\LootTable;
use App\Models\Raffle\Raffle;
use App\Models\Currency\Currency;
use App\Models\Recipe\Recipe;
use App\Models\Recipe\RecipeCategory;

use App\Services\RecipeService;

use App\Http\Controllers\Controller;
use App\Models\Pet\Pet;
use App\Models\Pet\PetCategory;

class RecipeController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Admin / Recipe Controller
    |--------------------------------------------------------------------------
    |
    | Handles creation/editing of recipes.
    |
    */
        /**
     * Shows the item category index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getIndex()
    {
        return view('admin.recipes.recipe_categories', [
            'recipe_categories' => RecipeCategory::orderBy('sort', 'DESC')->get()
        ]);
    }

    /**********************************************************************************************
    
        RECIPES

     **********************************************************************************************/

    /**
     * Shows the recipe index.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRecipeIndex(Request $request) {
        $query = Recipe::query();
        $data = $request->only(['name', 'is_visible']);
        if(isset($data['is_visible']) && $data['is_visible'] != 'none') 
            $query->where('is_visible', $data['is_visible']);
        if (isset($data['name']))
            $query->where('name', 'LIKE', '%' . $data['name'] . '%');
        return view('admin.recipes.recipes', [
            'recipes' => $query->paginate(20)->appends($request->query()),
            'recipe_categories' => recipeCategory::orderBy('sort', 'DESC')->get(),
            'is_visible' => ['none' => 'Any Status', '0' => 'Unreleased', '1' => 'Released'],
        ]);
    }
    
    /**
     * Shows the create item category page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateRecipeCategory()
    {
        return view('admin.recipes.create_edit_recipe_category', [
            'category' => new RecipeCategory
        ]);
    }

    /**
     * Shows the edit item category page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditRecipeCategory($id)
    {
        $category = RecipeCategory::find($id);
        if(!$category) abort(404);
        return view('admin.recipes.create_edit_recipe_category', [
            'category' => $category
        ]);
    }

        /**
     * Creates or edits an item category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditRecipeCategory(Request $request, RecipeService $service, $id = null)
    {
        $id ? $request->validate(RecipeCategory::$updateRules) : $request->validate(RecipeCategory::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image',
        ]);
        if($id && $service->updateRecipeCategory(RecipeCategory::find($id), $data, Auth::user())) {
            flash('Category updated successfully.')->success();
        }
        else if (!$id && $category = $service->createRecipeCategory($data, Auth::user())) {
            flash('Category created successfully.')->success();
            return redirect()->to('admin/data/spell-categories/edit/'.$category->id);
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Gets the item category deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteItemCategory($id)
    {
        $category = RecipeCategory::find($id);
        return view('admin.recipes._delete_recipe_category', [
            'category' => $category,
        ]);
    }

        /**
     * Deletes an item category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteRecipeCategory(Request $request, RecipeService $service, $id)
    {
        if($id && $service->deleteRecipeCategory(RecipeCategory::find($id))) {
            flash('Category deleted successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/spell-categories');
    }

        /**
     * Sorts item categories.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSortRecipeCategory(Request $request, RecipeService $service)
    {
        if($service->sortRecipeCategory($request->get('sort'))) {
            flash('Category order updated successfully.')->success();
        }
        else {
            foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Shows the create recipe page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCreateRecipe() {
        return view('admin.recipes.create_edit_recipe', [
            'recipe' => new Recipe,
            'items' => Item::orderBy('name')->pluck('name', 'id'),
            'categories' => ItemCategory::orderBy('name')->pluck('name', 'id'),
            'recipe_categories' => RecipeCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'recipes' => ['none' => 'No parent'] + Recipe::visible()->pluck('name', 'id')->toArray(),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'petCategories' => PetCategory::orderBy('sort', 'DESC')->pluck('name', 'id'),
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
        ]);
    }

    /**
     * Shows the edit recipe page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditRecipe($id) {
        $recipe = Recipe::find($id);
        if (!$recipe) abort(404);
        return view('admin.recipes.create_edit_recipe', [
            'recipe' => $recipe,
            'items' => Item::orderBy('name')->pluck('name', 'id'),
            'categories' => ItemCategory::orderBy('name')->pluck('name', 'id'),
            'recipe_categories' => RecipeCategory::orderBy('sort', 'DESC')->pluck('name', 'id')->toArray(),
            'currencies' => Currency::where('is_user_owned', 1)->orderBy('name')->pluck('name', 'id'),
            'tables' => LootTable::orderBy('name')->pluck('name', 'id'),
            'raffles' => Raffle::where('rolled_at', null)->where('is_active', 1)->orderBy('name')->pluck('name', 'id'),
            'recipes' => ['none' => 'No parent'] + Recipe::visible()->where('id', '!=', $recipe->id)->pluck('name', 'id')->toArray(),
            'pets' => Pet::orderBy('name')->pluck('name', 'id'),
            'petCategories' => PetCategory::orderBy('sort', 'DESC')->pluck('name', 'id'),
            'limit_periods' => [null => 'None', 'Hour' => 'Hour', 'Day' => 'Day', 'Week' => 'Week', 'Month' => 'Month', 'Year' => 'Year'],
        ]);
    }

    /**
     * Creates or edits an recipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int|null                  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateEditRecipe(Request $request, RecipeService $service, $id = null) {
        $id ? $request->validate(Recipe::$updateRules) : $request->validate(Recipe::$createRules);
        $data = $request->only([
            'name', 'description', 'image', 'remove_image', 'needs_unlocking', 'is_visible',
            'ingredient_type', 'ingredient_data', 'ingredient_quantity', 'recipe_category_id',
            'rewardable_type', 'rewardable_id', 'reward_quantity',
            'is_limited', 'limit_type', 'limit_id', 'limit_quantity',
            'limit', 'limit_period',
        ]);
        if ($id && $service->updateRecipe(Recipe::find($id), $data, Auth::user())) {
            flash('Spell updated successfully.')->success();
        } else if (!$id && $recipe = $service->createRecipe($data, Auth::user())) {
            flash('Spell created successfully.')->success();
            return redirect()->to('admin/data/spells/edit/' . $recipe->id);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Gets the recipe deletion modal.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteRecipe($id) {
        $recipe = Recipe::find($id);
        return view('admin.recipes._delete_recipe', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * Creates or edits an recipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteRecipe(Request $request, RecipeService $service, $id) {
        if ($id && $service->deleteRecipe(Recipe::find($id))) {
            flash('Spell deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/spells');
    }

    /**********************************************************************************************
    
        RECIPE TAGS

     **********************************************************************************************/

    /**
     * Gets the tag addition page.
     *
     * @param  App\Services\RecipeService  $service
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAddRecipeTag(RecipeService $service, $id) {
        $recipe = Recipe::find($id);
        return view('admin.recipes.add_tag', [
            'recipe' => $recipe,
            'tags' => array_diff($service->getRecipeTags(), $recipe->tags()->pluck('tag')->toArray())
        ]);
    }

    /**
     * Adds a tag to an recipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int                       $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAddRecipeTag(Request $request, RecipeService $service, $id) {
        $recipe = Recipe::find($id);
        $tag = $request->get('tag');
        if ($tag = $service->addRecipeTag($recipe, $tag)) {
            flash('Tag added successfully.')->success();
            return redirect()->to($tag->adminUrl);
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Gets the tag editing page.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getEditRecipeTag(RecipeService $service, $id, $tag) {
        $recipe = Recipe::find($id);
        $tag = $recipe->tags()->where('tag', $tag)->first();
        if (!$recipe || !$tag) abort(404);
        return view('admin.recipes.edit_tag', [
            'recipe' => $recipe,
            'tag' => $tag
        ] + $tag->getEditData());
    }

    /**
     * Edits tag data for an recipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int                       $id
     * @param  string                    $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditRecipeTag(Request $request, RecipeService $service, $id, $tag) {
        $recipe = Recipe::find($id);
        if ($service->editRecipeTag($recipe, $tag, $request->all())) {
            flash('Tag edited successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->back();
    }

    /**
     * Gets the recipe tag deletion modal.
     *
     * @param  int  $id
     * @param  string                    $tag
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getDeleteRecipeTag($id, $tag) {
        $recipe = Recipe::find($id);
        $tag = $recipe->tags()->where('tag', $tag)->first();
        return view('admin.recipes._delete_recipe_tag', [
            'recipe' => $recipe,
            'tag' => $tag
        ]);
    }

    /**
     * Deletes a tag from an recipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Services\RecipeService  $service
     * @param  int                       $id
     * @param  string                    $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteRecipeTag(Request $request, RecipeService $service, $id, $tag) {
        $recipe = Recipe::find($id);
        if ($service->deleteRecipeTag($recipe, $tag)) {
            flash('Tag deleted successfully.')->success();
        } else {
            foreach ($service->errors()->getMessages()['error'] as $error) flash($error)->error();
        }
        return redirect()->to('admin/data/spells/edit/' . $recipe->id);
    }
}
