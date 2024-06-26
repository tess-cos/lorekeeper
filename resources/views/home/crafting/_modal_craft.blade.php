@if(!$recipe)
    <div class="text-center">Invalid spell selected.</div>
@else
    @if ($recipe->imageUrl)
        <div class="text-center">
            <div class="mb-3"><img class="recipe-image" src="{{ $recipe->imageUrl }}" /></div>
        </div>
    @endif
    <h3>Spell Details <a class="small inventory-collapse-toggle collapse-toggle" href="#recipeDetails" data-toggle="collapse">Show</a></h3>
    <hr>
    @if ($recipe->checkLimit($recipe, Auth::user()) && isset($recipe->limit) && isset($recipe->limit_period))
        <div class="alert alert-info text-center">You can cast this spell {{ $recipe->limit }} time(s)
            {{ $recipe->limit_period ? ' per ' . strtolower($recipe->limit_period) : '' }}.</div>
    @endif
    <div class="collapse show" id="recipeDetails">
        <div class="row">
            @if ($recipe->is_limited)
                <div class="col-md-12">
                    <h5>Requirements</h5>

                    <div class="alert alert-warning" style="background-color: #f4e3e6 !important;">
                        <?php
                        $limits = [];
                        foreach ($recipe->limits as $limit) {
                            $name = $limit->reward->name;
                            $quantity = $limit->quantity > 1 ? $limit->quantity . ' ' : '';
                            $limits[] = $quantity . $name;
                        }
                        echo implode(', ', $limits);
                        ?>
                    </div>
                </div>
            @endif
            <div class="col-md-6">
                <h5>Subjects</h5>
                @foreach($recipe->ingredients as $ingredient)
                    <div class="alert alert-recipe cc-5" style="background-color: #FBF5F6;">
                        @include('home.crafting._recipe_ingredient_entry', ['ingredient' => $ingredient])
                    </div>
                @endforeach
            </div>
            <div class="col-md-6">
                <h5>Rewards</h5>
                @foreach($recipe->reward_items as $type)
                    @foreach($type as $item)
                        <div class="alert alert-recipe cc-5" style="background-color: #FBF5F6;">
                            @include('home.crafting._recipe_reward_entry', ['reward' => $item])
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
    @if ($recipe->checkLimit($recipe, Auth::user()))
    @if($selected || $recipe->onlyCurrency)
        {{-- Check if sufficient ingredients have been selected? --}}
        {!! Form::open(['url' => 'spellcasting/craft/' . $recipe->id]) !!}
        @include('widgets._inventory_select', ['user' => Auth::user(), 'inventory' => $inventory, 'categories' => $categories, 'selected' => $selected, 'page' => $page])
        @include('widgets._pet_select_sc', ['user' => Auth::user(), 'pets' => $pets, 'categories' => $categories, 'selected' => $selected, 'page' => $page])
        <div class="text-right">
            {!! Form::submit('Cast', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    @else
        <div class="alert alert-danger">You do not have all of the required spell subjects.</div>
    @endif
    @else
    <div class="alert alert-danger">
            You have already casted this spell the maximum number of times.
        </div>
    @endif
@endif

@include('widgets._inventory_select_js')
@include('widgets._pet_select_sc_js')
<script>
    $(document).keydown(function(e) {
        var code = e.keyCode || e.which;
        if (code == 13)
            return false;
    });
</script>
