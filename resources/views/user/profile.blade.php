@extends('user.layout')

@section('profile-title') {{ $user->name }}'s Profile @endsection

@section('meta-img') {{ asset('/images/avatars/'.$user->avatar) }} @endsection

@section('profile-content')

@if(Auth::check() && Auth::user()->id != $user->id)
    <a class="btn btn-info btn-sm float-right" href="{{ url('inbox/new?recipient_id=' . $user->id) }}"><i class="fas fa-envelope"></i> Message User</a>
@endif

{!! breadcrumbs(['Users' => 'users', $user->name => $user->url]) !!}

<div style="padding-top: 15px;">@if($user->is_banned)
    <div class="alert alert-danger">This user has been banned.</div>
@endif
<hr style="border: 0px solid #fff; width: 100%;">
<div class="row no-gutters">
    <div class="col-lg-2 p-2 d-flex justify-content-center align-items-center">
        <img src="/images/avatars/{{ $user->avatar }}" style="max-width:125px; max-height:125px; margin-left: 0px; margin-right: 0px; margin-top: -8px; margin-bottom: 20px; border-radius:50%; padding: 10px; border: 1px solid #E5C1C7; background-color: #fdfdfd !important;" alt="{{ $user->name }}" >
    </div>

    <div class="col-lg-10 p-2">
        <div class="d-flex justify-content-between align-items-center">
            <h1>
            {!! $user->displayName !!}
            </h1>
            <h3>
            <a href="{{ url('reports/new?url=') . $user->url }}"><i class="fas fa-exclamation-triangle fa-xs" data-toggle="tooltip" title="Click here to report this user." style="opacity: 50%; font-size:0.5em; color: #DFA4AF;"></i></a>
    @if($user->settings->is_fto)
        <span class="badge badge-success" data-toggle="tooltip" title="This user has not owned any characters from this world before.">FTO</span>
    @endif
            </h3>
        </div>

        <div class="mb-2">
        <div class="row no-gutters">
                    <div class="row col-md-6">
            <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Alias</div>
            <div class="col-9" style="text-transform: lowercase;">{!! $user->displayAlias !!}</div>
        </div>
        <div class="row col-md-6">
            <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Joined</div>
            <div class="col-9" style="text-transform: lowercase;">{!! format_date($user->created_at, false) !!} ({{ $user->created_at->diffForHumans() }})</div>
        </div>
        <div class="row col-md-6">
            <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Rank</div>
            <div class="col-9" style="text-transform: lowercase;">{!! $user->rank->displayName !!} {!! add_help($user->rank->parsed_description) !!}</div>
        </div>
        @if($user->birthdayDisplay && isset($user->birthday))
            <div class="row col-md-6">
                <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Birthday</div>
                <div class="col-9">{!! $user->birthdayDisplay !!}</div>
            </div>
        @endif
        @if($user_enabled && isset($user->home_id))
            <div class="row col-md-6">
                <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Home</div>
                <div class="col-9">{!! $user->home ? $user->home->fullDisplayName : '-Deleted Location-' !!}</div>
            </div>
        @endif
        @if($user_factions_enabled && isset($user->faction_id))
            <div class="row col-md-6">
                <div class="col-3" style="font-family: Mali, serif;text-transform: lowercase; font-weight: bold; font-size: 11pt; color: #7b956d;">Faction</div>
                <div class="col-9">{!! $user->faction ? $user->faction->fullDisplayName : '-Deleted Faction-' !!}{!! $user->factionRank ? ' ('.$user->factionRank->name.')' : null !!}</div>
            </div>
        @endif
    </div>
    </div>
</div></div>

@if(Settings::get('event_teams') && $user->settings->team)
        <div class="text-center" style="padding: 20px; background-color: #E0ECD0; background-image: url(https://i.imgur.com/Hcdd9jq.png); width: 150px; margin: auto; border-radius: 10px; margin-bottom: 8px; margin-top: 4px;">
            <a href="{{ url('event-tracking') }}">
                @if($user->settings->team->has_image)
                    <img style="padding: 5px; margin-bottom: 4px;" src="{{ $user->settings->team->imageUrl }}" class="mw-100"/>
                @endif
                <h5 style="background-color: #E0ECD0; padding: 5px;">{{ $user->settings->team->name }}</h5>
            </a>
        </div>
    @endif

