<?php

use Illuminate\Support\Facades\Route;


use App\Livewire\BookingProcess;
use App\Livewire\Catalog;
use App\Livewire\StudentDashboard;

use App\Livewire\Login;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', Login::class)->middleware('guest')->name('login');
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/catalog', Catalog::class)->name('catalog');
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
    Route::get('/book/{item}', BookingProcess::class)->name('booking');
    Route::get('/print-request', \App\Livewire\PrintRequestForm::class)->name('print.request');
});
