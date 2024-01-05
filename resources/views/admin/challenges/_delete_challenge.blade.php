@if($challenge)
    {!! Form::open(['url' => 'admin/data/quests/delete/'.$challenge->id]) !!}

    <p>You are about to delete the quest <strong>{{ $challenge->name }}</strong>. This is not reversible. If quest logs exist under this challenge, you will not be able to delete it.</p>
    <p>Are you sure you want to delete <strong>{{ $challenge->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Quest', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid quest selected.
@endif
