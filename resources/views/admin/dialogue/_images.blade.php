{!! Form::label('Speaker Image:') !!} 
{!! Form::select('image_id', $images, $dialogue ? $dialogue->image_id : null, ['class' => 'form-control selectize']) !!}