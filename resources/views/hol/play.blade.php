<div class="text-center">
    <p>You grab a bundle, noticing the number <strong>{{ $number }}</strong> written on the top in Malcolm's fancy handwriting.</p>
    <p>What do you think? Are the actual number of letters <strong>more</strong> or <strong>less</strong>?
    </p>
    {!! Form::open(['url' => 'malcolms-mailpile/play/guess']) !!}
    {!! Form::hidden('number', $number) !!}
    {!! Form::hidden('guess', 'higher') !!}
    <div class="form-group">
        {!! Form::submit('More', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

    {!! Form::open(['url' => 'malcolms-mailpile/play/guess']) !!}
    {!! Form::hidden('number', $number) !!}
    {!! Form::hidden('guess', 'lower') !!}
    <div class="form-group">
        {!! Form::submit('Less', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
</div>
