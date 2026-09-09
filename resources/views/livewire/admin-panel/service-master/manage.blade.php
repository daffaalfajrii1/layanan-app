<div class="row">
    <div class="col-lg-12">
        <div class="card" id="serviceFieldList">
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-1">Field: {{ $service->name }}</h5>
                        <small class="text-muted">Slug: <code>{{ $service->slug }}</code></small>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin.service-master.index') }}" class="btn btn-soft-secondary">
                                <i class="ri-arrow-left-line align-bottom me-1"></i>
                                Kembali
                            </a>
                            <x-button buttonType="info" wire:click.prevent="openModal" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i>
                                Tambah Field
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-nowrap" id="serviceFieldTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="text-center text-uppercase" style="width: 60px;">No</th>
                                <th class="text-uppercase">Nama Field</th>
                                <th class="text-uppercase">Tipe</th>
                                <th class="text-center text-uppercase">Wajib</th>
                                <th class="text-uppercase" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="service-field-list-data">
                            @forelse($documents as $document)
                                <tr wire:key="field-{{ $document->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $document->name }}</td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info">{{ $document->type }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($document->is_required)
                                            <span class="badge bg-success-subtle text-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="javascript:void(0)" class="text-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#showModal" wire:click="edit({{ $document->id }})">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus">
                                                <a href="javascript:void(0)" class="text-danger d-inline-block remove-item-btn" wire:click="deleteConfirm('delete', '{{ $document->id }}')">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-data :colspan="5" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <x-modal name="showModal" :title="$mode == 'add' ? 'Tambah Field' : 'Edit Field'">
            <form wire:submit.prevent="submit" class="tablelist-form" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3">
                        <x-input-label for="field_name" value="Nama Field" required />
                        <x-text-input wire:model="name" type="text" id="field_name" placeholder="Contoh: Upload Surat Permohonan" :error="$errors->get('name')" />
                        <x-input-error :messages="$errors->get('name')"/>
                    </div>
                    <div class="mb-3">
                        <x-input-label for="field_type" value="Tipe" required />
                        <select wire:model="type" id="field_type" class="form-select @error('type') is-invalid @enderror">
                            @foreach($typeOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('type')"/>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input wire:model="is_required" class="form-check-input" type="checkbox" id="is_required" role="switch">
                        <label class="form-check-label" for="is_required">Wajib diisi</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <x-secondary-button data-bs-dismiss="modal" wire:click="cancelEdit">
                            Close
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            Simpan
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</div>
