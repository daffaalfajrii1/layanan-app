<div class="row">
    <div class="col-lg-12">
        <div class="card" id="newList">
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Pendaftar Layanan</h5>
                </div>
            </div>
            <div class="card-body p-0 border-bottom border-bottom-dashed">
                <div class="search-box">
                    <input type="text" wire:model.live.debounce.150ms="search" class="form-control search border-0 py-3" placeholder="Pencarian berdasarkan nomor registrasi ...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap" id="newTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-center text-uppercase" style="width: 60px;">No</th>
                                    <th class="text-uppercase">No Registrasi</th>
                                    <th class="text-uppercase">Nama Pendaftar / Instansi</th>
                                    <th scope="text-uppercase">Email</th>
                                    <th scope="text-uppercase">Jenis Pendaftaran</th>
                                    <th scope="text-uppercase">Detail</th>
                                    <th class="text-uppercase">Status Pendaftaran</th>
                                    <th class="text-uppercase" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="new-list-data">
                                @forelse($registrations as $key => $registration)
                                    <tr wire:key="{{ $registration->id }}">
                                        <td class="text-center">
                                            {{ $registrations->firstItem() + $loop->index }}
                                        </td>
                                        <td>
                                            {{ $registration->registration_number }}
                                        </td>
                                        <td>
                                            {{ $registration->documents()->first()->value }}
                                        </td>
                                        <td>
                                            {{ $registration->documents()->first()->value }}
                                        </td>
                                        <td>{{ $registration->service->name }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#showModal" wire:click="showModal('{{ $registration->id }}')">
                                                Lihat Detail
                                            </a>
                                        </td>
                                        <td>
                                            @switch($registration->status)
                                                @case('pending')
                                                    <span class="badge text-bg-warning">Menunggu</span>
                                                    @break
                                                @case('in_review')
                                                    <span class="badge text-bg-info">Sedang Ditinjau</span>
                                                    @break
                                                @case('approved')
                                                    <span class="badge text-bg-success">Disetujui</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge text-bg-danger">Ditolak</span>
                                                    @break
                                                @default
                                                    <span class="badge text-bg-secondary">{{ $registration->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if ($registration->status == 'pending')
                                                <button type="button" wire:click="approveConfirm('approve', '{{ $registration->id }}')" class="btn btn-sm btn-success btn-label waves-effect waves-light"><i class="ri-checkbox-circle-line label-icon align-middle fs-16 me-2"></i> Terima</button>
                                                <button type="button" wire:click="rejectConfirm('reject', '{{ $registration->id }}')" class="btn btn-sm btn-danger btn-label waves-effect waves-light"><i class="ri-close-circle-line label-icon align-middle fs-16 me-2"></i> Tolak</button>
                                            @else
                                                <small class="text-muted">Pendaftaran sudah diproses</small>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <x-empty-data :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <x-pagination :items="$registrations" />
                </div>
            </div>
        </div>

        <x-modal name="showModal" :title="'Detail Informasi'" maxWidth="lg">
            @if($selectedRegistration)
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Informasi Pendaftaran #{{ $selectedRegistration->registration_number }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="fw-semibold">Detail Pendaftaran</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th style="width: 30%">Nomor Registrasi</th>
                                        <td>{{ $selectedRegistration->registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Layanan</th>
                                        <td>{{ $selectedRegistration->service->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @switch($selectedRegistration->status)
                                                @case('pending')
                                                    <span class="badge text-bg-warning">Menunggu</span>
                                                    @break
                                                @case('in_review')
                                                    <span class="badge text-bg-info">Sedang Ditinjau</span>
                                                    @break
                                                @case('approved')
                                                    <span class="badge text-bg-success">Disetujui</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="badge text-bg-danger">Ditolak</span>
                                                    @break
                                                @default
                                                    <span class="badge text-bg-secondary">{{ $selectedRegistration->status }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pendaftaran</th>
                                        <td>{{ $selectedRegistration->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div>
                        <h6 class="fw-semibold">Dokumen Pendaftaran</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 50px">No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Nilai</th>
                                        <th style="width: 120px">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($documents as $index => $document)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $document['document']['name'] }}</td>
                                        <td>{{ $document['value'] }}</td>
                                        <td class="text-center">
                                            @if($document['file_path'])
                                                <a href="{{ asset('storage/' . $document['file_path']) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="ri-download-2-line"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada dokumen</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <x-secondary-button data-bs-dismiss="modal" wire:click="cancelEdit">
                        Tutup
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>
    </div>
</div>
