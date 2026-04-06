<?php

namespace App\Livewire\Public\Home;

use App\Models\Master\Identity;
use App\Models\Master\News;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Beranda')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $identity = Identity::find(1);
        $news = News::orderBy('created_at', 'desc')->limit(3)->get();

        return view('livewire.public.home.index', compact('identity', 'news'));
    }
}
