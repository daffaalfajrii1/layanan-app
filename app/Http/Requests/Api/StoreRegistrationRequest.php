<?php

namespace App\Http\Requests\Api;

use App\Models\Service\Service;
use App\Services\RegistrationService;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $service = $this->service();
        $rules = app(RegistrationService::class)->validationRules($service, RegistrationService::KEY_API);

        return ['documents' => [$service->documents->isEmpty() ? 'sometimes' : 'required', 'array']] + $rules;
    }

    private function service(): Service
    {
        $service = $this->route('service');

        if ($service instanceof Service) {
            return $service->loadMissing('documents');
        }

        return Service::where('slug', $this->route('slug'))
            ->with('documents')
            ->firstOrFail();
    }
}
