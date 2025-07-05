<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::view('home', 'home')->name('home');


// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::view('customers', 'customers.index')->name('customers.index');
    Route::view('customers/create', 'customers.create')->name('customers.create');
    Route::get('customers/{customer}', function (App\Models\Customer $customer) {
        return view('customers.show', compact('customer'));
    })->name('customers.show');
    Route::get('customers/{customer}/edit', function (App\Models\Customer $customer) {
        return view('customers.edit', compact('customer'));
    })->name('customers.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::get('/test-flux', function () {
    return view('test-flux');
})->name('test.flux');

require __DIR__.'/auth.php';
