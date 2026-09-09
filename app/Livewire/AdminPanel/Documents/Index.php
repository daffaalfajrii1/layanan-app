<?php

namespace App\Livewire\AdminPanel\Documents;

use App\Models\Master\Document;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Dokumen')]
class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public string $mode = 'add';

    public ?int $id = null;
    public string $name = '';
    public ?string $recentFile = null;

    #[Url()]
    public string $search = '';

    public function mount(): void
    {
        if ($modal = session('document_modal')) {
            $this->mode = $modal['mode'] ?? 'add';
            $this->id = $modal['id'] ?? null;
            $this->recentFile = $modal['file'] ?? null;
            $this->name = old('name', '');
            $this->showModal = true;
        }
    }

    public function openModal(): void
    {
        $this->mode = 'add';
        $this->showModal = true;
        $this->reset(['id', 'name', 'recentFile']);
        $this->resetValidation();
    }

    public function edit($id): void
    {
        $document = Document::findOrFail($id);

        $this->mode = 'edit';
        $this->showModal = true;
        $this->id = $document->id;
        $this->name = $document->name;
        $this->recentFile = $document->file;
        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
    }

    #[On('delete')]
    public function delete($id): void
    {
        Document::findOrFail($id)->delete();
        $this->showToastr('success', 'Data berhasil dihapus');
    }

    public function deleteConfirm($method, $params = null): void
    {
        $this->dispatch(
            'swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal',
            method: $method,
            params: $params,
            callback: ''
        );
    }

    public function showToastr($type, $message): void
    {
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    public function getUploadDiagnosticsProperty(): array
    {
        $dirs = [
            storage_path('app/livewire-tmp'),
            storage_path('app/public/livewire-tmp'),
            storage_path('app/public/files/documents'),
        ];

        $writable = collect($dirs)->every(fn ($dir) => is_dir($dir) && is_writable($dir));

        return [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'storage_writable' => $writable,
        ];
    }

    public function render(): View
    {
        $documents = Document::query()
            ->when(
                $this->search,
                fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin-panel.documents.index', [
            'documents' => $documents,
            'diagnostics' => $this->uploadDiagnostics,
        ]);
    }
}
