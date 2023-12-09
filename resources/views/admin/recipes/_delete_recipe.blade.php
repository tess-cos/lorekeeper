@if($recipe)
    {!! Form::open(['url' => 'admin/data/recipes/delete/'.$recipe->id]) !!}

    <p>You are about to delete the spell <strong>{{ $recipe->name }}</strong>. This is not reversible. If this spell exists in at least one user's possession, you will not be able to delete this spell.</p>
    <p>Are you sure you want to delete <strong>{{ $recipe->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Spell', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else 
    Invalid spell selected.
@endif