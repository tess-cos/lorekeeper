@php
if(!isset($showRecipes)) $showRecipes = false;
@endphp

<div id="lootRowData" class="hide">
    
    <table class="table table-sm">
        <tbody id="lootRow">
            <tr class="loot-row">
                <td>{!! Form::select('rewardable_type[]', ['Item' => 'Item', 'Currency' => 'Currency', 'Pet' => 'Pet', 'Award' => ucfirst(__('awards.award'))] + ($showLootTables ? ['LootTable' => 'Loot Table'] : []) + ($showRaffles ? ['Raffle' => 'Raffle Ticket'] : []) + (isset($showRecipes) && $showRecipes ? ['Recipe' => 'Spell'] : []) + (isset($showThemes) && $showThemes ? ['Theme' => 'Theme'] : []), null, ['class' => 'form-control reward-type', 'placeholder' => (isset($progression) && $progression ? 'Select Progression Type' : 'Select Reward Type')]) !!}</td>
                <td class="loot-row-select"></td>
                <td>{!! Form::text('quantity[]', 1, ['class' => 'form-control']) !!}</td>
                <td class="text-right"><a href="#" class="btn btn-danger remove-loot-button">Remove</a></td>
            </tr>
        </tbody>
    </table>
    {!! Form::select('rewardable_id[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}
    {!! Form::select('rewardable_id[]', $currencies, null, ['class' => 'form-control currency-select', 'placeholder' => 'Select Currency']) !!}
    {!! Form::select('rewardable_id[]', $awards, null, ['class' => 'form-control award-select', 'placeholder' => 'Select '.ucfirst(__('awards.award'))]) !!}
    {!! Form::select('rewardable_id[]', $pets = \App\Models\Pet\Pet::orderBy('name')->pluck('name', 'id'), null, ['class' => 'form-control pet-select', 'placeholder' => 'Select Pet']) !!}
    @if($showLootTables)
        {!! Form::select('rewardable_id[]', $tables, null, ['class' => 'form-control table-select', 'placeholder' => 'Select Loot Table']) !!}
    @endif
    @if($showRaffles)
        {!! Form::select('rewardable_id[]', $raffles, null, ['class' => 'form-control raffle-select', 'placeholder' => 'Select Raffle']) !!}
    @endif
    @if(isset($showRecipes) && $showRecipes)
        {!! Form::select('rewardable_id[]', $recipes, null, ['class' => 'form-control recipe-select', 'placeholder' => 'Select Spell']) !!}
    @endif
    @if(isset($showThemes) && $showThemes)
        {!! Form::select('rewardable_id[]', $themes, null, ['class' => 'form-control theme-select', 'placeholder' => 'Select Theme']) !!}
    @endif
</div>
