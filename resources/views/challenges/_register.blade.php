@if($challenge)
    {!! Form::open(['url' => 'quests/new/'.$challenge->id]) !!}

    <p>This will register you for the <strong>{{ $challenge->name }}</strong> quest. You can take on {{ Settings::get('challenges_concurrent').' quest'.(Settings::get('challenges_concurrent') == 1 ? '' : 's') }} at once. Are you sure you want to register for this quest?</p>

    <div class="text-right">
        {!! Form::submit('Register', ['class' => 'btn btn-success']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid quest selected.
@endif
