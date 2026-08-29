<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service\Service;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ServiceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $services = Service::with('documents')->orderBy('id')->get();

        return ServiceResource::collection($services);
    }

    public function show(Service $service): ServiceResource
    {
        $service->load('documents');

        return new ServiceResource($service);
    }
}
