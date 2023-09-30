<div class="card mb-4" style="margin-top: 10px; border: 0px;">
    <div class="card-header" style="background-color: #bed0a6;">
        <h4 class="mb-0">✿ Recent News</h4>
    </div>

    <div class="card-body pt-0" style="border: 2px dashed #bed0a6; border-top: 0px;">
        @if($newses->count())
            @foreach($newses as $news)
                <div class="border-bottom" style="padding: 5px; padding-top: 15px;">
                    <span class="d-flex flex-column flex-sm-row align-items-sm-end @if(!$textPreview) pb-3 @endif" style="padding: 2.5px;">
                        <h5 class="mb-0" style="font-family: Poppins, serif; font-size: 11.5pt;"><i class="fas fa-newspaper"></i> {!! $news->displayName !!}</h5>
                        <span class="ml-2 small">Posted {!! $news->post_at ? pretty_date($news->post_at) : pretty_date($news->created_at) !!}</span>
                    </span>
                    @if($textPreview)
                        <p class="pl-3">{!! substr(strip_tags(str_replace("<br />", "&nbsp;", $news->parsed_text)), 0, 85) !!}... <a href="{!! $news->url !!}">read more <i class="fas fa-arrow-right"></i></a></p>
                    @endif
                </div>
            @endforeach
        @else
            <div class="text-center">
                <h5 class="text-muted">There is no news.</h5>
            </div>
        @endif
    </div>
</div>
