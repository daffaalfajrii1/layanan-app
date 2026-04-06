<?php

namespace App\Livewire\Public\TaskFunction;

use App\Models\Master\Identity;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tugas dan Fungsi')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $identity = Identity::first();

        return view('livewire.public.task-function.index', compact('identity'));
    }
}
