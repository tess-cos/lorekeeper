<div class="card mb-3">
    <div class="card-header" style="border-bottom: 0px;">
        <h2 class="card-title mb-0"><i class="fas fa-seedling ct-2" style="color: #95b582;"></i> {!! $sales->displayName !!}</h2>
        <small>
            Posted {!! $sales->post_at ? pretty_date($sales->post_at) : pretty_date($sales->created_at) !!} (Last edited {!! pretty_date($sales->updated_at) !!}) by {!! $sales->user->displayName !!}
        </small>
    </div>


@if($sales->characters()->count())
</div>

    <div class="row mb-2">
        @foreach($sales->characters as $character)
            <div class="col-lg mb-2">
                @include('sales._character', ['character' => $character, 'loop' => $loop])
            </div>
            {!! $loop->even ? '<div class="w-100"></div>' : '' !!}
        @endforeach
    </div>

<div class="card mb-3">
@endif

    <div class="card-body">
        <div class="parsed-text">
            {!! $sales->parsed_text !!}
        </div>
    </div>

    @if((isset($sales->comments_open_at) && $sales->comments_open_at < Carbon\Carbon::now() ||
    (Auth::check() && Auth::user()->hasPower('edit_pages'))) ||
    !isset($sales->comments_open_at))
        <?php $commentCount = App\Models\Comment::where('commentable_type', 'App\Models\Sales\Sales')->where('commentable_id', $sales->id)->count(); ?>
        @if(!$page)
            <div class="text-right mb-2 mr-2">
                <a class="btn bb ct-1" href="{{ $sales->url }}" style="background-color: #f9f8f3; border-radius: 15px; text-transform: lowercase;"><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</a>
            </div>
        @else
            <div class="text-right mb-2 mr-2">
                <span class="btn bb ct-1" style="background-color: #f9f8f3; color: #CFDEBA; border-radius: 15px; text-transform: lowercase;"><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</span>
            </div>
        @endif
    @endif
</div>
