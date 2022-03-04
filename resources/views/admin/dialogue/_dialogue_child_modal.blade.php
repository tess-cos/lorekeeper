{!! Form::open(['url' => 'admin/dialogue/create/child/'.$id]) !!}

<div class="form-group">
    {!! Form::label('speaker_name', 'Speaker Name (Optional):') !!}
    {!! Form::text('speaker_name', null, ['class' => 'form-control', 'placeholder' => 'Type "Username" for the user\'s name']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('speaker_type', 'Speaker Type:') !!}
            {!! Form::select('speaker_type', ['None' => 'Choose a Type', 'Character' => 'Character', 'User' => 'User', 'Response' => 'Response', 'Narration' => 'Narration'], null, ['class' => 'form-control', 'id' => 'speaker-type-child']) !!}
        </div>
    </div>
    <div class="col-md-6" id="speaker-group-child">

    </div>
</div>
<div class="form-group" id="character-emotion-child">
</div>

<div class="form-group">
    {!! Form::label('Dialogue') !!}
    {!! Form::textarea('dialogue', null, ['class' => 'form-control']) !!}
</div>

<div class="text-right">
    {!! Form::submit('Create Child', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

<script>
    $('.selectize').selectize();
    $( document ).ready(function() {   
        $('#speaker-type-child').change(function() {
            var type = $('#speaker-type-child').val();
            $.ajax({
            type: "GET", url: "{{ url('admin/dialogue/check-type') }}?type="+type, dataType: "text"
          }).done(function (res) { $("#speaker-group-child").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
        });
        // speaker id
        $('#speaker-group-child').change(function() {
            var id = $('#speaker-group-child').find(":selected").val();
            if(id) {
                $.ajax({
                    type: "GET", url: "{{ url('admin/dialogue/get-images') }}?id="+id, dataType: "text"
                }).done(function (res) { $("#character-emotion-child").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
            }
        });
    });
</script>