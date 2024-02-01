<?php

namespace App\Services;

use App\Services\Service;

use DB;
use Config;
use App\Models\Item\Item;
use App\Models\Item\ItemLog;
use App\Models\Currency\Currency;
use App\Models\Currency\CurrencyLog;
use App\Models\Pet\Pet;
use App\Models\Pet\PetLog;
use App\Models\Award\Award;
use App\Models\Award\AwardLog;
use App\Models\Recipe\Recipe;
use App\Models\Raffle\RaffleTicket;
use App\Models\Raffle\Raffle;
use App\Models\User\UserCurrency;
use App\Models\User\UserItem;
use App\Models\User\UserPet;
use App\Models\User\UserRecipe;
use App\Models\User\UserRecipeLog;
use App\Models\User\UserAward;

class MonitoringService extends Service
{
    /*
    |--------------------------------------------------------------------------
    | Monitoring Service
    |--------------------------------------------------------------------------
    |    |
    */

    public function getObjectFromRequest($type, $id)
    {
        switch ($type) {
            case 'Item':
                return Item::find($id);
                break;
            case 'Raffle':
                return Raffle::find($id);
                break;
            case 'Currency':
                return Currency::find($id);
                break;
            case 'Pet':
                return Pet::find($id);
                break;
            case 'Award':
                return Award::find($id);
                break;
            case 'Recipe':
                return Recipe::find($id);
                break;
                //add more here if needed, eg Pets/Awards/PetVariants...
        }
        return null;
    }

    public function getCurrentlyOwned($type, $id)
    {
        switch ($type) {
            case 'Item':
                $items = UserItem::where('item_id', $id)->where('count', '>', 0)->get();
                $ownedByUser = [];
                foreach($items as $userItem){
                    isset($ownedByUser[$userItem->user_id]) ? $ownedByUser[$userItem->user_id] += $userItem->count : $ownedByUser[$userItem->user_id] = $userItem->count;
                }
                return $ownedByUser;
                break;
            case 'Raffle':
                $tickets = RaffleTicket::where('raffle_id', $id)->get();
                $ownedByUser = [];
                foreach($tickets as $ticket){
                    isset($ownedByUser[$ticket->user_id]) ? $ownedByUser[$ticket->user_id] += 1 : $ownedByUser[$ticket->user_id] = 1;
                }
                return $ownedByUser;
                break;
            case 'Currency':
                $currencies = UserCurrency::where('currency_id', $id)->where('quantity', '>', 0)->get();
                $ownedByUser = [];
                foreach($currencies as $currency){
                    isset($ownedByUser[$currency->user_id]) ? $ownedByUser[$currency->user_id] += $currency->quantity : $ownedByUser[$currency->user_id] = $currency->quantity;
                }
                return $ownedByUser;
                break;
            case 'Pet':
                    $pets = UserPet::where('pet_id', $id)->where('count', '>', 0)->get();
                    $ownedByUser = [];
                    foreach($pets as $userPet){
                        isset($ownedByUser[$userPet->user_id]) ? $ownedByUser[$userPet->user_id] += $userPet->count : $ownedByUser[$userPet->user_id] = $userPet->count;
                    }
                    return $ownedByUser;
                    break;
            case 'Award':
                    $awards = UserAward::where('award_id', $id)->where('count', '>', 0)->get();
                    $ownedByUser = [];
                    foreach($awards as $userAward){
                        isset($ownedByUser[$userAward->user_id]) ? $ownedByUser[$userAward->user_id] += $userAward->count : $ownedByUser[$userAward->user_id] = $userAward->count;
                    }
                    return $ownedByUser;
                    break;
            case 'Recipe':
                    $recipes = UserRecipe::where('recipe_id', $id)->get();
                    $ownedByUser = [];
                    foreach($recipes as $recipe){
                        isset($ownedByUser[$recipe->user_id]) ? $ownedByUser[$recipe->user_id] += 1 : $ownedByUser[$recipe->user_id] = 1;
                    }
                    return $ownedByUser;
                    break;
                //add more here if needed, eg Pets/Awards/PetVariants...
        }
        return null;
    }


