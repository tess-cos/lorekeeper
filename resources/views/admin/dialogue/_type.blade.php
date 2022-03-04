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

<script>
    $('.selectize').selectize();
</script>