<div>
    <div class="slider-area rbt-banner-5 height-750 bg_image bg_image--3" data-gradient-overlay="7">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner text-center">
                        <h1 class="title display-one">Dinas Komunikasi
                            <span>dan </span>
                            <span>Infomatika</span>
                        </h1>
                        <p class="description">
                            Selamat datang di Sistem Informasi Layanan pada Dinas Komunikasi Informatika Kabupaten Rejang Lebong
                        </p>
                        <div class="rbt-button-group">
                            <a class="rbt-btn btn-white hover-icon-reverse" href="{{ route('public.service.index') }}">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Lihat Semua Layanan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                            <a class="rbt-btn btn-border hover-icon-reverse color-white" href="{{ route('public.contact.index') }}">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Kontak Kami</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 align-items-start">
                <div class="col-lg-6">
                    <div class="content">
                        <h2 class="title mb--0" data-sal="slide-up" data-sal-duration="700">
                            Tentang Sistem Informasi Layanan pada Diskominfo
                        </h2>
                    </div>
                </div>
                <div class="col-lg-6" data-sal="slide-up" data-sal-duration="700">
                    <p class="mb--40 mb_sm--20">
                        Sistem Informasi Layanan pada Dinas Komunikasi Informatika Kabupaten Rejang Lebong adalah sistem yang dirancang untuk memudahkan masyarakat dalam mengakses informasi dan layanan yang disediakan oleh Dinas Komunikasi dan Informatika. Sistem ini bertujuan untuk meningkatkan transparansi, akuntabilitas, dan efisiensi dalam pelayanan publik.
                    </p>
                    <div class="readmore-btn">
                        <a class="rbt-moderbt-btn" href="{{ route('public.service.index') }}">
                            <span class="moderbt-btn-text">Detail Layanan</span>
                            <i class="feather-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak Kami --}}
    <div class="rbt-split-area bg-color-white overflow-hidden rbt-section-gapTop">
        <div class="wrapper">
            <div class="rbt-splite-style">
                <div class="split-wrapper">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-12 col-xl-6 col-12">
                            <div class="thumbnail image-left-content">
                                <img src="{{ asset('frontend/images/split/split-01.jpg') }}" alt="split Images">
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-6 col-12">
                            <div class="split-inner">
                                <h4 class="title sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Kontak Kami</h4>
                                <p class="description sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">
                                    Kami sangat menghargai Anda Meluangkan waktu untuk menghubungi kami. Jika Anda memiliki pertanyaan, komentar, atau saran, jangan ragu untuk menghubungi kami melalui informasi kontak di bawah ini.
                                </p>
                                <ul class="split-list sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="350">
                                    <li><span>Telp:</span> <a href="#">{{ $identity->phone }}</a></li>
                                    <li><span>E-mail:</span> <a href="mailto:hr@example.com">{{ $identity->email }}</a></li>
                                    <li><span>Alamat:</span> {{ $identity->alamat }}</li>
                                </ul>
                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                    <a class="rbt-moderbt-btn" href="{{ route('public.contact.index') }}">
                                        <span class="moderbt-btn-text">Kontak</span>
                                        <i class="feather-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="rbt-rbt-blog-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-secondary-opacity">Informasi</span>
                        <h2 class="title">
                            Informasi
                        </h2>
                        <p class="description has-medium-font-size mt--20">
                            Banyak informasi yang bisa anda dapatkan disini.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-5 mt--30">
                @foreach ($news as $new)
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 mt--30">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="{{ route('public.news.detail', $new) }}">
                            <img src="{{ asset('storage/images/news/' . $new->thumbnail) }}" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="{{ route('public.news.detail', $new) }}">{{ $new->judul }}</a></h5>
                            <p class="rbt-card-text">{{ Str::limit($new->isi, 50) }}</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="{{ route('public.news.detail', $new) }}"> Baca Selengkapnya
                                    <i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"></path><path stroke-linecap="square" d="M.663 5.572h14.594"></path></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if ($news->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="load-more-btn mt--60 text-center">
                        <a class="rbt-btn rbt-marquee-btn" href="{{ route('public.news.index') }}">
                            <span data-text="Lihat Semua Informasi">
                                Lihat Semua Informasi
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="load-more-btn mt--60 text-center">
                        <span data-text="Belum ada informasi">
                            Belum ada informasi
                        </span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
