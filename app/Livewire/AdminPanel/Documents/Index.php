<?php

namespace App\Livewire\AdminPanel\Documents;

use App\Models\Master\Document;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

#[Title('Dokumen')]
class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    // ====== State modal / form ======
    public bool $showModal = false;
    public string $mode = 'add'; // 'add' | 'edit'

    public ?int $id = null;

    public string $name = '';
    public $file = null;        // Livewire temporary uploaded file
    public ?string $recentFile = null; // file lama saat edit

    #[Url()]
    public string $search = '';

    // =========================
    // Modal handlers
    // =========================
    public function openModal(): void
    {
        // mode tambah data baru
        $this->mode = 'add';
        $this->showModal = true;

        // reset form
        $this->reset(['id', 'name', 'file', 'recentFile']);
        $this->resetValidation();
    }

    public function edit($id): void
    {
        $document = Document::findOrFail($id);

        $this->mode       = 'edit';
        $this->showModal  = true;

        $this->id         = $document->id;
        $this->name       = $document->name;
        $this->recentFile = $document->file;
        $this->file       = null;

        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
        // tidak menutup modal sengaja, hanya clear error
    }

    // =========================
    // Submit gateway (digunakan form)
    // =========================
    public function submit(): void
    {
        if ($this->mode === 'edit') {
            $this->update();
        } else {
            $this->save();
        }
    }

    // =========================
    // Create
    // =========================
    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|max:5120', // 5 MB
            // contoh batasi extension:
            // 'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        ]);

        $storedFileName = $this->handleUploadedFile($this->file, $this->name);

        Document::create([
            'name' => $this->name,
            'file' => $storedFileName,
        ]);

        $this->showToastr('success', 'Data berhasil ditambahkan');

        // tutup modal & reset form
        $this->dispatch('closeModal');
        $this->reset(['id', 'name', 'file', 'recentFile']);
        $this->resetValidation();
        $this->showModal = false;
    }

    // =========================
    // Update
    // =========================
    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|max:5120',
            // 'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:5120',
        ]);

        $document = Document::findOrFail($this->id);

        $newFileName = $document->file;

        if ($this->file) {
            $newFileName = $this->handleUploadedFile($this->file, $this->name);
        }

        $document->update([
            'name' => $this->name,
            'file' => $newFileName,
        ]);

        $this->showToastr('success', 'Data berhasil diubah');

        $this->dispatch('closeModal');
        $this->reset(['id', 'name', 'file', 'recentFile']);
        $this->resetValidation();
        $this->showModal = false;
    }

    // =========================
    // Delete flow
    // =========================
    #[On('delete')]
    public function delete($id): void
    {
        Document::findOrFail($id)->delete();
        $this->showToastr('success', 'Data berhasil dihapus');
    }

    // konfirmasi popup sweetalert dari blade
    public function deleteConfirm($method, $params = null): void
    {
        // kirim event utk SweetAlert di front-end
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

    // =========================
    // Helper: upload file
    // =========================
    public function handleUploadedFile($uploadedFile, $name): string
    {
        // generate nama file unik
        $fileName = time()
            . '-' . Str::slug($name)
            . '.' . $uploadedFile->getClientOriginalExtension();

        // simpan ke storage/app/public/files/documents
        $uploadedFile->storeAs('files/documents', $fileName, 'public');

        return $fileName;
    }

    // =========================
    // Toast helper
    // =========================
    public function showToastr($type, $message): void
    {
        // nanti ditangkap JS buat nampilin toastify
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    // =========================
    // Render
    // =========================
    public function render(): View
    {
        $documents = Document::query()
            ->when(
                $this->search,
                fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin-panel.documents.index', compact('documents'));
    }
}
