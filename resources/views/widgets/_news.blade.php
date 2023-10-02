<div class="card mb-4" style="margin-top: 10px; border: 0px;">
    <div class="card-header" style="background-color: none; border: 0px;">
        <h4 class="mb-0" style="color: #95b582;">✿ Recent News</h4>
    </div>

    <div class="card-body pt-0" style="border: 0px;">
        @if($newses->count())
            @foreach($newses as $news)
                <div style="padding: 5px; padding-top: 15px; background-color: #fafafa; color: #6a6a6a; border-bottom: 10px solid #fff;">
                    <span class="d-flex flex-column flex-sm-row align-items-sm-end @if(!$textPreview) pb-3 @endif" style="border: 0px; padding: 2.5px;">
                        <h5 class="mb-0" style="padding-left: 13px; font-family: Poppins, serif; font-size: 11.5pt;"> {!! $news->displayName !!}</h5>
                        <span class="ml-2 small">Posted {!! $news->post_at ? pretty_date($news->post_at) : pretty_date($news->created_at) !!}</span>
                    </span>
                    @if($textPreview)
                        <p class="pl-3">{!! substr(strip_tags(str_replace("<br />", "&nbsp;", $news->parsed_text)), 0, 85) !!}... <a style="color: #95b582;; font-weight: bold; font-family: Poppins, serif;" href="{!! $news->url !!}">read more <i class="fas fa-arrow-right"></i></a></p>
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
