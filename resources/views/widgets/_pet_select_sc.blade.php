<h3>Your Pets <a class="small pet-collapse-toggle collapse-toggle" href="#userPet" data-toggle="collapse">Show</a></h3>
<div class="card mb-3 collapse" id="userPet">
    <div class="card-body">
        <div class="text-right mb-3">
            <div class="d-inline-block">
                {!! Form::label('item_category_id', 'Filter:', ['class' => 'mr-2']) !!}
                <select class="form-control d-inline-block w-auto" id="userItemCategory">
                    <option value="all">All Categories</option>
                    <option value="selected">Selected Items</option>
                    <option disabled>&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;&#9472;</option>
                    <option value="0">Miscellaneous</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-inline-block">
                {!! Form::label('item_category_id', 'Action:', ['class' => 'ml-2 mr-2']) !!}
                <a href="#" class="btn btn-primary pet-select-all">Select All Visible</a>
                <a href="#" class="btn btn-primary pet-clear-selection">Clear Visible Selection</a>
            </div>
        </div>
        <div id="userItems" class="user-pets">
            <div class="row">
                @foreach ($pets as $item)
                    <div class="col-lg-2 col-sm-3 col-6 mb-3 user-pet category-all category-{{ $item->pet->item_category_id ?: 0 }} {{ isset($selected) && array_key_exists('pet'.$item->id, $selected) ? 'category-selected' : '' }} {{ $item->chara_id != NULL ? '' : 'select-disabled' }}" data-id="{{ $item->id }}"
                        data-name="{{ $user->name }}'s {{ $item->pet->name }} ">
                        <div class="text-center pet-item {{ $item->chara_id == NULL ? '' : 'disabled' }}"
                        @if (!$item->chara_id == NULL) data-toggle="tooltip" title="This pet is currently attached to a character. Be careful!" @endif>
                            <div class="mb-1">
                                <a class="pet-stack"><img src="{{ $item->pet->imageUrl }}" /></a>
                            </div>
                            <div>
                                <a class="pet-stack pet-stack-name"><span style="color: #95b582; font-weight: 600;">{!!$item->pet_name !!}</span> {{ $item->pet->name }}</a><br />
                                {!! Form::checkbox(isset($fieldName) && $fieldName ? $fieldName : 'pet_stack_id[]', $item->id, isset($selected) && array_key_exists('pet'.$item->id, $selected) ? false : false, ['class' => 'pet-checkbox show']) !!}
                            </div>
                            <div>
                                <a href="#" class="btn btn-xs btn-outline-info pet-info">Info</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>