<?php

namespace App\Livewire\AdminPanel\Services;

use App\Models\Master\Services;
use App\Models\Registration\Registration;
use App\Models\Registration\RegistrationDocument;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Pendaftar Layanan')]
class Index extends Component
{
    use WithPagination;

    #[Url()]
    public string $search = '';

    public ?Registration $selectedRegistration = null;
    public array $documents = [];

    #[On('approve')]
    public function approve($id): void
    {
        Registration::findOrFail($id)->update(['status' => 'approved']);

        $this->showToastr('success', 'Surat berhasil disetujui');
    }

    #[On('reject')]
    public function reject($id): void
    {
        Registration::findOrFail($id)->update(['status' => 'rejected']);

        $this->showToastr('success', 'Surat berhasil ditolak');
    }

    public function showModal($registrationId): void
    {
        $this->selectedRegistration = Registration::findOrFail($registrationId);
        $this->documents = RegistrationDocument::with('document')->where('registration_id', $registrationId)->get()->toArray();

        $this->dispatch('show-modal', name: 'showModal');
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
    }

    public function render()
    {
        $registrations = Registration::when($this->search, fn ($registrations) => $registrations->where('registration_number', 'like', '%' . $this->search . '%'))->paginate(10);

        return view('livewire.admin-panel.services.index', compact('registrations'));
    }

    public function showToastr($type, $message): void
    {
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    public function approveConfirm($method, $params = null): void
    {
        $this->dispatch('swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Surat yang disetujui tidak dapat diubah!',
            icon: 'warning',
            confirmButtonText: 'Setujui!',
            cancelButtonText: 'Batal',
            method: $method,
            params: $params,
            callback: ''
        );
    }

    public function rejectConfirm($method, $params = null): void
    {
        $this->dispatch('swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Surat yang ditolak tidak dapat diubah!',
            icon: 'warning',
            confirmButtonText: 'Tolak!',
            cancelButtonText: 'Batal',
            method: $method,
            params: $params,
            callback: ''
        );
    }
}
