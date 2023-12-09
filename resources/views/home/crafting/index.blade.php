@extends('home.layout')

@section('home-title') Crafting @endsection

@section('home-content')
{!! breadcrumbs(['Crafting' => 'crafting']) !!}

<h1>
    Spellbook
</h1>
<p> A catalog of spells you have unlocked along with basic spells. </p>

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
    <div class="row mx-0">
        @foreach(Auth::user()->recipes as $recipe)
            @include('home.crafting._smaller_recipe_card', ['recipe' => $recipe])
        @endforeach
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
        loadModal("{{ url('crafting/craft') }}/" + $parent.data('id'), $parent.data('name'));
    });
});
</script>
@endsection
