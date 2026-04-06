<?php

namespace App\Livewire\Public\Document;

use App\Models\Master\Document;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dokument')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $documents = Document::all();

        return view('livewire.public.document.index', compact('documents'));
    }
}
