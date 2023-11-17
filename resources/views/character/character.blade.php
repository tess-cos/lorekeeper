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

{{-- Main Image --}}
<div class="row mb-3" style="clear:both;">
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
@if($character->pets()->exists())<div style="width: 80%; padding: 15px; margin: auto; text-align: center; background: #fff; border: 0px solid #dedede; padding: 5px; padding-bottom: 10px; border-radius: 5px;">
<h5 style="text-align: left; padding: 10px; background-color: none; display: none;">cosprouts</h5>
                        @foreach($character->image->character->pets as $pet)
                            <div class="ml-3 mr-3" style="margin: auto;">
                                @if($pet->has_image)
                                <img src="{{ $pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 22%; padding: 5px;"/>
                                @elseif($pet->pet->imageurl)
                                <img src="{{ $pet->pet->imageUrl }}" data-toggle="tooltip" title="{{ $pet->pet->name }}" style="max-width: 22%; padding: 5px;"/>
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
                    <div class="collapse card-body tab-content" id="collapseExample" style="width: 80%; margin: auto; text-align: center; padding-bottom: 10px;">@foreach($character->items()->where('count', '>', 0)->get() as $item)
                            <div class="ml-3 mr-3" style="margin: auto;">
                                @if($item->has_image)
                                <a href="{{$item->idUrl}}"><img src="{{ $item->imageUrl }}" style="max-width: 25%; padding: 5px;"/></a>
                                @elseif($item->imageurl)
                                <a href="{{$item->idUrl}}"><img src="{{ $item->imageUrl }}" style="max-width: 25%; padding: 5px;"/></a>
                                @else {!!$item->displayName !!}
                                @endif
                                <br>
                                <a href="{{ $character->url . '/inventory' }}">{!! $item->name !!}</a>
                            </div>
                        @endforeach</div><br />
                        @else
                                <div style="display: none;">No Keepsakes owned.</div>
                            @endif
                       


<div class="card character-bio">
    <div class="card-header" style="background-color: #fafafa;"><h5 style="padding: 10px; margin-bottom: -5px; margin-top: -2.5px; margin-left: -8.5px;">description</h5>
</div>
<div class="card-body tab-content">
@include('character._tab_notes', ['character' => $character])
</div>
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
    <script>
        $('#serviceList').on('shown.bs.collapse'), function() {
    $(".servicedrop").addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
  }

$('#serviceList').on('hidden.bs.collapse'), function() {
    $(".servicedrop").addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
  }</script>
@endsection
