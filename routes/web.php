<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoordinatorCOntroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrackerController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {

    $user = auth()->user();

    if($user->isAdmin()){
        return redirect()->route('admin.dashboard');
    }else if($user->isCoordinator()){
        return redirect()->route('coordinator.dashboard');
    }else{
        return redirect()->route('teacher.dashboard');
    }

})->middleware(['auth', 'verified'])->name('dashboard');


// Teacher Routes

Route::middleware(['auth','verified', 'role:teacher'])->group(function () {
        Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');
        Route::resource('trackers', TrackerController::class);

});

// Coordinator Routes

Route::middleware(['auth','verified','role:coordinator'])->group(function () {

    Route::get('/coordinator/dashboard', [CoordinatorCOntroller::class, 'dashboard'])->name('coordinator.dashboard');
    Route::get('/coordinator/teachers', [CoordinatorCOntroller::class, 'teachers'])->name('coordinator.teachers');
    Route::get('/coordinator/trackers', [CoordinatorCOntroller::class, 'trackers'])->name('coordinator.trackers');
    Route::post('/coordinator/trackers/{tracker}/review', [CoordinatorCOntroller::class,'review'])->name('coordinator.trackers.review');

});

// Admin ROutes

Route::middleware(['auth','verified','role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class,'users'])->name('admin.users');
    Route::get('/admin/trackers', [AdminController::class,'trackers'])->name(  'admin.trackers');
    Route::get('/admin/tracker-types', [AdminController::class,'trackerTypes'])->name('admin.tracker-types');
    Route::post('/admin/assign-coordinator', [AdminController::class,'assignCoordinator'])->name('admin.assign-coordinator');

});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
