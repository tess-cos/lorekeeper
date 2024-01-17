@extends('home.layout')

@section('home-title') Traveling @endsection

@section('home-content')
{!! breadcrumbs(['Traveling' => 'foraging']) !!}

<h1>
    Traveling
</h1>

<p>Hop aboard a train to visit a place in Latorre and find various goodies, including some that can use in spells!</p>
<p>Select a character (whether yours or a NPC) to go on a trip. Goods will be claimable once they return from their travels.</p>
<p>Do note, you get <strong>three</strong> train tickets every day with each trip taking about
    {{-- convert integer to minutes using carbon (multiple integer by 60) --}}
    {{ Config::get('lorekeeper.foraging.forage_time') . ' minute' . (Config::get('lorekeeper.foraging.forage_time') > 1 ? 's' : '')}}, give or take.</p>
<div class="row">
    <div class="col-md-6">
        @if($user->foraging->foraged_at)
            <p>
                <strong>Last Traveled:</strong> {!! pretty_date($user->foraging->foraged_at) !!}
            <br>
            <strong>Tickets Left:</strong> {{ $user->foraging->stamina }}
            </p>
        @endif
    </div></div>
    @if(Config::get('lorekeeper.foraging.use_characters') && !$user->foraging->distribute_at)
        <div class="col-md-6 justify-content-center text-center" style="margin: auto;">
            <h3>all aboard!</h3>
            @if (!$user->foraging->character)
                <p>No character selected!</p>
            @else
                <div>
                    <a href="{{ $user->foraging->character->url }}">
                        <img src="{{ $user->foraging->character->image->thumbnailUrl }}" style="width: 180px;" class="img-thumbnail" />
                    </a>
                </div>
                <div class="mt-1">
                    <a href="{{ $user->foraging->character->url }}" class="h5 mb-0">
                        @if (!$user->foraging->character->is_visible)
                            <i class="fas fa-eye-slash"></i>
                        @endif {{ $user->foraging->character->fullName }}
                    </a>
                </div>
            @endif
            {!! Form::open(['url' => 'traveling/edit/character']) !!}
                {!! Form::select('character_id', $characters, $user->foraging->character_id, ['class' => 'form-control m-1', 'placeholder' => 'None Selected']) !!}
                {!! Form::submit('Select Character', ['class' => 'btn btn-primary mb-2']) !!}
            {!! Form::close() !!}
        </div>
    @endif


<hr class="w-50 ml-auto mr-auto" />

@php
    // getting a php static var for safari because it sucks
    $now = Carbon\Carbon::now();
    $diff = $now->diffInMinutes($user->foraging->distribute_at, false);
    $left = $now->diffInHours($user->foraging->reset_at, false);
@endphp

<script>
    // this is ugly up here and i hate it but it wont work otherwise
    let now = new Date("<?php echo date('Y-m-d H:i:s'); ?>");
    function timeCount(timer) {
        // timer = carbon time
        setInterval(function() {
            var date = new Date(timer);
            getServerTime();
            // count down time difference between now and date
            var diff = date.getTime() - now.getTime();
            var time = new Date(diff);

            var seconds = time.getUTCSeconds();
            if(seconds < 10) seconds = "0" + seconds;

            var minutes = time.getUTCMinutes();
            if(minutes < 10) minutes = "0" + minutes;

            var hours = now.getUTCHours();

            if((seconds == '00' && minutes == '00' && hours >= date.getUTCHours()) || hours > date.getUTCHours()) {
                // reload page
                location.reload();
            }

            var text = "Train returns in " + minutes + ":" + seconds + "!";
            $("#time").text(text);
        }, 1000);
    }

    function getServerTime()
    {
        // ajax get call to get the time
        $.ajax({
            url: '{{ url("time") }}',
            type: 'GET',
            success: function(data) {
                // update the time
                now = new Date(data);
            }
        });
    }
</script>

@if($user->foraging->distribute_at && $user->foraging->distribute_at > $now)
    {{-- Whilst foraging is in progress--}}
    <script>
        // we have to check for safari since it doesn't agree with formatted times
        const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        var timeLeft = Date.parse("<?php echo $user->foraging->distribute_at ?>");
        // if not safari, set off the loop!
        if(!isSafari) setInterval(timeCount(timeLeft), 1000);
    </script>
    <div class="container text-center">
        @if (Config::get('lorekeeper.foraging.use_characters') && $user->foraging->character)
            <div class="mb-1">
                <a href="{{ $user->foraging->character->url }}">
                    <img src="{{ $user->foraging->character->image->thumbnailUrl }}" style="width: 180px;" class="img-thumbnail" />
                </a>
            </div>
        @endif
        <div id="time">Train returns in {{ $diff < 1 ? 'less than a minute' : $diff }}</div>
        <p>Started {!! pretty_date($user->foraging->foraged_at)!!}
    </div>
@elseif($user->foraging->distribute_at <= $now && $user->foraging->forage_id)
    {{-- When foraging is done and we can claim --}}
    <div class="container text-center">
        @if (Config::get('lorekeeper.foraging.use_characters') && $user->foraging->character)
            <div class="mb-1">
                <a href="{{ $user->foraging->character->url }}">
                    <img src="{{ $user->foraging->character->image->thumbnailUrl }}" style="width: 180px;" class="img-thumbnail" />
                </a>
            </div>
        @endif
        {!! Form::open(['url' => 'traveling/claim' ]) !!}
            @if($user->foraging->forage->imageUr)
                <img src="{{ $user->foraging->forage->imageUrl }}" class="mb-2" style="max-width: 30%;"/>
                <br>
            @endif
            Train arrived from <strong>{!! $user->foraging->forage->fancyDisplayName !!}</strong>
            <br>
            {!! Form::submit('Claim Reward' , ['class' => 'btn btn-primary m-2']) !!}
        {!! Form::close() !!}
    </div>
@elseif($user->foraging->stamina > 0)
    {{-- Base State --}}
    @if(!count($tables))
        <p>No active travel locations. Come back soon!</p>
    @else
    <div class="row text-center">
        @foreach($tables->sortByDesc('is_visible') as $table)
            <div class="col-md-4">
                {!! Form::open(['url' => 'traveling/travel/'.$table->id ]) !!}

                    <div><img src="{{ $table->imageUrl }}" class="img-fluid mb-2"/></div>
                    <div>{!! Form::button(($table->isVisible ? '' : '<i class="fas fa-crown"></i> ') . 'Visit ' . $table->display_name , ['class' => 'btn btn-primary m-2', 'type' => 'submit']) !!}</div>

                        <div class="alert alert-info mb-3">
                                This trip requires {{$table->stamina_cost}} ticket(s).
                                @if($table->has_cost)
                                   <br />Along with a {!! $table->currency->display($table->currency_quantity) !!} train fare.
                                @endif
                        </div>
                {!! Form::close() !!}
            </div>
        @endforeach
    </div>
    @endif
@else
    <div class="alert alert-info">
        You've used all your tickets for today. Come back tomorrow to continue traveling!
    </div>
@endif
@endsection
