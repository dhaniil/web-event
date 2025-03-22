<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\BeritaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UlasanController;
use App\Http\Middleware\TrackPengunjung;

// Landing Page & Home
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/login', function () {
    return redirect('/auth?mode=login');
})->name('login');
Route::get('register', function () {
    return redirect('/auth?mode=register');
})->name('register');

Route::get('/home', [EventController::class, 'index'])->name('events.dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update.profile');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update.picture');
    Route::post('/profile/delete-picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.delete.picture');
    Route::put('/profile/update-kelas-jurusan', [ProfileController::class, 'updateKelasJurusan'])->name('profile.update.kelas-jurusan');
});


//Ulasan
Route::middleware(['auth'])->group(function () {
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
});

Route::get('/debug/banners', [App\Http\Controllers\EventBannerController::class, 'checkBannerDisplay'])
    ->middleware('auth'); // Protect with auth to prevent public access

// Event 
Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('events.show')
    ->middleware(TrackPengunjung::class);
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/event/only', [EventController::class, 'EventPage'])->name('events.eventonly');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

// Favourite
Route::middleware('auth')->group(function () {
    // Menambahkan/menghapus favorit
    Route::post('/favourite/{event}', [FavouriteController::class, 'favourite'])
        ->name('favourite.add');
    Route::delete('/favourite/{event}', [FavouriteController::class, 'unfavourite'])
        ->name('favourite.remove');
    
    // Halaman daftar favorit
    Route::get('/favourites', [FavouriteController::class, 'favouriteEvents'])
        ->name('favourites');
});

// Berita
Route::middleware('auth')->group(function () {
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
});

// Update the logout routes
Route::middleware('auth')->group(function () {
    // Handle POST logout (form submission)
    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');

    // Handle GET logout (direct URL access)
    Route::get('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    });
});

Route::get('/search', [SearchController::class, 'search'])->name('search');


require __DIR__.'/auth.php';
