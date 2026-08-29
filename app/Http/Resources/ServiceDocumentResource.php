<?php

namespace App\Http\Resources;

use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $registrationService = app(RegistrationService::class);
        $key = $registrationService->apiFieldKey($this->resource);

        return [
            'id' => $this->id,
            'key' => $key,
            'label' => $this->name,
            'type' => $this->type,
            'required' => (bool) $this->is_required,
            'input_name' => "documents[{$key}]",
            'rules' => explode('|', $registrationService->validationRuleForDocument($this->resource)),
        ];
    }
}
