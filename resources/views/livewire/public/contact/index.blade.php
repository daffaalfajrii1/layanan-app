<div>
    <div class="rbt-conatct-area bg-gradient-11 rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb--60">
                        <span class="subtitle bg-secondary-opacity">Kontak Kami</span>
                        <h2 class="title">{{ $identity->name }} <br> bergabung bersama kami.</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="150" data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-headphones"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Kontak Telepon</h4>
                            <p><a href="tel:{{ $identity->phone }}">{{ $identity->phone }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="200" data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-mail"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Alamat Email Kami</h4>
                            <p><a href="mailto:{{ $identity->email }}">{{ $identity->email }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-delay="250" data-sal-duration="800">
                    <div class="rbt-address">
                        <div class="icon">
                            <i class="feather-map-pin"></i>
                        </div>
                        <div class="inner">
                            <h4 class="title">Lokasi Kami</h4>
                            <p>
                                {{ $identity->address }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-contact-address">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-12">
                    <ul class="social-icon social-default transparent-with-border">
                        <li>
                            <a href="{{ $identity->facebook }}">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $identity->twitter }}">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $identity->instagram }}">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $identity->youtube }}">
                                <i class="feather-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-google-map bg-color-white rbt-section-gapTop">
        {!! $identity->google_maps !!}
    </div>
</div>
