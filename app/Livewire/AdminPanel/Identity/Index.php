<?php

namespace App\Livewire\AdminPanel\Identity;

use App\Livewire\Forms\IdentityForm;
use App\Models\Master\Identity;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Identitas Website')]
class Index extends Component
{
    use WithFileUploads;
    public Identity $identity;
    public IdentityForm $form;

    public function mount()
    {
        $this->identity = Identity::first();
        $this->form->setIdentity($this->identity);
        $this->dispatch('recentLogo', avatar: $this->identity->logo);
    }

    public function edit(): void
    {
        $this->form->update();

        $this->resetValidation();
        $this->showToastr('success', 'Data Identitas Website berhasil diubah');
    }

    public function render()
    {
        return view('livewire.admin-panel.identity.index');
    }

    public function showToastr($type, $message): void
    {
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    public function deleteConfirm($method, $params = null): void
    {
        $this->dispatch('swal:confirm',
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
}
