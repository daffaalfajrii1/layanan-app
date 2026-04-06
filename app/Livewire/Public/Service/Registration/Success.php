<?php

namespace App\Livewire\Public\Service\Registration;

use App\Models\Registration\Registration;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Registrasi Berhasil')]
#[Layout('layouts.guest')]
class Success extends Component
{
    public $registration;

    public function mount($registrationNumber)
    {
        $this->registration = Registration::where('registration_number', $registrationNumber)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.public.service.registration.success');
    }
}