@if(isset($user->profile->parsed_text))
    <div class="card mb-3" style="clear:both; border: 0px; padding: 0px;">
        <div class="card-body" style="background: #fcfcfc !important;">
            {!! $user->profile->parsed_text !!}
        </div>
    </div>
@endif

<div class="row" style="padding: 10px; margin-left: 2px; width: 100%;">
    <div class="col-md-6">
        @include('widgets._selected_character', ['character' => $user->settings->selectedCharacter, 'user' => $user, 'fullImage' => true])
    </div>
    <div class="col-md-6 mb-4 profile-assets" style="clear:both;">
        <div class="card profile-currencies profile-assets-card mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">Bank</h5>
                <div class="profile-assets-content">
                    @foreach($user->getCurrencies(false) as $currency)
                        <div>{!! $currency->display($currency->quantity) !!}</div>
                    @endforeach
                </div>
                <div class="text-right"><a href="{{ $user->url.'/bank' }}">View all...</a></div>
            </div>
        </div>
        <div class="card profile-inventory profile-assets-card">
            <div class="card-body text-center">
                <h5 class="card-title">Inventory</h5>
                <div class="profile-assets-content">
                    @if(count($items))
                        <div class="row">
                            @foreach($items as $item)
                                <div class="col-md-3 col-6 profile-inventory-item">
                                    @if($item->imageUrl)
                                        <img src="{{ $item->imageUrl }}" data-toggle="tooltip" title="{{ $item->name }}" alt="{{ $item->name }}"/>
                                    @else
                                        <p>{{ $item->name }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>No items owned.</div>
                    @endif
                </div>
                <div class="text-right"><a href="{{ $user->url.'/inventory' }}">View all...</a></div>
            </div>
        </div>
    </div>
</div>

    <div class="card mb-3">
        <div class="card-body text-center">
            <h5 class="card-title">{{ ucfirst(__('awards.awards')) }}</h5>
            <div class="card-body">
                @if(count($awards))
                    <div class="row">
                        @foreach($awards as $award)
                            <div class="col-md-3 col-6 profile-inventory-item">
                                @if($award->imageUrl)
                                    <img src="{{ $award->imageUrl }}" class="img-fluid" data-toggle="tooltip" title="{{ $award->name }}" />
                                @else
                                    <p>{{ $award->name }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>No {{ __('awards.awards') }} earned.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url.'/'.__('awards.awardcase') }}">View all...</a></div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body text-center">
            <h5 class="card-title">Pets</h5>
            <div class="card-body">
            @if(count($pets))
                    <div class="row">
                        @foreach($pets as $pet)
                            <div class="col profile-inventory-item">
                                <a href="#" class="inventory-stack"><img src="{{ $pet->variantimage($pet->pivot->variant_id) }}" style="max-height: 150px; max-width: 150px;" data-toggle="tooltip" title="{{ $pet->name }}" alt="{{ $pet->name }}" />
                            </div>
                        @endforeach
                    </div>
                @else
                    <div>No pets owned.</div>
                @endif
            </div>
            <div class="text-right"><a href="{{ $user->url.'/pets' }}">View all...</a></div>
        </div>
    </div>

<!-- Uncomment this to restore the original character display.
    <h2>
        <a href="{{ $user->url.'/characters' }}">Characters</a>
        @if(isset($sublists) && $sublists->count() > 0)
            @foreach($sublists as $sublist)
            / <a href="{{ $user->url.'/sublist/'.$sublist->key }}">{{ $sublist->name }}</a>
            @endforeach
        @endif
    </h2>

    @foreach($characters->take(4)->get()->chunk(4) as $chunk)
        <div class="row mb-4">
            @foreach($chunk as $character)
                <div class="col-md-3 col-6 text-center">
                    <div>
                        <a href="{{ $character->url }}"><img src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $character->fullName }}" /></a>
                    </div>
                    <div class="mt-1">
                        <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="text-right"><a href="{{ $user->url.'/characters' }}">View all...</a></div>
    <hr>
    <br><br>
-->

@comments(['model' => $user->profile,
        'perPage' => 5
    ])
@endsection
