<div class="row">
    <div class="col-lg-12">
        <div class="card" id="serviceMasterList">
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Kelola Layanan</h5>
                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            <x-button buttonType="info" wire:click.prevent="openModal" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i>
                                Tambah
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0 border-bottom border-bottom-dashed">
                <div class="search-box">
                    <input type="text" wire:model.live.debounce.150ms="search" class="form-control search border-0 py-3" placeholder="Pencarian layanan ...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

            <div class="card-body">
                <div>
                    <div class="table-responsive table-card">
                        <table class="table align-middle table-nowrap" id="serviceMasterTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th class="text-center text-uppercase" style="width: 60px;">No</th>
                                    <th class="text-uppercase">Nama</th>
                                    <th class="text-uppercase">Slug</th>
                                    <th class="text-center text-uppercase">Jumlah Field</th>
                                    <th class="text-center text-uppercase">Pendaftar</th>
                                    <th class="text-uppercase" style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="service-master-list-data">
                                @forelse($services as $service)
                                    <tr wire:key="service-{{ $service->id }}">
                                        <td class="text-center">
                                            {{ $services->firstItem() + $loop->index }}
                                        </td>
                                        <td>{{ $service->name }}</td>
                                        <td><code>{{ $service->slug }}</code></td>
                                        <td class="text-center">{{ $service->documents_count }}</td>
                                        <td class="text-center">{{ $service->registrations_count }}</td>
                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Kelola Field">
                                                    <a href="{{ route('admin.service-master.manage', $service) }}" class="text-success d-inline-block">
                                                        <i class="ri-list-settings-line fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                    <a href="javascript:void(0)" class="text-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#showModal" wire:click="edit({{ $service->id }})">
                                                        <i class="ri-pencil-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus">
                                                    <a href="javascript:void(0)" class="text-danger d-inline-block remove-item-btn" wire:click="deleteConfirm('delete', '{{ $service->id }}')">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <x-empty-data :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <x-pagination :items="$services" />
                </div>
            </div>
        </div>

        <x-modal name="showModal" :title="$mode == 'add' ? 'Tambah Layanan' : 'Edit Layanan'">
            <form wire:submit.prevent="submit" class="tablelist-form" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3">
                        <x-input-label for="name" value="Nama Layanan" required />
                        <x-text-input wire:model.live="name" type="text" id="name" placeholder="Nama Layanan" :error="$errors->get('name')" />
                        <x-input-error :messages="$errors->get('name')"/>
                    </div>
                    <div class="mb-3">
                        <x-input-label for="slug" value="Slug" required />
                        <x-text-input wire:model="slug" type="text" id="slug" placeholder="slug-layanan" :error="$errors->get('slug')" />
                        <x-input-error :messages="$errors->get('slug')"/>
                        <small class="text-muted">Slug dipakai di URL publik, mis. /layanan/pendaftaran-hosting</small>
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
