@php
    $identity = \App\Models\Master\Identity::first();
@endphp

<!-- Start Footer aera -->
<footer class="rbt-footer footer-style-1">
    <div class="footer-top">
        <div class="container">
            <div class="row row--15 mt_dec--30">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <div class="logo">
                            <a href="{{ route('public.home') }}">
                                <img src="{{ asset('storage/images/identity/' . $identity->logo) }}" alt="Edu-cause">
                            </a>
                        </div>

                        <p class="description mt--20">
                            {{ $identity->deskripsi }}
                        </p>

                        <div class="contact-btn mt--30">
                            <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round" href="{{ route('public.contact.index') }}">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Kontak Kami</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="offset-lg-1 col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Link Terkait</h5>
                        <ul class="ft-link">
                            <li>
                                <a href="{{ route('public.news.index') }}">Informasi</a>
                            </li>
                            <li>
                                <a href="{{ route('public.service.index') }}">Layanan</a>
                            </li>
                            <li>
                                <a href="{{ route('public.document.index') }}">Dokumen</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="footer-widget">
                        <h5 class="ft-title">Kontak Kami</h5>
                        <ul class="ft-link">
                            <li><span>Telp:</span> <a href="#">{{ $identity->phone }}</a></li>
                            <li><span>E-mail:</span> <a href="mailto:{{ $identity->email }}">{{ $identity->email }}</a></li>
                            <li><span>Alamat:</span> {{ $identity->alamat }}</li>
                        </ul>
                        <ul class="social-icon social-default icon-naked justify-content-start mt--20">
                            <li><a href="{{ $identity->facebook }}">
                                    <i class="feather-facebook"></i>
                                </a>
                            </li>
                            <li><a href="{{ $identity->twitter }}">
                                    <i class="feather-twitter"></i>
                                </a>
                            </li>
                            <li><a href="{{ $identity->instagram }}">
                                    <i class="feather-instagram"></i>
                                </a>
                            </li>
                            <li><a href="{{ $identity->youtube }}">
                                    <i class="feather-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer aera -->
<div class="rbt-separator-mid">
    <div class="container">
        <hr class="rbt-separator m-0">
    </div>
</div>
<!-- Start Copyright Area  -->
<div class="copyright-area copyright-style-1 ptb--20">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-12">
                <p class="rbt-link-hover text-center text-lg-start">Copyright © {{ date('Y') }} <a href="#">UBD.</a> All Rights Reserved</p>
            </div>
        </div>
    </div>
</div>
<!-- End Copyright Area  -->
