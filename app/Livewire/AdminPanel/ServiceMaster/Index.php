<?php

namespace App\Livewire\AdminPanel\ServiceMaster;

use App\Models\Service\Service;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Kelola Layanan')]
class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public string $mode = 'add';
    public ?int $id = null;
    public string $name = '';
    public string $slug = '';

    #[Url()]
    public string $search = '';

    public function openModal(): void
    {
        $this->mode = 'add';
        $this->showModal = true;
        $this->reset(['id', 'name', 'slug']);
        $this->resetValidation();
    }

    public function updatedName(string $value): void
    {
        if ($this->mode === 'add' || blank($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function edit(int $id): void
    {
        $service = Service::findOrFail($id);

        $this->mode = 'edit';
        $this->showModal = true;
        $this->id = $service->id;
        $this->name = $service->name;
        $this->slug = $service->slug;
        $this->resetValidation();
    }

    public function cancelEdit(): void
    {
        $this->resetValidation();
    }

    public function submit(): void
    {
        if ($this->mode === 'edit') {
            $this->update();
        } else {
            $this->save();
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug',
        ]);

        Service::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
        ]);

        $this->showToastr('success', 'Layanan berhasil ditambahkan');
        $this->dispatch('closeModal');
        $this->reset(['id', 'name', 'slug']);
        $this->resetValidation();
        $this->showModal = false;
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:services,slug,' . $this->id,
        ]);

        Service::findOrFail($this->id)->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
        ]);

        $this->showToastr('success', 'Layanan berhasil diubah');
        $this->dispatch('closeModal');
        $this->reset(['id', 'name', 'slug']);
        $this->resetValidation();
        $this->showModal = false;
    }

    #[On('delete')]
    public function delete($id): void
    {
        $service = Service::withCount('registrations')->findOrFail($id);

        if ($service->registrations_count > 0) {
            $this->showToastr('error', 'Layanan tidak dapat dihapus karena masih memiliki data pendaftar.');
            return;
        }

        $service->documents()->delete();
        $service->delete();
        $this->showToastr('success', 'Layanan berhasil dihapus');
    }

    public function deleteConfirm($method, $params = null): void
    {
        $this->dispatch(
            'swal:confirm',
            title: 'Apakah anda yakin?',
            text: 'Layanan tanpa pendaftar akan dihapus beserta field-nya.',
            icon: 'warning',
            confirmButtonText: 'Hapus!',
            cancelButtonText: 'Batal',
            method: $method,
            params: $params,
            callback: ''
        );
    }

    public function showToastr($type, $message): void
    {
        $this->dispatch('show:toastify', type: $type, message: $message);
    }

    public function render(): View
    {
        $services = Service::query()
            ->withCount(['documents', 'registrations'])
            ->when(
                $this->search,
                fn ($q) => $q->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                })
            )
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.admin-panel.service-master.index', compact('services'));
    }
}
