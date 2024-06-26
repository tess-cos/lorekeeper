@if($image)
    {!! Form::open(['url' => 'admin/dialogue/character-images/delete/'.$image->id]) !!}

    <p>You are about to delete the image for the emotion {{$image->emotion}} for {!! $image->character->displayName !!}.</p>
    <p>Are you sure you want to delete this?</p>

    <div class="text-right">
        {!! Form::submit('Delete Image', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else 
    Invalid image selected.
@endif