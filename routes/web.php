<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('appointments', App\Http\Controllers\Admin\AppointmentController::class);
        Route::get('appointments/{appointment}/consultation', App\Livewire\Admin\ConsultationManager::class)->name('appointments.consultation');
        
        Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class);
        Route::get('doctors/{doctor}/schedule', App\Livewire\Admin\ScheduleManager::class)->name('doctors.schedule');
    });
});
