<div class="row">
    <div class="col-lg-12">
        @php
            $uploadMaxBytes = (int) filter_var($diagnostics['upload_max_filesize'], FILTER_SANITIZE_NUMBER_INT);
            $postMaxBytes = (int) filter_var($diagnostics['post_max_size'], FILTER_SANITIZE_NUMBER_INT);
            $limitTooSmall = $uploadMaxBytes > 0 && $uploadMaxBytes < 10;
        @endphp

        @if (! $diagnostics['storage_writable'] || $limitTooSmall)
            <div class="alert alert-warning" role="alert">
                <strong>Upload server belum siap.</strong>
                PHP <code>upload_max_filesize={{ $diagnostics['upload_max_filesize'] }}</code>,
                <code>post_max_size={{ $diagnostics['post_max_size'] }}</code>.
                Storage writable: {{ $diagnostics['storage_writable'] ? 'ya' : 'tidak' }}.
                Pastikan folder <code>storage/app/public</code> bisa ditulis dan PHP limit ≥ 10M.
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card" id="documentList">
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Data Dokumen</h5>

                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            <x-button
                                buttonType="info"
                                wire:click.prevent="openModal"
                                data-bs-toggle="modal"
                                id="create-btn"
                                data-bs-target="#showModal"
                            >
                                <i class="ri-add-line align-bottom me-1"></i>
                                Tambah
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0 border-bottom border-bottom-dashed">
                <div class="search-box">
                    <input
                        type="text"
                        wire:model.live.debounce.150ms="search"
                        class="form-control search border-0 py-3"
                        placeholder="Pencarian document ..."
                    >
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table align-middle table-nowrap" id="documentTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="text-center text-uppercase" style="width: 60px;">No</th>
                                <th class="text-uppercase">Dokumen</th>
                                <th class="text-uppercase">File</th>
                                <th class="text-uppercase" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="list" id="document-list-data">
                            @forelse($documents as $document)
                                <tr wire:key="doc-{{ $document->id }}">
                                    <td class="text-center">
                                        {{ $documents->firstItem() + $loop->index }}
                                    </td>
                                    <td>{{ $document->name }}</td>
                                    <td>
                                        @php
                                            $publicFile = asset('storage/files/documents/' . $document->file);
                                        @endphp

                                        @if ($document->file)
                                            <a href="{{ $publicFile }}" target="_blank" class="text-primary">
                                                <i class="ri-download-2-line"></i>
                                                {{ $document->file }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a
                                                    href="javascript:void(0)"
                                                    class="text-primary d-inline-block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#showModal"
                                                    wire:click="edit('{{ $document->id }}')"
                                                >
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus">
                                                <a
                                                    href="javascript:void(0)"
                                                    class="text-danger d-inline-block remove-item-btn"
                                                    wire:click="deleteConfirm('delete', '{{ $document->id }}')"
                                                >
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-data :colspan="4" />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-pagination :items="$documents" />
            </div>
        </div>

        {{-- Form klasik multipart: tidak pakai Livewire temporary upload (sering gagal di hosting) --}}
        <x-modal
            name="showModal"
            :title="$mode === 'add' ? 'Tambah Data Dokumen' : 'Edit Data Dokumen'"
        >
            <form
                method="POST"
                action="{{ $mode === 'edit' && $id ? route('admin.documents.update', $id) : route('admin.documents.store') }}"
                enctype="multipart/form-data"
                class="tablelist-form"
                autocomplete="off"
            >
                @csrf
                @if ($mode === 'edit' && $id)
                    @method('PUT')
                @endif

                <div class="modal-body">
                    <div class="mb-3">
                        <x-input-label for="name" value="Dokumen" required />
                        <x-text-input
                            name="name"
                            type="text"
                            id="name"
                            placeholder="Nama Dokumen"
                            :value="old('name', $name)"
                            :error="$errors->get('name')"
                        />
                        <x-input-error :messages="$errors->get('name')"/>
                    </div>

                    <div class="mb-3">
                        <x-input-label
                            for="document_file"
                            value="File"
                            :required="$mode === 'add' || blank($recentFile)"
                        />

                        <input
                            type="file"
                            name="document_file"
                            class="form-control"
                            id="document_file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif,.webp"
                            @if ($mode === 'add' || blank($recentFile)) required @endif
                        >

                        <small class="form-text text-muted d-block mt-1">
                            Format: PDF, DOC, DOCX, XLS, XLSX, atau gambar. Maksimal 10MB.
                        </small>

                        @if ($mode === 'edit' && $recentFile)
                            <small class="text-muted d-block mt-1">
                                File saat ini:
                                <a href="{{ asset('storage/files/documents/' . $recentFile) }}" target="_blank">
                                    {{ $recentFile }}
                                </a>
                                <br>
                                (Kosongkan input di atas jika tidak ingin mengganti file)
                            </small>
                        @endif

                        <x-input-error :messages="$errors->get('document_file')"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <x-secondary-button
                            type="button"
                            data-bs-dismiss="modal"
                            wire:click="cancelEdit"
                        >
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

@if ($showModal || session('document_modal'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('showModal');
            if (modal && window.bootstrap) {
                window.bootstrap.Modal.getOrCreateInstance(modal).show();
            }
        });
    </script>
@endif
