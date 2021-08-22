{!! Form::open(['url' => 'admin/dialogue/create/child/'.$id]) !!}

<div class="form-group">
    {!! Form::label('speaker_name', 'Speaker Name:') !!}
    {!! Form::text('speaker_name', null, ['class' => 'form-control', 'placeholder' => 'Type "Username" for the user\'s name']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('speaker_type', 'Speaker Type:') !!}
            {!! Form::select('speaker_type', ['None' => 'None', 'Character' => 'Character', 'User' => 'User', 'Response' => 'Response'], null, ['class' => 'form-control', 'id' => 'speaker-type-child']) !!}
        </div>
    </div>
    <div class="col-md-6" id="speaker-group-child">

    </div>
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
    $( document ).ready(function() {   
        $('#speaker-type-child').change(function() {
            var type = $('#speaker-type-child').val();
            $.ajax({
            type: "GET", url: "{{ url('admin/dialogue/check-type') }}?type="+type, dataType: "text"
          }).done(function (res) { $("#speaker-group-child").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
        });
    });
</script>