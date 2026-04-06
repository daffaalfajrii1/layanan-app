<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-sm-5 text-white-50 text-center">
                        <div>
                            <a href="{{ route('admin.dashboard') }}" class="d-inline-block auth-logo">
                                <img src="{{ asset('assets/images/logo-diskominfo-rejang-lebong-white.png') }}" alt="" height="100">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="mt-2 text-center">
                                <h5 class="text-primary">Selamat Datang Kembali !</h5>
                                <p class="text-muted">Silahkan masuk ke Sistem Informasi Layanan.</p>
                            </div>
                            <div class="mt-4 p-2">
                                <form wire:submit.prevent="login">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="username" value="Username" required />
                                        <x-text-input wire:model="username" type="text" id="username" placeholder="Username" :error="$errors->get('username')" />
                                        <x-input-error :messages="$errors->get('username')"/>
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="password" value="Password" required/>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <x-text-input wire:model="password" type="password" class="pe-5 password-input"  placeholder="Password" id="password-input" :error="$errors->get('password')"/>
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            <x-input-error :messages="$errors->get('password')"/>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <x-primary-button class="w-100" type="submit">
                                            Login
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer start-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="text-muted mb-0">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> UBD. Crafted with <i class="mdi mdi-heart text-danger"></i> by Universitas Bina Darma
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->
