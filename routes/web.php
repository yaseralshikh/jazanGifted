<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    // Admin education-regions
    Route::view('education-regions', 'livewire.backend.education-regions.regions')
        ->name('education-regions');
    // Admin Provinces
    Route::view('provinces', 'livewire.backend.provinces.provinces')
        ->name('provinces');
    // Admin Schools
    Route::view('schools', 'livewire.backend.schools.schools')
        ->name('schools');
    // Admin Users
    Route::view('users', 'livewire.backend.users.users')
        ->name('users');
    // Admin Academic Years
    Route::view('academic-years', 'livewire.backend.academicyears.academic-years')
        ->name('academic-years');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
