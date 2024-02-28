@extends('admin.layout')

@section('admin-title') Dialogue @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Dialogue' => 'admin/dialogue', 'Character Images' => 'admin/dialogue/character-images']) !!}

<h1>Character Image</h1>

<p>This is a list of all unique emote images a character has. They are grouped by character.</p>

<div class="text-right mb-3">
    <a class="btn btn-primary" href="{{ url('admin/dialogue/character-images/create') }}"><i class="fas fa-plus"></i> Create New Character Image</a>
</div>

@if(!count($characters))
    <p>No character dialogue images found.</p>
@else
    @foreach($characters as $character)
    <div class="card mb-4 p-2">
    <h3>{!! $character->displayname !!}</h3>
        <div class="row col-12">
        @foreach($character->dialogueImages as $image)
            <div class="col-md-3 text-center p-2">
                <img src="{{$image->imageUrl }}" style="max-width: 25%;">
                <br>
                {!! $image->emotion !!}
                <br>
                <a class="btn btn-primary" href="{{ url('admin/dialogue/character-images/edit/'.$image->id) }}"><i class="fas fa-pencil-alt"></i> Edit</a>
            </div>
        @endforeach
        </div>
    </div>
    @endforeach
@endif

@endsection

@section('scripts')
@parent
@endsection
