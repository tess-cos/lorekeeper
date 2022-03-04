@extends('account.layout')

@section('account-title') Settings @endsection

@section('account-content')
{!! breadcrumbs(['My Account' => Auth::user()->url, 'Settings' => 'account/settings']) !!}

<h1>Settings</h1>


<div class="card p-3 mb-2">
    <h3>Avatar</h3>
    <div class="text-left"><div class="alert alert-warning">Please note a hard refresh may be required to see your updated avatar. Also please note that uploading a .gif will display a 500 error after; the upload should still work, however.</div></div>
    @if(Auth::user()->isStaff)
        <div class="alert alert-danger">For admins - note that .GIF avatars leave a tmp file in the directory (e.g php2471.tmp). There is an automatic schedule to delete these files.
        </div>
    @endif
    <form enctype="multipart/form-data" action="avatar" method="POST">
        <label>Update Profile Image</label><br>
        <input type="file" name="avatar">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="pull-right btn btn-sm btn-primary">
    </form>
</div>


<div class="card p-3 mb-2">
    <h3>Profile</h3>
    {!! Form::open(['url' => 'account/profile']) !!}
        <div class="form-group">
            {!! Form::label('text', 'Profile Text') !!}
            {!! Form::textarea('text', Auth::user()->profile->text, ['class' => 'form-control wysiwyg']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="card p-3 mb-2">
    <h3>Birthday Publicity</h3>
    {!! Form::open(['url' => 'account/dob']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Setting</label>
            <div class="col-md-10">
                {!! Form::select('birthday_setting', ['0' => '0: No one can see your birthday.', '1' => '1: Members can see your day and month.', '2' => '2: Anyone can see your day and month.', '3' => '3: Full date public.'],Auth::user()->settings->birthday_setting, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="card p-3 mb-2">
    <h3>Email Address</h3>
    <p>Changing your email address will require you to re-verify your email address.</p>
    {!! Form::open(['url' => 'account/email']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Email Address</label>
            <div class="col-md-10">
                {!! Form::text('email', Auth::user()->email, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="card p-3 mb-2">
    <h3>Change Password</h3>
    {!! Form::open(['url' => 'account/password']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Old Password</label>
            <div class="col-md-10">
                {!! Form::password('old_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">New Password</label>
            <div class="col-md-10">
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Confirm New Password</label>
            <div class="col-md-10">
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
</div>

<div class="card p-3 mb-2">
    <h3>Accessibility</h3>
    <hr class="w-50">
    <h4>Dialogue Text Speed</h4>
    {!! Form::open(['url' => 'account/text-speed']) !!}
        <p>Default text speed is 30. The lower the number the faster the type speed is.</p>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Text Speed</label>
            <div class="col-md-10">
                {!! Form::text('text_speed', Auth::user()->settings->text_speed, ['class' => 'form-control text-speed']) !!}
            </div>
        </div>
        <h5>Preview</h5>
        <div class="card p-3" id="preview">
            &nbsp;
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary mt-2']) !!}
        </div>
    {!! Form::close() !!}
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        let speed = "<?php echo Auth::user()->settings->text_speed; ?>";
        let target = document.getElementById('preview');
        $('.text-speed').change(function() {
            speed = $(this).val();
        });

        // call typewrite function and once typewrite is complete wait three seconds before calling it again
        setInterval(function() {
            target.innerHTML = '&nbsp;';
            typeWrite();
        }, 3000);
        
        function typeWrite() {
            // (A) SET DEFAULT OPTIONS
            text = 'This is a preview.'
            // (B) DRAW TYPEWRITER
            let pointer = 0;
            setInterval(function() {
                pointer++;
                if (pointer <= text.length) {
                    target.innerHTML = text.substring(0, pointer);
                } 
            }, speed);
        }
    });
</script>
@endsection