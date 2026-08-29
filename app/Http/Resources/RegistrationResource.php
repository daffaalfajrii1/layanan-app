<?php

namespace App\Http\Resources;

use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'registration_number' => $this->registration_number,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at?->toIso8601String(),
            'service' => $this->whenLoaded('service', fn () => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'slug' => $this->service->slug,
            ]),
            'documents' => $this->whenLoaded('documents', function () {
                $registrationService = app(RegistrationService::class);

                return $this->documents->map(function ($document) use ($registrationService) {
                    $field = $document->document;

                    return [
                        'id' => $document->id,
                        'field_id' => $field?->id,
                        'key' => $field ? $registrationService->apiFieldKey($field) : null,
                        'label' => $field?->name,
                        'type' => $field?->type ?? ($document->file_path ? 'file' : 'text'),
                        'value' => $document->value,
                        'file_path' => $document->file_path,
                        'url' => $document->file_path ? asset('storage/' . $document->file_path) : null,
                    ];
                })->values();
            }),
        ];
    }
}
