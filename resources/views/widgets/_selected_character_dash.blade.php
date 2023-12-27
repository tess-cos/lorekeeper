<div class="card mb-4" style="border: 0px; margin-top: 20px;">
    <div class="card-body text-center" style="background-color: #f8f1f1;">
        <h6 class="card-title" style="padding: 7px; letter-spacing: 0.5px; text-transform: uppercase; font-family: Poppins, serif; color: #7b956d !important;">Your Character</h6>
        <div class="profile-assets-content" style="background: none;">
            @if($character)
                <div>
                    <a href="{{ $character->url }}"><img class="img-fluid" style="border-radius: 15px;" src="{{ isset($fullImage) && $fullImage ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }}" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="my-1"  style="padding: 7px;">
                    <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a>
                </div>
            @else
                <p>{{ Auth::check() && Auth::user()->id == $user->id ? 'You have' : 'This user has' }} no selected character...</p>
            @endif
        </div>
        <div class="text-center"><a href="{{ '/characters' }}" class="btn btn-dark" style=" margin-top: 2.5px; background-color: #f4e3e6; color: #D48C99 !important;">View All Characters</a></div>
    </div>
</div>
