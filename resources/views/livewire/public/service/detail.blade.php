<div>
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">{{ $service->name }}</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item"><a href="{{ route('public.service.index') }}">Layanan</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">{{ $service->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
        <div class="container">
            <div class="row g-5">
                <div class="content">
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submit" class="rbt-profile-row rbt-default-form row row--15">
                        <div class="col-12">
                            <h5 class="mb-3 mt-4">Data yang Diperlukan</h5>
                        </div>

                        @foreach($service->documents as $document)
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="rbt-form-group mb--20">
                                    <label for="document_{{ $loop->index }}">{{ $document->name }} @if($document->is_required) <span class="text-danger">*</span> @endif</label>

                                    @switch($document->type)
                                        @case('text')
                                            <input id="document_{{ $loop->index }}" type="text"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                            @break
                                        @case('file')
                                            <input id="document_{{ $loop->index }}" type="file"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                            @break
                                        @case('date')
                                            <input id="document_{{ $loop->index }}" type="date"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                            @break
                                        @case('email')
                                            <input id="document_{{ $loop->index }}" type="email"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                            @break
                                        @case('time')
                                            <input id="document_{{ $loop->index }}" type="time"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                            @break
                                        @default
                                            <input id="document_{{ $loop->index }}" type="text"
                                                wire:model="documents.{{ $loop->index }}"
                                                class="form-control"
                                                @if($document->is_required) required @endif>
                                    @endswitch

                                    @error('documents.'.$loop->index) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="col-12 mt--20">
                            <div class="rbt-form-group mb--20">
                                <button type="submit" class="rbt-btn btn-gradient">Kirim</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
    <style>
        .form-control[type=file] {
            padding: 15px 10px 30px 10px;
        }

        .form-control[type=time] {
            padding: 25px 10px 20px 10px;
        }
    </style>
@endpush
