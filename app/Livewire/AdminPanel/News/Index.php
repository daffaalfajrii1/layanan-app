<?php

namespace App\Livewire\AdminPanel\News;

use App\Models\Master\News;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Informasi')]
class Index extends Component
{
    use WithPagination;

    #[Url()]
    public string $search = '';

    #[On('delete')]
    public function delete($id): void
    {
        News::findOrFail($id)->delete();

        $this->showToastr('success', 'Data berhasil dihapus');
    }

    public function render()
    {
        $news = News::when($this->search, fn ($news) => $news->where('judul', 'like', '%' . $this->search . '%'))->paginate(10);

        return view('livewire.admin-panel.news.index', compact('news'));
    }

    public function showToastr($type, $message): void
    {
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    public function deleteConfirm($method, $params = null): void
    {
        $this->dispatch('swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal',
            method: $method,
            params: $params,
            callback: ''
        );
    }
}
