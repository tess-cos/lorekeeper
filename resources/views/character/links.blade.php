@extends('character.layout', ['isMyo' => $character->is_myo_slot])

@section('profile-title') {{ $character->fullName }}'s Links @endsection

@section('meta-img') {{ $character->image->thumbnailUrl }} @endsection

@section('profile-content')
{!! breadcrumbs([($character->category->masterlist_sub_id ? $character->category->sublist->name.' Masterlist' : 'Character masterlist') => ($character->category->masterlist_sub_id ? 'sublist/'.$character->category->sublist->key : 'masterlist' ), $character->fullName => $character->url, 'Profile' => $character->url . '/profile']) !!}

    <h2>{{ $character->fullName }}'s Links</h2>
    @if (count($character->links))
        <div class="container mt-1 row">
            @foreach($character->links as $link)
                <div class="mb-1 justify-content-center lkim" style="margin: auto; margin-top: 55px; width: 35%;">
                    
                <div style="left: -70px; position: relative;">@include('character._link_character', ['character' => $character])</div>
                <div style="z-index: 2; top: -85px; left: 80px; position: relative; margin-bottom: -80px;">@include('character._link_character', ['character' => $link->character])
                

                
            </div><div style="padding: 0px; margin-top: 4px; margin-bottom: 1px; text-align: center;"><a href="{{ $character->url }}" class="h5 mb-0">@if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->fullName }}</a></div>
            <h3 style="margin-left: 5px; margin-right: 5px; margin-bottom: -1px; text-align: center;">&</h3> <div style="padding: 0px; margin-top: 1px; text-align: center;"><a href="{{ $link->character->url }}" class="h5 mb-0">@if(!$link->character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $link->character->fullName }}</a></div></div>

                <div class="card mb-1 col-md-5" style="background: none !important;">
                    <div class="card-header">
                        
                            <h6 class="text-center text-uppercase" style="font-family: Poppins, sans-serif; !important;"><b>✿ {{ $link->type }}</b></h6>
                        
                    </div>
                
                    <div class="card-body" style="background: none !important;">   
                        {{-- Basic info  --}}
                        
                                <div class="row">
                                    <div class="m-2" style="width: 100%;">
                                    <div class="card-header text-center thts" style="padding: 5px; border-radius: 999px; margin-bottom: 5px; text-transform: uppercase; font-family: Poppins, serif; font-size: 8.5pt;">@if(!$character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $character->name ? $character->name : $character->slug }} Thoughts</div>
                                        @if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
                                            {!! Form::open(['url' => $character->url .'/links/info/'.$link->id]) !!}
                                            {!! Form::hidden('chara_1', $character->id) !!}
                                            {!! Form::hidden('chara_2', $link->chara_2) !!}
                                            {!! Form::textarea('info', $link->info ? $link->info : null, ['placeholder' => 'What are your characters feelings?', 'class' => 'form-control mb-2' , 'cols' => 20, 'rows' => 5]) !!}
                                            
                                            {!! Form::select('type', $types, null, ['class' => 'form-control mt-2', 'placeholder' => 'Relationship Type']) !!}
                                            <div class="text-right m-2">
                                                {!! Form::button('<i class="fas fa-cog"></i> Edit Info', ['class' => 'btn btn-outline-info btn-sm', 'type' => 'submit']) !!}
                                            </div>
                                            {!! Form::close() !!}
                                        @else
                                            <div class="card m-2">
                                                <div class="m-3">{{ $link->info }}</div>

                                                </div>
                                        @endif
                                    </div>
                                    
                                </div>
                                
                                <div class="card-header text-center thts" style="padding: 5px; border-radius: 999px; text-transform: uppercase; font-family: Poppins, serif; font-size: 8.5pt;">@if(!$link->character->is_visible) <i class="fas fa-eye-slash"></i> @endif {{ $link->character->name ? $link->character->name : $link->character->slug }} Thoughts</div>
                                <div class="row" style="margin-left: -9px;">
                                   
                                    <div class="card m-2">
                                    
                                        <div class="m-3">{{ $link->inverse->info }}</div>
                                    </div>
                                </div>
                                
                            </div>
                        
                        @if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
                                        <button type="button" class="btn btn-danger btn-sm m-1" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                </div>

            @if (!$loop->last)
                <hr class="my-4 w-75" />
            @endif

            @include('character._link_delete_modal', ['character' => $character, 'link' => $link])

            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> This character has no links.
        </div>
    @endif

    <hr class="my-4 w-75" />

    {{-- Bio --}}
    <a class="float-left m-2" href="{{ url('reports/new?url=') . $character->url . '/links' }}">
        <i class="fas fa-exclamation-triangle" data-toggle="tooltip" title="Click here to report this character's links." style="opacity: 50%;"></i>
    </a>

    @if(Auth::check() && ($character->user_id == Auth::user()->id || Auth::user()->hasPower('manage_characters')))
        <div class="text-right m-2">
            <a href="{{ $character->url . '/links/edit' }}" class="btn btn-outline-info btn-sm"><i class="fas fa-envelope"></i> Request Links</a>
        </div>
    @endif
@endsection