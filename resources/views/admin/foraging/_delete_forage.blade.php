@if($table)
    {!! Form::open(['url' => 'admin/data/travels/delete/'.$table->id]) !!}

    <p>You are about to delete the travel location <strong>{{ $table->name }}</strong>. This is not reversible.</p>
    <p>Are you sure you want to delete <strong>{{ $table->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Travel Location', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else 
    Invalid travel location selected.
@endif