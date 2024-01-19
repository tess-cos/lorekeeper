@extends('home.layout')

@section('home-title') Spellcasting @endsection

@section('home-content')
{!! breadcrumbs(['Spellcasting' => 'crafting']) !!}

<h1>
    Spellbook
</h1>
<p> A catalog of spells you have unlocked as well as basic spells. </p>

<hr>

<h3>Basic Spells</h3>
@if($default->count())
    <div class="row mx-0">
        @foreach($default as $recipe)
            @include('home.crafting._smaller_recipe_card', ['recipe' => $recipe])
        @endforeach
    </div>
@else
    There are no basic spells.
@endif

<hr>

<h3>Unlocked Spells</h3>
@if(Auth::user()->recipes->count())
<div class="card character-bio">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
            @foreach($userRecipes as $categoryId=>$categoryrecipes)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="categoryTab-{{ isset($categories[$categoryId]) ? $categoryId : 'misc'}}" data-toggle="tab" href="#category-{{ isset($categories[$categoryId]) ? $categoryId : 'misc'}}" role="tab">
                        {!! isset($categories[$categoryId]) ? $categories[$categoryId]->name : 'Miscellaneous' !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body tab-content">
        @foreach($userRecipes as $categoryId=>$categoryrecipes)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="category-{{ isset($categories[$categoryId]) ? $categoryId : 'misc'}}">
                @foreach($categoryrecipes->chunk(4) as $chunk)
                @foreach($chunk as $recipe)
                @include('home.crafting._smaller_recipe_card', ['recipe' => $recipe])
                @endforeach
                @endforeach
            </div>
        @endforeach
    </div>
</div>

@else
    You haven't unlocked any spells!
@endif
<div class="text-right mb-4">
    <a href="{{ url(Auth::user()->url.'/spell-logs') }}">View logs...</a>
</div>


@endsection


@section('scripts')
<script>
$( document ).ready(function() {
    $('.btn-craft').on('click', function(e) {
        e.preventDefault();
        var $parent = $(this).parent().parent().parent();
        loadModal("{{ url('spellcasting/craft') }}/" + $parent.data('id'), $parent.data('name'));
    });
});
</script>
@endsection
