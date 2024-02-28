@extends('admin.layout')

@section('admin-title') Character Dialogue Images @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Dialogue' => 'admin/dialogue', 'Character Images' => 'admin/dialogue/character-images', ($image->id ? 'Edit' : 'Create').' Image' => $image->id ? 'admin/dialogue/character-images/edit/'.$image->id : 'admin/dialogue/character-images/create']) !!}

<h1>{{ $image->id ? 'Edit' : 'Create' }} Image
    @if($image->id)
        <a href="#" class="btn btn-outline-danger float-right delete-image-button">Delete Image</a>
    @endif
</h1>

{!! Form::open(['url' => $image->id ? 'admin/dialogue/character-images/edit/'.$image->id : 'admin/dialogue/character-images/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="form-group">
    {!! Form::label('Character') !!}
    {!! Form::select('character_id', $characters, $image->character_id, ['class' => 'form-control selectize']) !!}
</div>

<div class="form-group">
    {!! Form::label('Emotion / Indentifier') !!}
    {!! Form::text('emotion', $image->emotion, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Image') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: 200px x 200px</div>
</div>

<div class="text-right">
    {!! Form::submit($image->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@endsection

@section('scripts')
@parent
<script>
    $('.selectize').selectize();
    $('.delete-image-button').click(function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/dialogue/character-images/delete') }}/{{ $image->id }}", 'Delete Image');
    });
</script>
@endsection
