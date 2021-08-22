{!! Form::open(['url' => 'admin/dialogue/edit/child/'.$dialogue->id]) !!}
<h4>Speaker Information</h4>
<p>A speaker name is required. If you want the speaker to be a character or user, set it as such.</p>

<div class="form-group">
    {!! Form::label('speaker_name', 'Speaker Name:') !!}
    {!! Form::text('speaker_name', $dialogue->speaker_name, ['class' => 'form-control', 'placeholder' => 'Type "Username" for the user\'s name']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('speaker_type', 'Speaker Type:') !!}
            {!! Form::select('speaker_type', ['None' => 'None', 'Character' => 'Character', 'User' => 'User', 'Response' => 'Response'], $dialogue->speaker_type, ['class' => 'form-control', 'id' => 'speaker-type-edit']) !!}
        </div>
    </div>
    <div class="col-md-6" id="speaker-group-edit">
        {!! Form::label('Speaker Id:') !!} 
        {!! Form::select('speaker_id', $types, $dialogue->speaker_id, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('Dialogue') !!}
    {!! Form::textarea('dialogue', $dialogue->dialogue, ['class' => 'form-control']) !!}
</div>

<div class="text-right">
    {!! Form::submit($dialogue->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

<script>
$( document ).ready(function() {   
    $('#speaker-type-edit').change(function() {
        var type = $('#speaker-type-edit').val();
        $.ajax({
        type: "GET", url: "{{ url('admin/dialogue/check-type') }}?type="+type, dataType: "text"
      }).done(function (res) { $("#speaker-group-edit").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });
});
</script>