<?php

namespace App\Livewire\Public\About;

use App\Models\Master\Identity;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tentang Kami')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $identity = Identity::first();

        return view('livewire.public.about.index', compact('identity'));
    }
}
