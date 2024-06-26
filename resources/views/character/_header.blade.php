<div class="character-masterlist-categories">
    @if(!$character->is_myo_slot)
        {!! $character->category->displayName !!} ・ {!! $character->image->species->displayName !!} ・ {!! $character->image->rarity->displayName !!}

        @if(config('lorekeeper.extensions.character_theme.show_on_masterlist'))
            {!! $character->image->theme ? ' ・ ' . $character->image->theme : '' !!}
        @endif
    @else
        {{ __('lorekeeper.myo') }} @if($character->image->species_id) ・ {!! $character->image->species->displayName !!}@endif @if($character->image->rarity_id) ・ {!! $character->image->rarity->displayName !!}@endif
    @endif
</div>
<h1 class="ct mb-0">
    @if(Config::get('lorekeeper.extensions.character_status_badges'))
        <!-- character trade/gift status badges -->
        <div class="float-right">
            <span class="btn {{ $character->is_trading ? 'badge-success' : 'badge-danger' }} float-right ml-1" data-toggle="tooltip" title="{{ $character->is_trading ? 'OPEN for sale and trade offers.' : 'CLOSED for sale and trade offers.' }}"><i class="fas fa-comments-dollar" style="padding: 2.5px !important; font-size: 12pt;"></i></span>
            @if(!$character->is_myo_slot)
                <span class="btn {{ $character->is_gift_writing_allowed == 1 ? 'badge-success' : ($character->is_gift_writing_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }} float-right ml-1" data-toggle="tooltip" title="{{ $character->is_gift_writing_allowed == 1 ? 'OPEN for gift writing.' : ($character->is_gift_writing_allowed == 2 ? 'PLEASE ASK before gift writing.' : 'CLOSED for gift writing.') }}"><i class="fas fa-file-alt" style="padding: 2.5px !important; font-size: 12pt;"></i></span>
                <span class="btn {{ $character->is_gift_art_allowed == 1 ? 'badge-success' : ($character->is_gift_art_allowed == 2 ? 'badge-warning text-light' : 'badge-danger') }} float-right ml-1" data-toggle="tooltip" title="{{ $character->is_gift_art_allowed == 1 ? 'OPEN for gift art.' : ($character->is_gift_art_allowed == 2 ? 'PLEASE ASK before gift art.' : 'CLOSED for gift art.') }}"><i class="fas fa-pencil-ruler" style="padding: 2.5px !important; font-size: 12pt;"></i></span>
                <span style="display: none;" class="btn {{ $character->is_links_open == 1 ? 'badge-success' : 'badge-danger' }} float-right ml-2" data-toggle="tooltip" title="{{ $character->is_links_open == 1 ? 'OPEN for link requests.' : 'CLOSED for link requests.' }}"><i class="fas fa-link"></i></span>
            @endif    
        </div>
    @endif
    @if($character->is_visible && Auth::check() && $character->user_id != Auth::user()->id)
        <?php $bookmark = Auth::user()->hasBookmarked($character); ?>
        <a href="#" class="btn btn-outline-info float-right bookmark-button ml-2" data-id="{{ $bookmark ? $bookmark->id : 0 }}" data-character-id="{{ $character->id }}"><i class="fas fa-bookmark" style="margin-top: 5px;"></i> <span style="margin-top: 5px;">{{ $bookmark ? 'Edit Bookmark' : 'Bookmark' }}</span></a>
    @endif
    @if(Config::get('lorekeeper.extensions.character_TH_profile_link') && $character->profile->link)
            <a class="btn btn-outline-info float-right" data-character-id="{{ $character->id }}" href="{{ $character->profile->link }}"><i class="fas fa-home"></i> Profile</a>
        @endif
    @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif <span class="ht">{!! $character->displayName !!}</span>
</h1>
<div class="hd mb-3">
    Owned by {!! $character->displayOwner !!}
</div>
