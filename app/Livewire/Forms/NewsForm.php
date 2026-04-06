<?php

namespace App\Livewire\Forms;

use App\Models\Master\News;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Str;

class NewsForm extends Form
{
    public ?News $news = null;

    #[Rule('required')]
    public $category_id = '';

    #[Rule('required')]
    public string $judul = '';

    public string $slug = '';

    #[Rule('required')]
    public string $isi = '';

    #[Rule('required')]
    public $thumbnail = '';

    public int $created_by = 0;

    public function setNews(News $news): void
    {
        $this->news = $news;
        $this->category_id = $news->category_id;
        $this->judul = $news->judul;
        $this->slug = $news->slug;
        $this->isi = $news->isi;
        $this->thumbnail = $news->thumbnail;
        $this->created_by = $news->created_by;
    }

    public function store(): void
    {
        $this->validate();

        $this->thumbnail = $this->thumbnail ? $this->handleUploadedImage($this->thumbnail, $this->judul) : 'default.jpg';
        $this->slug = Str::slug($this->judul);
        $this->created_by = auth()->user()->id;

        News::create($this->except('news'));

        $this->reset();
    }

    public function update(): void
    {
        $this->validate();

        $this->thumbnail = $this->thumbnail !== $this->news->thumbnail ? $this->handleUploadedImage($this->thumbnail, $this->judul) : $this->news->thumbnail;
        $this->slug = Str::slug($this->judul);

        $this->news->update($this->except('news'));

        $this->reset();
    }

    public function handleUploadedImage($image, $name): string
    {
        if ($image) {
            $image = $image;
            $imageName = time() . '-' . Str::slug($name) . '.' . $image->getClientOriginalExtension();

            $image->storeAs('images/news', $imageName, 'public');
            return $imageName;
        }
    }
}
