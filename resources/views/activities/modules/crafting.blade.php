
@foreach ($recipes as $recipe)
<div style="margin: auto; margin-top: -10px; margin-left: -10px;">@if ($activity->service->checkRecipe(Auth::user(), $recipe))
<div class="mt-2 text-center" style="padding: 12.5px !important; padding-bottom: 2.5px !important; margin-left: 15px;">
                <h5>{{ $recipe->name }}</h5>
            </div>
                    <div class="square-grid @if (count($recipes) === 1) lg @else xl @endif justify-content-start">
                        @foreach ($recipe->reward_items as $type)
                            @foreach ($type as $reward)
                                <div class="square-column text-center" style="max-width: 50%; margin-bottom: 5px; display: none;">
                                    @if (isset($reward['asset']->image_url))
                                        <div class="img-thumbnail greyscale"><img style="max-width: 100px;" src="{{ $reward['asset']->image_url }}" /></div>
                                    @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                    {!! Form::open(['url' => 'activities/' . $activity->id . '/act']) !!}
                    {!! Form::hidden('recipe_id', $recipe->id) !!}
                    <div class="text-center">
                        {!! Form::submit('Submit', ['class' => 'btn btn-success btn-md ml-3']) !!}
                    </div>
                    {!! Form::close() !!}
                @else
                    <div style="padding: 15px; margin-bottom: -35px; margin-top: 15px;"><div class="alert alert-warning p-1 px-2 ml-2 text-center">
                        You don't have everything for this activity yet!
                        </div></div>
                @endif</div>
                @endforeach
<div class="row no-gutters" @if (count($recipes) > 1) style="font-size: 10px" @endif>
    @foreach ($recipes as $recipe)
        <div @class([
            'col-12' => count($recipes) === 1,
            'col-12' => count($recipes) > 1,
        ])>
            <div class="d-flex mt-2">
                <h2 style="display: none;">{{ $recipe->name }}</h2>
            </div>
            <div class="d-flex" style="gap: 10px; display: none !important;">
                <div style="flex: 1;">
            <div class="d-flex mt-4">
                <h2>{{ $recipe->name }}</h2>
                @if ($recipe->checkLimit($recipe, Auth::user()))
                    @if ($activity->service->checkRecipe(Auth::user(), $recipe))
                        {!! Form::open(['url' => 'activities/' . $activity->id . '/act']) !!}
                        {!! Form::hidden('recipe_id', $recipe->id) !!}
                        <div class="text-right">
                            {!! Form::submit('Craft!', ['class' => 'btn btn-success btn-sm ml-3']) !!}
                        </div>
                        {!! Form::close() !!}
                    @else
                        <div class="alert alert-warning p-1 px-2 ml-2 text-center">
                            You don't have everything for this spell yet!
                        </div>
                    @endif
                @endif
            </div>
            @if ($recipe->checkLimit($recipe, Auth::user()) && isset($recipe->limit) && isset($recipe->limit_period))
                <div class="alert alert-info p-1 px-2 ml-2 text-center">You can craft this recipe {{ $recipe->limit }} time(s)
                    {{ $recipe->limit_period ? ' per ' . strtolower($recipe->limit_period) : '' }}.</div>
            @else
            <div class="alert alert-danger p-1 px-2 ml-2 text-center">
                        You have already casted this spell the maximum number of times.
                    </div>
            @endif
            <div class="d-flex" style="gap: 10px;">
                <div style="flex: 1">
                    <div class="square-grid @if (count($recipes) === 1) lg @else xl @endif justify-content-end">
                        @foreach ($recipe->ingredients as $ingredient)
                            <div class="square-column text-center">
                                @switch($ingredient->ingredient_type)
                                    @case('Item')
                                        @php
                                            $user = Auth::user();
                                            $userOwned = intval(
                                                \App\Models\User\UserItem::where('user_id', $user->id)
                                                    ->where('item_id', $ingredient->ingredient->id)
                                                    ->where('count', '>', 0)
                                                    ->sum('count'),
                                            );
                                        @endphp
                                        @if ($userOwned > $ingredient->quantity)
                                            <div class="img-thumbnail" style="border: 1px solid grey;"><img src="{{ $ingredient->ingredient->image_url }}" /></div>
                                        @else
                                            <div class="img-thumbnail"><img class="greyscale" src="{{ $ingredient->ingredient->image_url }}" /></div>
                                        @endif
                                    @break

                                    @case('Currency')
                                        @php
                                            $user = Auth::user();
                                            $userOwned = \App\Models\User\UserCurrency::where('user_id', $user->id)
                                                ->where('currency_id', $ingredient->ingredient->id)
                                                ->where('quantity', '>', 0)
                                                ->sum('quantity');
                                        @endphp
                                        @if ($userOwned > $ingredient->quantity)
                                            <div class="img-thumbnail" style="border: 1px solid grey;"><img src="{{ $ingredient->ingredient->currencyIconUrl }}" /></div>
                                        @else
                                            <div class="img-thumbnail"><img class="greyscale" src="{{ $ingredient->ingredient->currencyIconUrl }}" /></div>
                                        @endif
                                    @break

                                    @case('Pet')
                                        @php
                                            $user = Auth::user();
                                            $userOwned = intval(
                                                \App\Models\User\UserPet::where('user_id', $user->id)
                                                    ->where('pet_id', $ingredient->ingredient->id)
                                                    ->where('count', '>', 0)
                                                    ->sum('count'),
                                            );
                                        @endphp
                                        @if ($userOwned > $ingredient->quantity)
                                            <div class="img-thumbnail" style="border: 1px solid grey;"><img style="max-width: 150px;" src="{{ $ingredient->ingredient->image_url }}" /></div>
                                        @else
                                            <div class="img-thumbnail"><img class="greyscale" style="max-width: 150px;" src="{{ $ingredient->ingredient->image_url }}" /></div>
                                        @endif
                                    @break
                                @endswitch
                                <div class="text-center">{!! $ingredient->ingredient->displayName !!} x{{ $ingredient->quantity }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center"><i style="font-size: 2rem;" class="asp fas fa-random"></i></div>
                <div style="flex: 1">
                    <div class="square-grid @if (count($recipes) === 1) lg @else xl @endif justify-content-start">
                        @foreach ($recipe->reward_items as $type)
                            @foreach ($type as $reward)
                                <div class="square-column text-center">
                                    @if (isset($reward['asset']->image_url))
                                        <div class="img-thumbnail greyscale"><img src="{{ $reward['asset']->image_url }}" /></div>
                                    @endif
                                    <div class="text-center">{!! $reward['asset']->displayName !!} x{{ $reward['quantity'] }}</div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
