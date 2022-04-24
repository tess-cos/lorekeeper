@if($type != 'Narration')
{!! Form::label('Speaker Id:') !!} 
{!! Form::select('speaker_id', $types, null, ['class' => 'form-control selectize', 'id' => 'speaker-type']) !!}

@if($type == 'Character')
    <script>
        $('#character-emotion').removeClass('hide');
    </script>
@else 
    <script>
        $('#character-emotion').addClass('hide');
    </script>
@endif

@else

<div class="form-group">
    {!! Form::label('img_url', 'Dialogue Image (Optional):') !!} {!! add_help('Appears above text, unlike characters. Only works for Narration.') !!}
    {!! Form::text('img_url', null, ['class' => 'form-control']) !!}
</div>

@endif

<script>
    $('.selectize').selectize();
</script>