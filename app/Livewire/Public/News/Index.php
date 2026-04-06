<?php

namespace App\Livewire\Public\News;

use App\Models\Master\Event;
use App\Models\Master\News;
use App\Models\Master\School;
use App\Models\Service\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Informasi')]
#[Layout('layouts.guest')]
class Index extends Component
{
    public function render()
    {
        $news = News::all();
        $services = Service::take(3)->get();

        return view('livewire.public.news.index', compact('news', 'services'));
    }
}
