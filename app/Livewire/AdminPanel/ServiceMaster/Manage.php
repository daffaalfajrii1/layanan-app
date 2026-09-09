<?php

namespace App\Livewire\AdminPanel\ServiceMaster;

use App\Models\Service\Service;
use App\Models\Service\ServiceDocument;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kelola Field Layanan')]
class Manage extends Component
{
    public Service $service;

    public bool $showModal = false;
    public string $mode = 'add';
    public ?int $documentId = null;
    public string $name = '';
    public string $type = 'text';
    public bool $is_required = true;

    /** @var array<int, string> */
    public array $typeOptions = [
        'text' => 'Text',
        'file' => 'File',
        'date' => 'Date',
        'email' => 'Email',
        'time' => 'Time',
    ];

    public function mount(Service $service): void
    {
        $this->service = $service;
    }

    public function openModal(): void
    {
        $this->mode = 'add';
        $this->showModal = true;
        $this->reset(['documentId', 'name']);
        $this->type = 'text';
        $this->is_required = true;
        $this->resetValidation();
    }

    public function edit(int $id): void
    {
        $document = ServiceDocument::where('service_id', $this->service->id)->findOrFail($id);

        $this->mode = 'edit';
        $this->showModal = true;
        $this->documentId = $document->id;
        $this->name = $document->name;
        $this->type = $document->type;
        $this->is_required = (bool) $document->is_required;
        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
    }

    public function submit(): void
    {
        if ($this->mode === 'edit') {
            $this->update();
        } else {
            $this->save();
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,file,date,email,time',
            'is_required' => 'boolean',
        ]);

        ServiceDocument::create([
            'service_id' => $this->service->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'is_required' => $validated['is_required'] ? 1 : 0,
        ]);

        $this->showToastr('success', 'Field berhasil ditambahkan');
        $this->closeForm();
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,file,date,email,time',
            'is_required' => 'boolean',
        ]);

        $document = ServiceDocument::where('service_id', $this->service->id)->findOrFail($this->documentId);

        $document->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'is_required' => $validated['is_required'] ? 1 : 0,
        ]);

        $this->showToastr('success', 'Field berhasil diubah');
        $this->closeForm();
    }

    #[On('delete')]
    public function delete($id): void
    {
        $document = ServiceDocument::withCount('registrationDocuments')
            ->where('service_id', $this->service->id)
            ->findOrFail($id);

        if ($document->registration_documents_count > 0) {
            $this->showToastr('error', 'Field tidak dapat dihapus karena sudah digunakan pada data pendaftar.');
            return;
        }

        $document->delete();
        $this->showToastr('success', 'Field berhasil dihapus');
    }

    public function deleteConfirm($method, $params = null): void
    {
        $this->dispatch(
            'swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Field yang dihapus tidak dapat dikembalikan!',
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

    private function closeForm(): void
    {
        $this->dispatch('closeModal');
        $this->reset(['documentId', 'name']);
        $this->type = 'text';
        $this->is_required = true;
        $this->resetValidation();
        $this->showModal = false;
    }

    public function render(): View
    {
        $documents = ServiceDocument::query()
            ->where('service_id', $this->service->id)
            ->withCount('registrationDocuments')
            ->orderBy('id')
            ->get();

        return view('livewire.admin-panel.service-master.manage', compact('documents'));
    }
}
