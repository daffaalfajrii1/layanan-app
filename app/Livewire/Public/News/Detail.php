<?php

namespace App\Livewire\Public\News;

use App\Models\Master\News;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
class Detail extends Component
{
    public ?News $news;

    public function mount(News $news): void
    {
        $this->news = $news;
    }

    public function render(): View
    {
        $title = $this->news->judul;
        $otherNews = News::whereNot('id', $this->news->id)->latest()->limit(3)->get();

        return view('livewire.public.news.detail', compact('otherNews'))->title($title);
    }
}
