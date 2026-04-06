<div>
    <div class="rbt-overlay-page-wrapper">
        <div class="breadcrumb-image-container breadcrumb-style-max-width">
            <div class="breadcrumb-image-wrapper">
                <img src="{{ asset('frontend/images/bg/bg-image-10.jpg') }}" alt="Education Images">
            </div>
            <div class="breadcrumb-content-top text-center">
                <ul class="meta-list justify-content-center mb--10">
                    <li class="list-item">
                        <div class="author-thumbnail">
                            <img src="{{ asset('storage/images/users/' . $news->creator->avatar) }}" alt="blog-image">
                        </div>
                        <div class="author-info">
                            <a href="#"><strong>{{ $news->creator->name }}</strong></a></a>
                        </div>
                    </li>
                    <li class="list-item">
                        <i class="feather-clock"></i>
                        <span>{{ date_indo($news->created_at) }}</span>
                    </li>
                </ul>
                <h1 class="title">{{ $news->judul }}</h1>
            </div>
        </div>

        <div class="rbt-blog-details-area rbt-section-gapBottom breadcrumb-style-max-width">
            <div class="blog-content-wrapper rbt-article-content-wrapper">
                <div class="content">
                    <div class="post-thumbnail mb--30 position-relative wp-block-image alignwide">
                        <figure>
                            <img src="{{ asset('storage/images/news/' . $news->thumbnail) }}" alt="Blog Images">
                        </figure>
                    </div>
                    <p>
                        {{ $news->isi }}
                    </p>
                </div>
                <div class="related-post pt--60">
                    <div class="section-title text-start mb--40">
                        <span class="subtitle bg-secondary-opacity">Informasi Lainnya</span>
                        <h4 class="title">Informasi Lainnya</h4>
                    </div>

                    @foreach($otherNews as $other)
                    <div class="rbt-card card-list variation-02 rbt-hover mt--30">
                        <div class="rbt-card-img">
                            <a href="{{ route('public.news.detail', $other) }}">
                                <img src="{{ asset('storage/images/news/' . $other->thumbnail) }}" alt="Card image">
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="{{ route('public.news.detail', $other) }}">{{ $other->judul }}</a>
                            </h5>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="{{ route('public.news.detail', $other) }}">Baca Selengkapnya<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
