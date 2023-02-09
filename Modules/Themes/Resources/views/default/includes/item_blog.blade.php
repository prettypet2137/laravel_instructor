<article class="post blog-layout blog-grid">
        <div class="thumb-image">
            <figure class="entry-thumb"><a class="blog-thumbnail" href="{{ $blog->getPublishLink() }}" aria-hidden="true">
                    <div class="image-wrapper"><img width="388" height="250" src="{{ $blog->getThumbLink() }}" class="img-fluid" alt=""></div>
                </a></figure>
        </div>
        <div class="inner-bottom">
            <div class="top-info">
                <div class="date">
                    {{ \Carbon\Carbon::parse($blog->created_at)->toFormattedDateString() }} 
                </div>
                <div class="list-categories"><a href="{{ route('blogs', ['category_id' => $blog->category->id]) }}" class="categories-name">{{ $blog->category->name }}</a></div>
            </div>
            <h4 class="entry-title">
                <a href="{{ $blog->getPublishLink() }}">{{ $blog->title }}</a>
            </h4>
            <div class="description">{{ $blog->content_short }}.</div>
            <div class="readmore">
                <a class="btn-readmore" href="{{ $blog->getPublishLink() }}">@lang('Read More')...</a>
            </div>
        </div>
</article>

