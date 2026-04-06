<div>
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Registrasi Berhasil</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.service.index') }}">Layanan</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Registrasi Berhasil</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-advance-tab-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-secondary-opacity">Nomor Registrasi</span>
                        <h2 class="title">{{ $registration->registration_number }}</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="rbt-profile-content">
                        <h5>Detail Pendaftaran</h5>
                        <ul class="list-unstyled">
                            <li><span class="fw-bold">Layanan:</span> {{ $registration->service->name }}</li>
                            <li><span class="fw-bold">Tanggal Pengajuan:</span> {{ $registration->submitted_at->format('d F Y H:i') }}</li>
                            <li><span class="fw-bold">Status:</span>
                                @switch($registration->status)
                                    @case('pending')
                                        <span class="rbt-badge variation-02 bg-warning-opacity">Menunggu</span>
                                        @break
                                    @case('in_review')
                                        <span class="rbt-badge variation-02 bg-info-opacity">Sedang Ditinjau</span>
                                        @break
                                    @case('approved')
                                        <span class="rbt-badge variation-02 bg-success-opacity">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="rbt-badge variation-02 bg-danger-opacity">Ditolak</span>
                                        @break
                                    @default
                                        <span class="rbt-badge variation-02 bg-secondary-opacity">{{ $registration->status }}</span>
                                @endswitch
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="rbt-profile-content">
                        <h5>Informasi Penting</h5>
                        <p>Silakan simpan nomor registrasi Anda untuk memeriksa status pendaftaran Anda nanti.</p>
                        <p>Anda juga dapat memeriksa status pendaftaran Anda dengan mengunjungi halaman <a href="{{ route('public.service.registration.check') }}">Cek Status</a> dan memasukkan nomor referensi Anda.</p>
                    </div>
                </div>

            </div>
            <div class="mt--30 row g-5">
                <div class="col-lg-6">
                    <a href="{{ route('public.home') }}" class="rbt-btn hover-icon-reverse bg-primary-opacity w-100 text-center">Kembali ke Beranda</a>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('public.service.index') }}" class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center">Lihat Layanan Lainnya</a>
                </div>
            </div>
        </div>
    </div>
</div>
