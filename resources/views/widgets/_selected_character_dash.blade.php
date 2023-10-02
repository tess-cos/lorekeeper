<div class="card mb-4" style="border: 0px; margin-top: 20px;">
    <div class="card-body text-center" style="background-color: #f4e3e6;">
        <h6 class="card-title" style="text-transform: uppercase; font-family: Poppins, serif;">current character</h6>
        <div class="profile-assets-content" style="background: none;">
            @if($character)
                <div>
                    <a href="{{ $character->url }}"><img class="img-fluid" style="border-radius: 15px;" src="{{ isset($fullImage) && $fullImage ? $character->image->imageUrl : $character->image->thumbnailUrl }}" class="{{ isset($fullImage) && $fullImage ? '' : 'img-thumbnail' }}" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="my-1">
                    <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a>
                </div>
            @else
                <p>{{ Auth::check() && Auth::user()->id == $user->id ? 'You have' : 'This user has' }} no selected character...</p>
            @endif
        </div>
        <div class="text-center"><a href="{{ $user->url.'/characters' }}" class="btn" style="background-color: #E5C1C7;">View All Characters</a></div>
    </div>
</div>
