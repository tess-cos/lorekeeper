@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title') {{ $character->fullName }} @endsection

@section('meta-img') {{ $character->image->thumbnailUrl }} @endsection

@section('profile-content')

@include('widgets._awardcase_feature', ['target' => $character, 'count' => Config::get('lorekeeper.extensions.awards.character_featured'), 'float' => true])

@if($character->is_myo_slot)
{!! breadcrumbs(['MYO Slot Masterlist' => 'myos', $character->fullName => $character->url]) !!}
@else
{!! breadcrumbs([($character->category->masterlist_sub_id ? $character->category->sublist->name.' Masterlist' : 'Character masterlist') => ($character->category->masterlist_sub_id ? 'sublist/'.$character->category->sublist->key : 'masterlist' ), $character->fullName => $character->url]) !!}
@endif

@include('character._header', ['character' => $character])

@if ($character->images()->where('is_valid', 1)->whereNotNull('transformation_id'))
        <div class="card-header mb-2" style="background: none !important; border-bottom: 1px solid #f7f7f7 !important; margin-bottom: 20px !important;">
            <ul class="nav nav-tabs card-header-tabs" style="background: none !important;">
                @foreach ($character->images()->where('is_valid', 1)->get() as $image)
                    <li class="nav-item">
                        <a class="nav-link form-data-button {{ $image->id == $character->image->id ? 'active' : '' }}" style="border-color: #f4e3e6 !important; border-bottom: 0px !important;" data-toggle="tab" role="tab" data-id="{{ $image->id }}">
                            {{ $image->transformation_id ? $image->transformation->name : 'Cosset' }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <h4 style="margin-top: 6px;">{!! add_help('Click on a '.__('transformations.transformation').' to view the image. If you don\'t see the '.__('transformations.transformation').' you\'re looking for, it may not have been uploaded yet.') !!}</h4>
                </li>
            </ul>
        </div>
@endif

{{-- Main Image --}}
<div class="row mb-3" id="main-tab" style="clear:both;">
    <div class="col-md-7">
        <div class="text-center">
            <a href="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" data-lightbox="entry" data-title="{{ $character->fullName }}">
                <img style="max-height: 600px;" src="{{ $character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)) ? $character->image->fullsizeUrl : $character->image->imageUrl }}" class="image" alt="{{ $character->fullName }}" />
            </a>
        </div>
        @if($character->image->canViewFull(Auth::check() ? Auth::user() : null) && file_exists( public_path($character->image->imageDirectory.'/'.$character->image->fullsizeFileName)))
            <div class="text-right">You are viewing the full-size image. <a href="{{ $character->image->imageUrl }}">View watermarked image</a>?</div>
        @endif
    </div>
    @include('character._image_info', ['image' => $character->image])
</div>

{{-- Info --}}
@if($character->pets()->exists())<div class="row" style="width: 100%; padding: 15px; margin: auto; text-align: center; background: none; border: 0px solid #dedede; padding: 5px; padding-bottom: 10px; border-radius: 5px;">
<h5 style="text-align: left; padding: 10px; background-color: none; display: none;">cosprouts</h5>
                        @foreach($character->image->character->pets as $pet)
                            <div class="col-md-4" style="margin: auto;">
                                @if($pet->has_image)
                                <img class="img-fluid" src="{{ $pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 65%; padding: 5px;"/>
                                @elseif($pet->pet->imageurl)
                                <img class="img-fluid" src="{{ $pet->pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 65%; padding: 5px;"/>
                                @else {!!$pet->pet->displayName !!}
                                @endif
                                <br>
                                <span class="badge" style="font-size:95%; background-color: #fafafa; color: #95b582;">{!! $pet->pet_name !!}</span>
                            </div>
                        @endforeach</div>
                        @else
                                <div style="display: none;">No Cosprouts owned.</div>
                            @endif
                        <br />

                        @if($character->items()->where('count', '>', 0)->exists())<div class="card-header" style="width: 80%; padding: 15px; margin: auto; text-align: center; background-color: #fafafa; border: 1px solid #dedede; padding: 5px; padding-bottom: 10px; border-radius: 5px;">
                        <h5 style="padding: 10px; margin-bottom: -5px; text-align: left;"><span style="color: #D48C99;">✿</span> <span style="color: #95b582;">{!! $character->name !!}'s</span> <a role="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">keepsakes
        <i style="color: #D48C99;" class="fa fa-chevron-right pull-right"></i>
        <i style="color: #D48C99;" class="fa fa-chevron-down pull-right"></i></a></h5></div>
                    <div class="row collapse card-body tab-content" id="collapseExample" style="width: 80%; margin: auto; text-align: center; padding-bottom: 10px; background-image:url(https://i.imgur.com/KpXntZH.png);">@foreach($character->items()->where('count', '>', 0)->get() as $item)
                            <div class="col-sm-4" style="margin: auto;">
                                @if($item->has_image)
                                <a href="{{$item->idUrl}}"><img src="{{ $item->imageUrl }}" data-toggle="tooltip" title="{{ $item->name }}" style="max-width: 80%; filter: drop-shadow(3px 0 0 #C0D1A6) 
        drop-shadow(0 3px 0 #C0D1A6)
        drop-shadow(-3px 0 0 #C0D1A6) 
        drop-shadow(0 -3px 0 #C0D1A6);"/></a>
                                @elseif($item->imageurl)
                                <a href="{{$item->idUrl}}"><img src="{{ $item->imageUrl }}" data-toggle="tooltip" title="{{ $item->name }}" style="max-width: 80%; filter: drop-shadow(3px 0 0 #C0D1A6) 
        drop-shadow(0 3px 0 #C0D1A6)
        drop-shadow(-3px 0 0 #C0D1A6) 
        drop-shadow(0 -3px 0 #C0D1A6);"/></a>
                                @else {!!$item->displayName !!}
                                @endif
                            </div>
                        @endforeach</div><br />
                        @else
                                <div style="display: none;">No Keepsakes owned.</div>
                            @endif
                       


<div class="card character-bio">
    <div class="card-header" style="background-color: #fafafa;"><h5 style="padding: 10px; margin-bottom: -5px; margin-top: -2.5px; margin-left: -8.5px;">description
    <a class="float-right" href="{{ url('reports/new?url=') . $character->url . '/profile' }}"><i class="fas fa-exclamation-triangle" data-toggle="tooltip" title="Click here to report this character's profile." style="opacity: 50%;"></i></a></h5></div>

@if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
    
@endif
@if($character->profile->parsed_text)
    
        <div class="card-body parsed-text">
                {!! $character->profile->parsed_text !!}</div>@else
                                <div style="padding: 25px;">No description.</div>
                           
@endif
</div><br /><br />
<div class="card character-bio">
    <div class="card-header" style="background-color: #fafafa;">
        <ul class="nav nav-tabs card-header-tabs" style="background-color: #fafafa;">
            <li class="nav-item">
                <a class="nav-link active" id="statsTab" data-toggle="tab" href="#stats" role="tab">Stats</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="skillsTab" style="display: none;" data-toggle="tab" href="#skills" role="tab">Skills</a>
            </li>
            @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
                <li class="nav-item">
                    <a class="nav-link" id="settingsTab" data-toggle="tab" href="#settings-{{ $character->slug }}" role="tab"><i class="fas fa-cog"></i></a>
                </li>
            @endif
        </ul>
    </div>
    <div class="card-body tab-content">
        <div class="tab-pane fade show active" id="stats">
            @include('character._tab_stats', ['character' => $character])
        </div>
        <div class="tab-pane fade" id="notes">
            @include('character._tab_notes', ['character' => $character])
        </div>
        <div class="tab-pane fade" id="skills" style="display: none;">
            @include('character._tab_skills', ['character' => $character, 'skills' => $skills])
        </div>
        @if(Auth::check() && Auth::user()->hasPower('manage_characters'))
            <div class="tab-pane fade" id="settings-{{ $character->slug }}">
                {!! Form::open(['url' => $character->is_myo_slot ? 'admin/myo/'.$character->id.'/settings' : 'admin/character/'.$character->slug.'/settings']) !!}
                    <div class="form-group">
                        {!! Form::checkbox('is_visible', 1, $character->is_visible, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
                        {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the character. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the character\'s page.') !!}
                    </div>
                    <div class="text-right">
                        {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
                <hr />
                <div class="text-right">
                    <a href="#" class="btn btn-outline-danger btn-sm delete-character" data-slug="{{ $character->slug }}">Delete</a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
    @parent
    @include('character._image_js', ['character' => $character])
    @include('character._transformation_js')
    <script>
        $('#serviceList').on('shown.bs.collapse'), function() {
    $(".servicedrop").addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
  }

$('#serviceList').on('hidden.bs.collapse'), function() {
    $(".servicedrop").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
  }</script>
@endsection
