<?php

namespace App\Livewire\Public\VisionMission;

use App\Models\Master\Identity;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Visi Misi')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $identity = Identity::first();

        return view('livewire.public.vision-mission.index', compact('identity'));
    }
}
