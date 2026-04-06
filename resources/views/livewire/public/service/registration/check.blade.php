<div>
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Cek Status Pendaftaran</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.service.index') }}">Layanan</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Cek Status Pendaftaran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-advance-tab-area rbt-section-gap bg-color-white">
        <div class="container">
            <div class="row g-5">
                <form wire:submit="checkRegistration">
                    <div class="rbt-form-group">
                        <label for="registrationNumber">Nomor Registrasi</label>
                        <input
                            type="text"
                            wire:model="registrationNumber"
                            id="registrationNumber"
                            class="form-control @error('registrationNumber') is-invalid @enderror mt-2"
                            required
                        >
                        @error('registrationNumber')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="rbt-form-group mt-3">
                        <button type="submit" class="rbt-btn btn-gradient w-100">Cek Status</button>
                    </div>
                </form>

                @if(session()->has('error'))
                    <div class="alert alert-danger mt-4 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                @if($registration)
                    <div class="rbt-profile-content mt-5">
                        <h5>Detail Pendaftaran</h5>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Nomor Registrasi</th>
                                    <td>{{ $registration->registration_number }}</td>
                                </tr>
                                <tr>
                                    <th>Layanan</th>
                                    <td>{{ $registration->service->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $registration->submitted_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @switch($registration->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                                @break
                                            @case('in_review')
                                                <span class="badge bg-info">Sedang Ditinjau</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">Disetujui</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $registration->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
