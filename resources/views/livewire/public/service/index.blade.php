<div>
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Layanan</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Layanan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-categories-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">

                @foreach ($services as $service)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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

            </div>
        </div>
    </div>

</div>
