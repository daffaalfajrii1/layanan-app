<?php

namespace App\Livewire\Public\Contact;

use App\Models\Master\Identity;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Kontak Kami')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $identity = Identity::first();

        return view('livewire.public.contact.index', compact('identity'));
    }
}
