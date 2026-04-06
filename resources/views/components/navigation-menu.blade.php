<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <h3 style="line-height: 65px; font-family: 'IBM Plex Sans', sans-serif;">UBD</h3>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <h3 style="line-height: 65px; color: white; font-family: 'IBM Plex Sans', sans-serif;">UBD</h3>
            </span>
        </a>
        <button type="button" class="btn btn-sm fs-20 header-item float-end btn-vertical-sm-hover p-0" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <x-nav-link :href="route('admin.dashboard')" :active="Request::routeIs('admin.dashboard')" icon="las la-tachometer-alt">Dashboard</x-nav-link>

                <x-nav-link dropdown="newsMenu" icon="las la-book-reader" :active="Request::routeIs('admin.categories.index') || Request::routeIs('admin.news.index') || Request::routeIs('admin.news.create') || Request::routeIs('admin.news.edit')">
                    Informasi
                    <x-slot name="content">
                        <x-dropdown id="newsMenu" :active="Request::routeIs('admin.news.index') || Request::routeIs('admin.categories.index')">
                            <x-nav-link :href="route('admin.news.index')" :active="Request::routeIs('admin.news.index')">Informasi</x-nav-link>
                            <x-nav-link :href="route('admin.categories.index')" :active="Request::routeIs('admin.categories.index')">Kategori</x-nav-link>
                        </x-dropdown>
                    </x-slot>
                </x-nav-link>

                <x-nav-link :href="route('admin.documents.index')" :active="Request::routeIs('admin.documents.index')" icon="ri-file-copy-2-line">Dokumen</x-nav-link>

                <x-nav-link :href="route('admin.services.index')" :active="Request::routeIs('admin.services.index')" icon="ri-file-list-3-line">Pendaftar Layanan</x-nav-link>

                <x-nav-link :href="route('admin.identity.index')" :active="Request::routeIs('admin.identity.index')" icon="ri-settings-4-line">Identitas Website</x-nav-link>

                <x-nav-link :href="route('admin.users.index')" :active="Request::routeIs('admin.users.index')" icon="ri-account-circle-line">Kelola Pengguna</x-nav-link>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
