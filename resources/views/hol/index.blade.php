@extends('home.layout')

@section('title')
    Malcolm's Mailpile
@endsection

@section('content')
    {!! breadcrumbs([ucfirst(__('dailies.dailies')) => __('dailies.dailies'), 'Malcolm\'s Mailpile' => 'malcolms-mailpile']) !!}
    
    <h1>Malcolm's Mailpile</h1>
    <h4><span class="badge bg-warning" style="padding:5px;"><i class="fa-solid fa-clipboard"></i> you have <strong>{{ $user->settings->hol_plays }}</strong> bundles left.</span></h4>
    <div class="text-center game">

<img src="https://i.imgur.com/viHFeuV.png" style="margin: auto; padding: 5px; width: 100%; max-width: 500px;">

        <p>If there's one thing Malcolm has a lot of, it's mail. So much, in fact, you have decided to volunteer to help organize the evergrowing pile.

    Malcolm tends to bundle the letters together and write how many are in each bundle for later reading, but sometimes he miscounts. You can <strong>guess</strong> the correct number of letters in each bundle by deciding whether it's <strong>more</strong> or <strong>less</strong> than what Malcolm wrote.<br /></p>
        <p>If you guess correctly, you'll get Malcolm's gratitude. If not, you'll only get to count them.</p>
        <p>Do know, Malcolm never bundles fewer than two letters together or more than fifteen.</p>
        @if ($user->settings->hol_plays != 0)
            <a href="#" class="btn btn-primary play-hol">Sort Mail</a>
           
        @else
            <div class="alert alert-danger text-center">
                You've sorted all of Malcolm's mail today. Thanks! Come back tomorrow.
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            $('.play-hol').on('click', function(e) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('malcolms-mailpile/play') }}",
                }).done(function(res) {
                    $(".game").fadeOut(500, function() {
                        $(".game").html(res);
                        $(".game").fadeIn(500);
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("AJAX call failed: " + textStatus + ", " + errorThrown);
                });
            });
        });
    </script>
@endsection
