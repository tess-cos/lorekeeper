@extends('admin.layout')

@section('admin-title') Dialogue @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Dialogue' => 'admin/dialogue', 'Create/Edit Dialogue' => 'admin/dialogue/create']) !!}

<h1>{{ $dialogue->id ? 'Edit' : 'Create'}} Dialogue</h1>

@if($dialogue->id)
<div class="text-right">
    <div class="btn btn-danger delete-button"><i class="fas fa-trash"></i> Delete</div>   
</div>
@endif
{!! Form::open(['url' => $dialogue->id ? 'admin/dialogue/edit/'.$dialogue->id : 'admin/dialogue/create']) !!}

@if($dialogue->id)
    <a class="btn btn-primary mb-1" data-toggle="collapse" href="#edit" role="button" aria-expanded="false" aria-controls="edit">
        Show Edit Dialogue
    </a>
    <div class="collapse multi-collapse" id="edit">
@endif
<h4>Speaker Information</h4>
<p>A speaker name is required. If you want the speaker to be a character or user, set it as such.</p>
<p>If you wish to include the currently logged in users name within the dialogue, use '{Username}', unlike the speaker type. It will only appear in the dialogue preview and page view.</p>

<div class="form-group">
    {!! Form::label('dialogue_name', 'Dialogue Name:') !!} {!! add_help('For organisational purposes.') !!}
    {!! Form::text('dialogue_name', $dialogue->dialogue_name, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('speaker_name', 'Speaker name (Optional):') !!}
    {!! Form::text('speaker_name', $dialogue->speaker_name, ['class' => 'form-control', 'placeholder' => 'Type "Username" for the user\'s name']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('speaker_type', 'Speaker Type:') !!}
            {!! Form::select('speaker_type', ['None' => 'Choose a Type', 'Character' => 'Character', 'User' => 'User', 'Response' => 'Response', 'Narration' => 'Narration'], $dialogue->speaker_type, ['class' => 'form-control', 'id' => 'speaker-type']) !!}
        </div>
    </div>
    @if($dialogue->speaker_type != 'Narration' && $dialogue->speaker_type != 'Response')
        <div class="col-md-6" id="speaker-group">
            {!! Form::label('Speaker Id:') !!} 
            {!! Form::select('speaker_id', $types, $dialogue->speaker_id, ['class' => 'form-control']) !!}
        </div>
    @elseif($dialogue->speaker_type == 'Narration')
        <div class="form-group">
            {!! Form::label('img_url', 'Dialogue Image (Optional):') !!} {!! add_help('Appears above text, unlike characters. Only works for Narration.') !!}
            {!! Form::text('img_url', $dialogue->img_url, ['class' => 'form-control']) !!}
        </div>
    @endif
</div>
<div class="form-group {{ $dialogue->image_id ? '' : 'hide' }}" id="character-emotion">
    {!! Form::label('Speaker Image:') !!} 
    {!! Form::select('image_id', $images, $dialogue->image_id, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Dialogue') !!}
    {!! Form::textarea('dialogue', $dialogue->dialogue, ['class' => 'form-control ']) !!}
</div>

<div class="text-right">
    {!! Form::submit($dialogue->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@if($dialogue->id)
    </div>

    <div class="card p-3 mb-2">
        <h3>Children</h3>
        <div class="text-right mb-3">
            <a class="btn btn-primary dialogue-child" href="#"><i class="fas fa-plus"></i> Create Child</a>
        </div>
        <div class="text-center">
            <div>
                @if($dialogue->speaker)
                <div>
                    <a href="{{ $dialogue->speaker->url }}"><img src="{{ $dialogue->image }}" class="img-thumbnail" /></a>
                </div>
                @else
                <div>
                    <h4>narrator</h4>
                </div>
                @endif
                <div class="text-center">
                <strong>{!! $dialogue->displayname !!}</strong>
                
                <p class="mb-0">
                   {{ $dialogue->dialogue }}
                </p>
                </div>
            </div>
        </div>
    </div>


    <nav class=" text-center mt-3">
        <div class="nav nav-tabs mx-auto" id="nav-tab" role="tablist">
            @foreach($dialogue->children as $child)
                <a class="nav-link  {{ $loop->first ? 'active' : '' }}" data-toggle="tab" type="a"  href="#dialogue-{{ $child->id }}" role="tab">
                    {{ strip_tags($child->displayName) }}
                    <small>- "{{ Illuminate\Support\Str::limit($child->dialogue_name ?? $child->dialogue, 10, $end='...') }}"</small>
                </a>
            @endforeach
        </div>
    </nav>
    <div class="tab-content card mt-0">
        @foreach($dialogue->children as $child)
            <div class="tab-pane fade  {{ $loop->first ? 'show active' : '' }}" id="dialogue-{{ $child->id }}">
                <div class="mx-auto body children-body children-scroll">
                    <div class="children-skill ">
                        <ul>
                            @include('admin.dialogue._dialogue_children', ['children' => $child, 'types' => $types])
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="card p-4">
        <h3>Preview</h3>
        @include('components.dialogue', ['id' => $dialogue->id])
    </div>
@endif


<script>
$( document ).ready(function() {  
    $('.selectize').selectize();
    $('#speaker-type').change(function() {
        var type = $('#speaker-type').val();
        $.ajax({
        type: "GET", url: "{{ url('admin/dialogue/check-type') }}?type="+type, dataType: "text"
        }).done(function (res) { 
            $("#speaker-group").html(res); 
            if(type != 'Character') $('#character-emotion').addClass('hide');
        }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });
    //
    $('.delete-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/dialogue/delete') }}/{{ $dialogue->id }}", 'Delete Dialogue');
    });
    //
    $('.dialogue-child').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/dialogue/create/child') }}/{{ $dialogue->id }}", 'Create Child');
    });
    // speaker id
    $('#speaker-group').change(function() {
        var id = $('#speaker-group').find(":selected").val();
        $.ajax({
        type: "GET", url: "{{ url('admin/dialogue/get-images') }}?id="+id+"&dialogue={{ $dialogue->id }}", dataType: "text"
      }).done(function (res) { $("#character-emotion").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });
});
</script>
@endsection
