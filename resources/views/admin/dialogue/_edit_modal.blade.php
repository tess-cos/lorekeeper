{!! Form::open(['url' => 'admin/dialogue/edit/child/'.$dialogue->id]) !!}
<h4>Speaker Information</h4>
<p>A speaker name is required. If you want the speaker to be a character or user, set it as such.</p>
<p>If you wish to include the currently logged in users name within the dialogue, use '{Username}', unlike the speaker type. It will only appear in the dialogue preview and page view.</p>

<div class="form-group">
    {!! Form::label('dialogue_name', 'Dialogue Name (Optional):') !!} {!! add_help('Used for the response name.') !!}
    {!! Form::text('dialogue_name', $dialogue->dialogue_name, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('speaker_name', 'Speaker name (Optional):') !!}
    {!! Form::text('speaker_name', $dialogue->speaker_name, ['class' => 'form-control', 'placeholder' => 'Type "Username" for the user\'s name']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('speaker_type', 'Speaker Type:') !!}
            {!! Form::select('speaker_type', ['Character' => 'Character', 'User' => 'User', 'Response' => 'Response', 'Narration' => 'Narration'], $dialogue->speaker_type, ['class' => 'form-control', 'id' => 'speaker-type-edit']) !!}
        </div>
    </div>
    <div class="col-md-6" id="speaker-group-edit">
        @if($dialogue->speaker_type != 'Narration' && $dialogue->type != 'Response')
            {!! Form::label('Speaker Id:') !!} 
            {!! Form::select('speaker_id', $types, $dialogue->speaker_id, ['class' => 'form-control']) !!}
        @elseif($dialogue->speaker_type == 'Narration')
            {!! Form::label('img_url', 'Dialogue Image (Optional):') !!} {!! add_help('Appears above text, unlike characters. Only works for Narration.') !!}
            {!! Form::text('img_url', $dialogue->img_url, ['class' => 'form-control']) !!}
        @endif
    </div>
</div>
<div class="form-group" id="character-emotion">
    @if($dialogue->type == 'Character')
        {!! Form::label('Speaker Image:') !!} 
        {!! Form::select('image_id', $images, $dialogue->image_id, ['class' => 'form-control']) !!}
    @endif
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
$('.selectize').selectize();
$( document ).ready(function() {   
    $('#speaker-type-edit').change(function() {
        var type = $('#speaker-type-edit').val();
        $.ajax({
        type: "GET", url: "{{ url('admin/dialogue/check-type') }}?type="+type, dataType: "text"
      }).done(function (res) { $("#speaker-group-edit").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });
    // speaker id
    $('#speaker-group').change(function() {
    var id = $('#speaker-group-edit').find(":selected").val();
    $.ajax({
        type: "GET", url: "{{ url('admin/dialogue/get-images') }}?id="+id, dataType: "text"
    }).done(function (res) { $("#character-emotion").html(res); }).fail(function (jqXHR, textStatus, errorThrown) { alert("AJAX call failed: " + textStatus + ", " + errorThrown); });
    });
});
</script>