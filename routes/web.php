<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Livewire\UserList;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PastorController;
use App\Http\Controllers\GuestLoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//  お問い合わせ
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::post('guest-login', [GuestLoginController::class, 'login'])->name('guest.login');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [PostController::class, 'index'])->name('dashboard');
    
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::resource('post',PostController::class);

    Route::middleware(['can:admin'])->group(function () {
        Route::get('users', UserList::class)->name('users.list');
        Route::get('pastors', [PastorController::class, 'index'])->name('pastor.index');
        Route::post('pastors', [PastorController::class, 'store'])->name('pastor.store');
        Route::delete('pastors/{pastor}', [PastorController::class, 'destroy'])->name('pastor.destroy');
    });
});

require __DIR__.'/auth.php';
