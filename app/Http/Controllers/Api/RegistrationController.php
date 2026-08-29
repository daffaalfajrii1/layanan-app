<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRegistrationRequest;
use App\Http\Resources\RegistrationResource;
use App\Models\Registration\Registration;
use App\Models\Service\Service;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;

class RegistrationController extends Controller
{
    public function store(
        StoreRegistrationRequest $request,
        Service $service,
        RegistrationService $registrationService
    ): JsonResponse {
        $service->load('documents');

        $registration = $registrationService->submit(
            $service,
            $request->validated('documents') ?? [],
            RegistrationService::KEY_API
        );

        $registration->load(['service', 'documents.document']);

        return (new RegistrationResource($registration))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Registration $registration): RegistrationResource
    {
        $registration->load(['service', 'documents.document']);

        return new RegistrationResource($registration);
    }
}
