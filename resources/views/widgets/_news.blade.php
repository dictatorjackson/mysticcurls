<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0"><i class="fas fa-newspaper"></i> Recent News</h4>
    </div>

    <div class="card-body pt-0">
        @if($newses->count())
            @foreach($newses as $news)
                <div class="border-bottom">
                    <span class="d-flex flex-column flex-sm-row align-items-sm-end pt-3 @if(!$textPreview) pb-3 @endif">
                        <h5 class="mb-0">{!! $news->displayName !!}</h5>
                        <span class="ml-2 small">Posted {!! $news->post_at ? pretty_date($news->post_at) : pretty_date($news->created_at) !!} || Last edited {!! pretty_date($news->updated_at) !!}</span>
                    </span>
                    @if($textPreview)
                        <p class="pl-3">{!! substr(strip_tags(str_replace("<br />", "&nbsp;", $news->parsed_text)), 0, 300) !!}... <a href="{!! $news->url !!}">Read more <i class="fas fa-arrow-right"></i></a></p>
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
