<?php

namespace App\Livewire\Public\Service;

use App\Models\Registration\Registration;
use App\Models\Registration\RegistrationDocument;
use App\Models\Service\Service;
use Livewire\Attributes\Layout;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

#[Layout('layouts.guest')]
class Detail extends Component
{
    use WithFileUploads;

    public ?Service $service;
    public array $documents = [];

    public function mount(Service $service): void
    {
        $this->service = $service;

        // Initialize documents array based on the service documents
        foreach ($this->service->documents as $index => $document) {
            $this->documents[$index] = null;
        }
    }

    public function rules()
    {
        $rules = [];

        // Add validation rules for each document
        foreach ($this->service->documents as $index => $document) {
            $rule = $document->is_required ? 'required' : 'nullable';

            switch ($document->type) {
                case 'file':
                    $rules["documents.$index"] = "$rule|file|max:10240"; // Max 10MB
                    break;
                case 'email':
                    $rules["documents.$index"] = "$rule|email|max:255";
                    break;
                case 'date':
                    $rules["documents.$index"] = "$rule|date";
                    break;
                case 'time':
                    $rules["documents.$index"] = "$rule|date_format:H:i";
                    break;
                default:
                    $rules["documents.$index"] = "$rule|string|max:255";
            }
        }

        return $rules;
    }

    public function submit()
    {
        $this->validate();

        // Create registration
        $registration = Registration::create([
            'service_id' => $this->service->id,
            'registration_number' => $this->generateRegistrationNumber(),
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Process documents
        foreach ($this->service->documents as $index => $document) {
            $value = null;
            $filePath = null;

            if ($document->type === 'file' && $this->documents[$index]) {
                // Store file and get path
                $fileName = time() . '_' . $this->documents[$index]->getClientOriginalName();
                $filePath = $this->documents[$index]->storeAs('documents', $fileName, 'public');
            } else {
                $value = $this->documents[$index];
            }

            // Create registration document
            RegistrationDocument::create([
                'registration_id' => $registration->id,
                'service_document_id' => $document->id,
                'value' => $value,
                'file_path' => $filePath,
            ]);
        }

        // Reset form
        foreach ($this->service->documents as $index => $document) {
            $this->documents[$index] = null;
        }

        session()->flash('message', 'Pendaftaran berhasil dikirim dengan nomor registrasi: ' . $registration->registration_number);

        return redirect()->route('public.service.registration.success', $registration->registration_number);
    }

    private function generateRegistrationNumber(): string
    {
        $prefix = date('Ymd');
        $random = strtoupper(Str::random(6));
        return "{$prefix}-{$random}";
    }

    public function render(): View
    {
        $title = $this->service->name;

        return view('livewire.public.service.detail')->title($title);
    }
}
