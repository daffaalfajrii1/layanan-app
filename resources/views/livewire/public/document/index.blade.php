<div>
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Dokumen</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Dokumen</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="wishlist_area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="cart-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">No</th>
                                        <th class="pro-title">Nama Dokumen</th>
                                        <th class="pro-price">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($documents as $document)
                                    <tr>
                                        <td class="pro-thumbnail">
                                            <div class="pro-title">
                                                <h6 class="title">{{ $loop->iteration }}</h6>
                                            </div>
                                        </td>
                                        <td class="pro-title">
                                            <h6 class="title">{{ $document->name }}</h6>
                                        </td>
                                        <td class="pro-price">
                                            <a href="{{ asset('storage/files/documents/' . $document->file) }}" target="_blank" class="btn btn-primary">Download</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Dolumen tidak ditemukan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
