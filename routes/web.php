<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Chat;
use App\Livewire\Users;
use App\Livewire\Profile;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');
require __DIR__ . '/auth.php';


Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('/chat', Chat\Index::class)
        ->name('chat');
    Route::get('/chat/{chat}', Chat\Chat::class)
        ->name('chat.show');

    Route::get('/users', Users::class)
        ->name('users');

    Route::get('/user-profile/{user}', Profile\UserProfile::class)
        ->name('userProfile');
});
