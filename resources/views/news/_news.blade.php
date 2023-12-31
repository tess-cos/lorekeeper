<div class="card mb-3">
    <div class="card-header" style="border-bottom: 0px;">
        <h2 class="card-title mb-0"><i class="fas fa-seedling" style="color: #95b582;"></i> {!! $news->displayName !!}</h2>
        <small>
            Posted {!! $news->post_at ? pretty_date($news->post_at) : pretty_date($news->created_at) !!} (Last edited {!! pretty_date($news->updated_at) !!}) by {!! $news->user->displayName !!}
        </small>
    </div>
    <div class="card-body">
        <div class="parsed-text">
            {!! $news->parsed_text !!}
        </div>
    </div>
    <?php $commentCount = App\Models\Comment::where('commentable_type', 'App\Models\News')->where('commentable_id', $news->id)->count(); ?>
    @if(!$page)
        <div class="text-right mb-2 mr-2">
            <a class="btn" href="{{ $news->url }}" style="background-color: #f9f8f3; border-radius: 15px; text-transform: lowercase;" text-transform: lowercase;><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</a>
        </div>
    @else
        <div class="text-right mb-2 mr-2">
            <span class="btn" style="background-color: #f9f8f3; color: #CFDEBA; border-radius: 15px; text-transform: lowercase;"><i class="fas fa-comment"></i> {{ $commentCount }} Comment{{ $commentCount != 1 ? 's' : ''}}</span>
        </div>
    @endif
</div>
