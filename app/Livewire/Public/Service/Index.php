<?php

namespace App\Livewire\Public\Service;

use App\Models\Service\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Layanan')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $services = Service::with('documents')->get();

        return view('livewire.public.service.index', compact('services'));
    }
}
