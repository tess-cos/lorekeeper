@extends('user.layout')

@section('profile-title') {{ $user->name }}'s Characters @endsection

@section('profile-content')
{!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Characters' => $user->url . '/characters']) !!}

<h1>
    {!! $user->displayName !!}'s Characters
</h1>

@if($characters->count())
    <div class="row">
    @if(isset($sublists) && $sublists->count() > 0)
            @foreach($sublists as $sublist)
            / <a href="{{ $user->url.'/sublist/'.$sublist->key }}">{{ $sublist->name }}</a>
            @endforeach
        @endif
        
        @foreach($characters as $character)
            <div class="col-md-3 col-6 text-center mb-2">
                <div>
                    <a href="{{ $character->url }}"><img style="background: #fff; border: 1px solid #f4e3e6; padding: 5px;" src="{{ $character->image->thumbnailUrl }}" class="img-thumbnail" alt="Thumbnail for {{ $character->fullName }}" /></a>
                </div>
                <div class="mt-1 h5">
                    @if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {!! $character->displayName !!}
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No characters found.</p>
@endif

@endsection
