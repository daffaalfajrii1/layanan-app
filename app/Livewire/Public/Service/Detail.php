<?php

namespace App\Livewire\Public\Service;

use App\Models\Service\Service;
use App\Services\RegistrationService;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.guest')]
class Detail extends Component
{
    use WithFileUploads;

    public ?Service $service;
    public array $documents = [];

    public function mount(Service $service): void
    {
        $this->service = $service;

        foreach ($this->service->documents as $index => $document) {
            $this->documents[$index] = null;
        }
    }

    public function rules(): array
    {
        return app(RegistrationService::class)->validationRules($this->service);
    }

    public function submit(RegistrationService $registrationService)
    {
        $this->validate();

        $registration = $registrationService->submit($this->service, $this->documents);

        foreach ($this->service->documents as $index => $document) {
            $this->documents[$index] = null;
        }

        session()->flash('message', 'Pendaftaran berhasil dikirim dengan nomor registrasi: ' . $registration->registration_number);

        return redirect()->route('public.service.registration.success', $registration->registration_number);
    }

    public function render(): View
    {
        $title = $this->service->name;

        return view('livewire.public.service.detail')->title($title);
    }
}
