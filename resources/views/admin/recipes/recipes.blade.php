@extends('admin.layout')

@section('admin-title') Spells @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Spells' => 'admin/data/spells']) !!}

<h1>Spells</h1>

<p>This is a list of spells in the game that can be used to create items.</p> 

<div class="text-right mb-3"><a class="btn btn-primary" href="{{ url('admin/data/spell-categories') }}"><i class="fas fa-folder"></i> Spell Categories</a>
    <a class="btn btn-primary" href="{{ url('admin/data/spells/create') }}"><i class="fas fa-plus"></i> Create New Spell</a>
</div>
<div>
    {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

@if(!count($recipes))
    <p>No spells found.</p>
@else 
    {!! $recipes->render() !!}
    <table class="table table-sm category-table">
        <thead>
            <tr>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($recipes as $recipe)
                <tr class="sort-item" data-id="{{ $recipe->id }}">
                    <td>
                        {{ $recipe->name }}
                    </td>
                    <td class="text-right">
                        <a href="{{ url('admin/data/spells/edit/'.$recipe->id) }}" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $recipes->render() !!}
@endif

@endsection

@section('scripts')
@parent
@endsection