    public function getAlltimeOwned($type, $id)
    {
        switch ($type) {
            case 'Item':
                // try figure ownership out by logs. Not that these could be inflated if users traded an item around a lot.
                // You can edit the log typ you want to include here.
                $logTypes = [
                    'Shop Purchase', 'Box Opened', 'Box Rewards', 'Staff Grant', 'Trade',
                    'Collected from Donation Shop', 'Unwrapped Item', 'Prompt Rewards', 'User Transfer', 'daily Rewards', 'Choice Box Opened', 'Harvesting Rewards',
                    'Choice Box Rewards', 'Collection Reward', 'Seeds for Apples Rewards', 'Award Claim'
                ];
                $logs = ItemLog::where('item_id', $id)->where('recipient_id', '!=', null)->whereIn('log_type', $logTypes)->get();
                $ownedByUser = [];
                foreach($logs as $log){
                    isset($ownedByUser[$log->recipient_id]) ? $ownedByUser[$log->recipient_id] += $log->quantity : $ownedByUser[$log->recipient_id] = $log->quantity;
                }
                return $ownedByUser;
                break;
            case 'Raffle':
                // for raffles its the same as tickets are not deleted.
                $tickets = RaffleTicket::where('raffle_id', $id)->get();
                $ownedByUser = [];
                foreach($tickets as $ticket){
                    isset($ownedByUser[$ticket->user_id]) ? $ownedByUser[$ticket->user_id] += 1 : $ownedByUser[$ticket->user_id] = 1;
                }
                return $ownedByUser;
                break;
            case 'Currency':
                $logTypes = [
                    'Daily Roll', 'Box Rewards', 'Staff Grant', 'Gallery Submission Reward', 'Prompt Rewards', 'Trade', 'Unwrapped Currency', 'User Transfer',
                    'Claim Rewards', 'daily Rewards', 'User Shop Credit', 'Sold Item', 'Claim Approved', 'Form Rewards', 'Received from recycling: Gold and Magic',
                    'Award Claim'
                ];
                $logs = CurrencyLog::where('currency_id', $id)->where('quantity', '>', 0)->whereIn('log_type', $logTypes)->get();
                $ownedByUser = [];
                foreach($logs as $log){
                    isset($ownedByUser[$log->recipient_id]) ? $ownedByUser[$log->recipient_id] += $log->quantity : $ownedByUser[$log->recipient_id] = $log->quantity;
                }
                return $ownedByUser;
                break;
                case 'Pet':
                    // try figure ownership out by logs. Not that these could be inflated if users traded an item around a lot.
                    // You can edit the log typ you want to include here.
                    $logTypes = [
                        'Shop Purchase', 'Box Opened', 'Box Rewards', 'Staff Grant', 'Trade',
                        'Collected from Donation Shop', 'Unwrapped Item', 'Prompt Rewards', 'User Transfer', 'daily Rewards', 'Choice Box Opened', 'Harvesting Rewards',
                        'Choice Box Rewards', 'Collection Reward', 'Seeds for Apples Rewards', 'Award Claim'
                    ];
                    $logs = PetLog::where('pet_id', $id)->where('recipient_id', '!=', null)->whereIn('log_type', $logTypes)->get();
                    $ownedByUser = [];
                    foreach($logs as $log){
                        isset($ownedByUser[$log->recipient_id]) ? $ownedByUser[$log->recipient_id] += $log->quantity : $ownedByUser[$log->recipient_id] = $log->quantity;
                    }
                    return $ownedByUser;
                    break;
                    case 'Award':
                        // try figure ownership out by logs. Not that these could be inflated if users traded an item around a lot.
                        // You can edit the log typ you want to include here.
                        $logTypes = [
                            'Shop Purchase', 'Box Opened', 'Box Rewards', 'Staff Grant', 'Trade',
                            'Collected from Donation Shop', 'Unwrapped Item', 'Prompt Rewards', 'User Transfer', 'daily Rewards', 'Choice Box Opened', 'Harvesting Rewards',
                            'Choice Box Rewards', 'Collection Reward', 'Seeds for Apples Rewards', 'Award Claim'
                        ];
                        $logs = AwardLog::where('award_id', $id)->where('recipient_id', '!=', null)->whereIn('log_type', $logTypes)->get();
                        $ownedByUser = [];
                        foreach($logs as $log){
                            isset($ownedByUser[$log->recipient_id]) ? $ownedByUser[$log->recipient_id] += $log->quantity : $ownedByUser[$log->recipient_id] = $log->quantity;
                        }
                        return $ownedByUser;
                        break;
                        case 'Recipe':
                            // try figure ownership out by logs. Not that these could be inflated if users traded an item around a lot.
                            // You can edit the log typ you want to include here.
                            $logTypes = [
                                'Shop Purchase', 'Box Opened', 'Box Rewards', 'Staff Grant', 'Trade',
                                'Collected from Donation Shop', 'Unwrapped Item', 'Prompt Rewards', 'User Transfer', 'daily Rewards', 'Choice Box Opened', 'Harvesting Rewards',
                                'Choice Box Rewards', 'Collection Reward', 'Seeds for Apples Rewards', 'Award Claim'
                            ];
                            $recipes = UserRecipe::where('recipe_id', $id)->get();
                             $ownedByUser = [];
                            foreach($recipes as $recipe){
                               isset($ownedByUser[$recipe->user_id]) ? $ownedByUser[$recipe->user_id] += 1 : $ownedByUser[$recipe->user_id] = 1;
                              }
                            return $ownedByUser;
                            break;
                //add more here if needed, eg Pets/Awards/PetVariants...
        }
        return null;
    }
}
