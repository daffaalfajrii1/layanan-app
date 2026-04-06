<div>
    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
        <div class="rbt-banner-content">

            <!-- Start Banner Content Top  -->
            <div class="rbt-banner-content-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start Breadcrumb Area  -->
                            <ul class="page-list">
                                <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Home</a></li>
                                <li>
                                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                                </li>
                                <li class="rbt-breadcrumb-item active">Semua Berita</li>
                            </ul>
                            <!-- End Breadcrumb Area  -->

                            <div class="title-wrapper">
                                <h1 class="title mb--0">Semua Berita</h1>
                                <a href="{{ route('public.news.index') }}" class="rbt-badge-2">
                                    {{ $news->count() }} Berita
                                </a>
                            </div>

                            <p class="description">
                                Berita terbaru dari kami, jangan sampai ketinggalan informasi terbaru dari kami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Banner Content Top  -->

        </div>
    </div>

    <div class="rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row row--30 gy-5">

                <div class="col-lg-8">

                    <!-- Start Card Area -->
                    <div class="row g-5">

                        @foreach ($news as $new)
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="rbt-blog-grid rbt-card variation-02 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="{{ route('public.news.detail', $new) }}">
                                        <img src="{{ asset('storage/images/news/' . $new->thumbnail) }}" alt="Card image"> </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h5 class="rbt-card-title"><a href="{{ route('public.news.detail', $new) }}">{{ $new->judul }}</a></h5>

                                    <ul class="blog-meta">
                                        <li><i class="feather-user"></i> {{ $new->creator->name }}</li>
                                        <li><i class="feather-clock"></i> {{ date_indo($new->created_at) }}</li>
                                    </ul>
                                    <p class="rbt-card-text">
                                        {{ Str::limit($new->isi, 100) }}
                                    </p>
                                    <div class="rbt-card-bottom">
                                        <a class="transparent-button" href="{{ route('public.news.detail', $new) }}">Baca Selengkapnya<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="rbt-sidebar-widget-wrapper rbt-gradient-border">
                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-recent">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Layanan</h4>
                                <div class="row g-2">
                                    @foreach ($services as $service)
                                        <div class="col-12">
                                            <a class="rbt-cat-box rbt-cat-box-1 image-overlaping-content on-hover-content-visible" href="{{ route('public.service.detail', $service) }}">
                                                <div class="inner">
                                                    <div class="thumbnail">
                                                        <img src="{{ asset('frontend/images/category/image/background-blue.png') }}" alt="{{ $service->name }} images">
                                                    </div>
                                                    <div class="content">
                                                        <h5 class="title">{{ $service->name }}</h5>
                                                        <div class="read-more-btn">
                                                            <span class="rbt-btn-link">Buka Layanan<i class="feather-arrow-right"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach

                                    {{-- horizontal line --}}
                                    <div class="col-12">
                                        <hr class="rbt-separator mt-5 mb-5">
                                    </div>

                                    {{-- Lihat Semua --}}
                                    <div class="col-12">
                                        <a class="rbt-cat-box rbt-cat-box-1 image-overlaping-content on-hover-content-visible" href="{{ route('public.service.index') }}">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <img src="{{ asset('frontend/images/category/image/background-blue.png') }}" alt="Lihat Semua Layanan images">
                                                </div>
                                                <div class="content">
                                                    <h5 class="title">Lihat Semua Layanan</h5>
                                                    <div class="read-more-btn">
                                                        <span class="rbt-btn-link">Buka Layanan<i class="feather-arrow-right"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
</div>
