<?php

namespace App\Livewire\AdminPanel\Dashboard;

use App\Models\Master\News;
use App\Models\Registration\Registration;
use App\Models\Service\Service;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Index extends Component
{
    public function render(): View
    {
        $data = [
            'total_services' => Service::count(),
            'total_registrations' => Registration::count(),
            'total_informations' => News::count(),
            'total_users' => User::count(),
        ];

        return view('livewire.admin-panel.dashboard.index', compact('data'));
    }
}
