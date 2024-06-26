<div id="ingredientRowData" class="hide">
    <table class="table table-sm">
        <tbody id="ingredientRow">
            <tr class="ingredient-row">
                <td>{!! Form::select('ingredient_type[]', ['Item' => 'Item', 'MultiItem' => 'Multi Item', 'Category' => 'Category', 'MultiCategory' => 'Multi Category', 'Currency' => 'Currency', 'Pet' => 'Pet', 'MultiPet' => 'Multi Pet', 'PetCategory' => 'Pet Category', 'MultiPetCategory' => 'Multi Pet Category'], null, [
                    'class' => 'form-control ingredient-type',
                    'placeholder' => 'Select Subject Type',
                ]) !!}</td>
                <td class="ingredient-row-select"></td>
                <td>{!! Form::text('ingredient_quantity[]', 1, ['class' => 'form-control ingredient-quantity']) !!}</td>
                <td class="text-right"><a href="#" class="btn btn-danger remove-ingredient-button">Remove</a></td>
            </tr>
        </tbody>
    </table>

    {!! Form::select('ingredient_data[]', $items, null, ['class' => 'form-control item-select', 'placeholder' => 'Select Item']) !!}

    <div class="multi-item-select-group">
        <div class="multi-item-list">
            <div class="mb-2">
                {!! Form::select('ingredient_data[][]', $items, null, ['class' => 'form-control multi-item-select', 'placeholder' => 'Select Item']) !!}
                <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger hide">Remove Item</a></div>
            </div>
        </div>
        <a href="#" class="btn btn-primary add-multi-item-button mb-2">Add Item</a>
    </div>

    {!! Form::select('ingredient_data[]', $categories, null, ['class' => 'form-control category-select', 'placeholder' => 'Select Category']) !!}

    <div class="multi-category-select-group">
        <div class="multi-category-list">
            <div class="mb-2">
                {!! Form::select('ingredient_data[][]', $categories, null, ['class' => 'form-control multi-category-select', 'placeholder' => 'Select Category']) !!}
                <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger hide">Remove Category</a></div>
            </div>
        </div>
        <a href="#" class="btn btn-primary add-multi-category-button mb-2">Add Category</a>
    </div>

    {!! Form::select('ingredient_data[]', $currencies, null, ['class' => 'form-control currency-select', 'placeholder' => 'Select Currency']) !!}

    
    {!! Form::select('ingredient_data[]', $pets, null, ['class' => 'form-control pet-select', 'placeholder' => 'Select Pet']) !!}

    <div class="multi-pet-select-group">
        <div class="multi-pet-list">
            <div class="mb-2">
                {!! Form::select('ingredient_data[][]', $pets, null, ['class' => 'form-control multi-pet-select', 'placeholder' => 'Select Pet']) !!}
                <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger hide">Remove Pet</a></div>
            </div>
        </div>
        <a href="#" class="btn btn-primary add-multi-pet-button mb-2">Add Pet</a>
    </div>

    {!! Form::select('ingredient_data[]', $petCategories, null, ['class' => 'form-control pet-category-select', 'placeholder' => 'Select Category']) !!}

    <div class="multi-pet-category-select-group">
        <div class="multi-pet-category-list">
            <div class="mb-2">
                {!! Form::select('ingredient_data[][]', $petCategories, null, ['class' => 'form-control multi-pet-category-select', 'placeholder' => 'Select Category']) !!}
                <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger hide">Remove Pet Category</a></div>
            </div>
        </div>
        <a href="#" class="btn btn-primary add-multi-pet-category-button mb-2">Add Pet Category</a>
    </div>



    <div class="multi-item-entry mb-2">
        {!! Form::select('ingredient_data[][]', $items, null, ['class' => 'form-control multi-item-select', 'placeholder' => 'Select Item']) !!}
        <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger">Remove Item</a></div>
    </div>
    <div class="multi-category-entry mb-2">
        {!! Form::select('ingredient_data[][]', $categories, null, ['class' => 'form-control multi-category-select', 'placeholder' => 'Select Category']) !!}
        <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger">Remove Category</a></div>
    </div>
    <div class="multi-pet-entry mb-2">
        {!! Form::select('ingredient_data[][]', $pets, null, ['class' => 'form-control multi-pet-select', 'placeholder' => 'Select Item']) !!}
        <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger">Remove Pet</a></div>
    </div>
    <div class="multi-pet-category-entry mb-2">
        {!! Form::select('ingredient_data[][]', $petCategories, null, ['class' => 'form-control multi-pet-category-select', 'placeholder' => 'Select Item']) !!}
        <div class="text-right text-uppercase" style="margin-top: -0.5em;"><a href="#" class="remove-multi-entry-button text-danger">Remove Pet</a></div>
    </div>
</div>
