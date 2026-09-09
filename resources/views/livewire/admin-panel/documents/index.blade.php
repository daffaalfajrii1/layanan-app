<div class="row">
    <div class="col-lg-12">
        <div class="card" id="documentList">
            {{-- Header --}}
            <div class="card-header border-bottom-dashed">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Data Dokumen</h5>

                    <div class="flex-shrink-0">
                        <div class="d-flex gap-2 flex-wrap">
                            {{-- Tombol Tambah --}}
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

            {{-- Search Bar --}}
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

            {{-- Tabel Data --}}
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
                                    {{-- Nomor --}}
                                    <td class="text-center">
                                        {{ $documents->firstItem() + $loop->index }}
                                    </td>

                                    {{-- Nama Dokumen --}}
                                    <td>{{ $document->name }}</td>

                                    {{-- Link File --}}
                                    <td>
                                        @php
                                            // path publik, sesuai storage:link
                                            $publicFile = asset('storage/files/documents/' . $document->file);
                                        @endphp

                                        @if ($document->file)
                                            <a
                                                href="{{ $publicFile }}"
                                                target="_blank"
                                                class="text-primary"
                                            >
                                                <i class="ri-download-2-line"></i>
                                                {{ $document->file }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            {{-- Edit --}}
                                            <li
                                                class="list-inline-item edit"
                                                data-bs-toggle="tooltip"
                                                data-bs-trigger="hover"
                                                data-bs-placement="top"
                                                title="Edit"
                                            >
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

                                            {{-- Hapus --}}
                                            <li
                                                class="list-inline-item"
                                                data-bs-toggle="tooltip"
                                                data-bs-trigger="hover"
                                                data-bs-placement="top"
                                                title="Hapus"
                                            >
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
                                {{-- Komponen empty state custom --}}
                                <x-empty-data :colspan="4" />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <x-pagination :items="$documents" />
            </div>
        </div>

        {{-- =====================================================
             MODAL TAMBAH / EDIT
             NOTE:
             - 1 modal untuk add/edit
             - Jangan pakai wire:model.live pada name saat ada file upload:
               re-render mid-upload membuat TemporaryUploadedFile hilang
             - Tombol Simpan di-disable selama upload sementara berjalan
          ===================================================== --}}
        <x-modal
            name="showModal"
            :title="$mode === 'add' ? 'Tambah Data Dokumen' : 'Edit Data Dokumen'"
        >
            <form
                wire:submit.prevent="submit"
                class="tablelist-form"
                autocomplete="off"
            >
                <div class="modal-body">
                    {{-- Dokumen --}}
                    <div class="mb-3">
                        <x-input-label for="name" value="Dokumen" required />
                        <x-text-input
                            wire:model="name"
                            type="text"
                            id="name"
                            placeholder="Nama Dokumen"
                            :error="$errors->get('name')"
                        />
                        <x-input-error :messages="$errors->get('name')"/>
                    </div>

                    {{-- File --}}
                    <div class="mb-3">
                        <x-input-label
                            for="documentFile"
                            value="File"
                            :required="$mode === 'add' || blank($recentFile)"
                        />

                        <div wire:key="document-file-input-{{ $fileInputKey }}">
                            <input
                                type="file"
                                wire:model="documentFile"
                                class="form-control"
                                id="documentFile"
                            >
                        </div>

                        <div wire:loading wire:target="documentFile" class="form-text text-muted mt-1">
                            Mengunggah file...
                        </div>

                        @if ($documentFile)
                            <small class="text-success d-block mt-1">
                                File siap diunggah: {{ $documentFile->getClientOriginalName() }}
                            </small>
                        @endif

                        {{-- Info file lama saat edit --}}
                        @if ($mode === 'edit' && $recentFile)
                            <small class="text-muted d-block mt-1">
                                File saat ini:
                                <a
                                    href="{{ asset('storage/files/documents/' . $recentFile) }}"
                                    target="_blank"
                                >
                                    {{ $recentFile }}
                                </a>
                                <br>
                                (Kosongkan input di atas jika tidak ingin mengganti file)
                            </small>
                        @endif

                        <x-input-error :messages="$errors->get('documentFile')"/>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <x-secondary-button
                            data-bs-dismiss="modal"
                            wire:click="cancelEdit"
                        >
                            Close
                        </x-secondary-button>

                        <x-primary-button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="documentFile,submit"
                        >
                            <span wire:loading.remove wire:target="documentFile">Simpan</span>
                            <span wire:loading wire:target="documentFile">Mengunggah...</span>
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</div>
