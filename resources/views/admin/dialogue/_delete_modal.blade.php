@if($dialogue)
    {!! Form::open(['url' => 'admin/dialogue/delete/'.$dialogue->id]) !!}

    <p>You are about to delete the dialogue from {{ $dialogue->speaker_name }}, ID #{{$dialogue->id}}. This is not reversible.</p>
    <p>Are you sure you want to delete this dialogue tree?</p>

    <div class="text-right">
        {!! Form::submit('Delete Dialogue', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else 
    Invalid dialogue selected.
@endif