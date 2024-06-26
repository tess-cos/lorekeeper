@extends('admin.layout')

@section('admin-title') Spell Categories @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Spell Categories' => 'admin/data/spell-categories']) !!}

<h1>Spell Categories</h1>

<p>This is a list of spell categories that will be used to sort spells in the index. Creating spell categories is entirely optional, but recommended if you have a lot of spells in the game.</p> 
<p>The sorting order reflects the order in which the spell categories will be displayed in the index, as well as on the world pages.</p>

<div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/spell-categories/create') }}"><i class="fas fa-plus"></i> Create New Spell Category</a></div>
@if(!count($recipe_categories))
    <p>No spell categories found.</p>
@else 
    <table class="table table-sm category-table">
        <tbody id="sortable" class="sortable">
            @foreach($recipe_categories as $category)
                <tr class="sort-item" data-id="{{ $category->id }}">
                    <td>
                        <a class="fas fa-arrows-alt-v handle mr-3" href="#"></a>
                        {!! $category->displayName !!}
                    </td>
                    <td class="text-right">
                        <a href="{{ url('admin/data/spell-categories/edit/'.$category->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="mb-4">
        {!! Form::open(['url' => 'admin/data/spell-categories/sort']) !!}
        {!! Form::hidden('sort', '', ['id' => 'sortableOrder']) !!}
        {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endif

@endsection

@section('scripts')
@parent
<script>

$( document ).ready(function() {
    $('.handle').on('click', function(e) {
        e.preventDefault();
    });
    $( "#sortable" ).sortable({
        items: '.sort-item',
        handle: ".handle",
        placeholder: "sortable-placeholder",
        stop: function( event, ui ) {
            $('#sortableOrder').val($(this).sortable("toArray", {attribute:"data-id"}));
        },
        create: function() {
            $('#sortableOrder').val($(this).sortable("toArray", {attribute:"data-id"}));
        }
    });
    $( "#sortable" ).disableSelection();
});
</script>
@endsection