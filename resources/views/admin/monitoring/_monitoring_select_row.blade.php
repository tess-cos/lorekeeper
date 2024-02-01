<div id="lootRowData" class="hide">
    {!! Form::select('object_id', $items, null, ['class' => 'form-control item-select w-100', 'placeholder' => 'Select Item']) !!}
    {!! Form::select('object_id', $currencies, null, ['class' => 'form-control currency-select w-100', 'placeholder' => 'Select Currency']) !!}
    {!! Form::select('object_id', $pets, null, ['class' => 'form-control pet-select w-100', 'placeholder' => 'Select Pet']) !!}
    {!! Form::select('object_id', $awards, null, ['class' => 'form-control award-select w-100', 'placeholder' => 'Select Memento']) !!}
    {!! Form::select('object_id', $recipes, null, ['class' => 'form-control recipe-select w-100', 'placeholder' => 'Select Spell']) !!}
    {!! Form::select('object_id', $raffles, null, ['class' => 'form-control raffle-select w-100', 'placeholder' => 'Select Raffle']) !!}
</div>