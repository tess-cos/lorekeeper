<div class="card mb-4">
    <div class="card-body text-center bb-3" style="background: transparent;">
        <h5 class="card-title">Featured Character</h5>
        <div class="profile-assets-content">
            @if($character)
                <div class="fc2" style="background-image: url(https://i.imgur.com/9jQsuri.png); padding: 10px; width: 70%; margin: auto; border-radius: 15px;">
                <a href="{{ $character->url }}"><img style="background: #fcfcfc; border-color: #CFDEBA;" src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="{{ $character->fullName }}" /></a>
                </div>
                <div class="my-1">
                    <a href="{{ $character->url }}" class="h5 mb-0"> @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a>
                </div>
            @else
                <p>{{ Auth::check() && Auth::user()->id == $user->id ? 'You have' : 'This user has' }} no selected character...</p>
            @endif
        </div>
        <div class="text-center"><a href="{{ $user->url.'/characters' }}" class="btn bb2" style="background-color: #f9f8f3;">View All Characters</a></div>
    </div>
</div>
