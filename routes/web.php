<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('teams', TeamController::class)
    ->only('index', 'create', 'store')
    ->middleware(['auth', 'verified']);

Route::post('update', [TeamController::class, 'update']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::post('/teams/{id}/join', [TeamController::class, 'joinTeam'])->name('teams.join');
    Route::post('/teams/{id}/leave', [TeamController::class, 'leaveTeam'])->name('teams.leave');
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::patch('/teams/{id}/update', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{id}/destroy', [TeamController::class, 'destroy'])->name('teams.destroy');
});

require __DIR__.'/auth.php';
