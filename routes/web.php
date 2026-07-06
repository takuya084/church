<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PostController;
use App\Livewire\UserList;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PastorController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//  お問い合わせ
Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', 'post')->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // 投稿の作成・編集・削除はログイン必須
    Route::get('post/youtube-title', [PostController::class, 'youtubeTitle'])->name('post.youtube-title');
    Route::resource('post', PostController::class)->except(['index', 'show']);

    Route::middleware(['can:admin'])->group(function () {
        Route::get('users', UserList::class)->name('users.list');
        Route::get('pastors', [PastorController::class, 'index'])->name('pastor.index');
        Route::post('pastors', [PastorController::class, 'store'])->name('pastor.store');
        Route::delete('pastors/{pastor}', [PastorController::class, 'destroy'])->name('pastor.destroy');
    });
});

// 閲覧はログイン不要（auth グループより後に登録し post/create 等を優先させる）
Route::get('post', [PostController::class, 'index'])->name('post.index');
Route::get('post/{post}', [PostController::class, 'show'])->name('post.show');

require __DIR__.'/auth.php';
