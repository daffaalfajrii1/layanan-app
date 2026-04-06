<?php

namespace App\Livewire\Public\Service\Registration;

use App\Models\Registration\Registration;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cek Registrasi')]
#[Layout('layouts.guest')]
class Check extends Component
{
    public $registration = null;
    public $registrationNumber;

    public function checkRegistration()
    {
        $this->validate([
            'registrationNumber' => 'required|exists:registrations,registration_number',
        ], [
            'registrationNumber.required' => 'Nomor registrasi tidak boleh kosong.',
            'registrationNumber.exists' => 'Nomor registrasi tidak ditemukan.',
        ]);

        $this->registration = Registration::where('registration_number', $this->registrationNumber)->first();
    }

    public function render()
    {
        return view('livewire.public.service.registration.check');
    }
}
