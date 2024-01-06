<div class="card mb-4" style="border: 1px #aeb889 solid; margin-top: 20px;">
    <div class="card-body text-center" style="background-color: #fcfcfc;">
        <h6 class="card-title" style="padding: 7px; letter-spacing: 0.5px; text-transform: lowercase; font-family: Hachi Maru Pop, serif; color: #7b956d !important;">Selected Character</h6>
        <div class="profile-assets-content" style="background: none;">
            @if($character)
                <div>
                    <a href="{{ $character->url }}"><img class="img-fluid" style="border-radius: 15px;" src="{{ isset($fullImage) && $fullImage ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }}" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="my-1"  style="padding: 7px;">
                    <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->name }}</a>
                </div>
            @else
                <p>{{ Auth::check() && Auth::user()->id == $user->id ? 'You have' : 'This user has' }} no selected character...</p>
            @endif
        </div>
        <div class="text-center"><a href="{{ '/characters' }}" class="btn btn-secondary" style=" margin-top: 2.5px; font-variant: small-caps; text-transform: lowercase; font-size: 14pt; margin-left: -3px;">View All Characters</a></div>
    </div>
</div>
