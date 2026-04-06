<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return redirect(route('admin.login'));
// });


Route::get('/', \App\Livewire\Public\Home\Index::class)->name('public.home');

Route::get('/infomasi', \App\Livewire\Public\News\Index::class)->name('public.news.index');
Route::get('/infomasi/{news:slug}', \App\Livewire\Public\News\Detail::class)->name('public.news.detail');

Route::get('/kontak', \App\Livewire\Public\Contact\Index::class)->name('public.contact.index');

Route::get('/dokumen', \App\Livewire\Public\Document\Index::class)->name('public.document.index');

Route::get('/tentang', \App\Livewire\Public\About\Index::class)->name('public.about.index');

Route::get('/visi-misi', \App\Livewire\Public\VisionMission\Index::class)->name('public.vision-mission.index');
Route::get('/tugas-dan-fungsi', \App\Livewire\Public\TaskFunction\Index::class)->name('public.task-function.index');

Route::get('/layanan', \App\Livewire\Public\Service\Index::class)->name('public.service.index');
Route::get('/layanan/{service:slug}', \App\Livewire\Public\Service\Detail::class)->name('public.service.detail');

Route::get('/layanan/registrasi/success/{registrationNumber}', \App\Livewire\Public\Service\Registration\Success::class)->name('public.service.registration.success');
Route::get('/layanan/registrasi/cek', \App\Livewire\Public\Service\Registration\Check::class)->name('public.service.registration.check');

Route::prefix('admin-panel')->group(function () {
    Route::get('/login', App\Livewire\AdminPanel\Auth\Login::class)->name('admin.login');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', \App\Livewire\AdminPanel\Dashboard\Index::class)->name('admin.dashboard');

        // Roles
        Route::get('/roles', \App\Livewire\AdminPanel\Roles\Index::class)->name('admin.roles.index');

        // Users
        Route::get('/users', App\Livewire\AdminPanel\Users\Index::class)->name('admin.users.index');
        Route::get('/users/create', \App\Livewire\AdminPanel\Users\Form::class)->name('admin.users.create');
        Route::get('/users/edit/{user}', \App\Livewire\AdminPanel\Users\Form::class)->name('admin.users.edit');

        // News
        Route::get('/news', \App\Livewire\AdminPanel\News\Index::class)->name('admin.news.index');
        Route::get('/news/create', \App\Livewire\AdminPanel\News\Form::class)->name('admin.news.create');
        Route::get('/news/edit/{news}', \App\Livewire\AdminPanel\News\Form::class)->name('admin.news.edit');

        // Categories
        Route::get('/categories', \App\Livewire\AdminPanel\Categories\Index::class)->name('admin.categories.index');

        // Services
        Route::get('/services', \App\Livewire\AdminPanel\Services\Index::class)->name('admin.services.index');

        // Documents
        Route::get('/documents', \App\Livewire\AdminPanel\Documents\Index::class)->name('admin.documents.index');

        // Identity
        Route::get('/identity', \App\Livewire\AdminPanel\Identity\Index::class)->name('admin.identity.index');

        Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');
    });
});
