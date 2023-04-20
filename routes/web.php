<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Middleware\TeamWorkspaceMiddleware;
use App\Http\Middleware\UserWorkspaceMiddleware;
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
    Route::get('/teams/participating', [TeamController::class, 'participating'])->name('teams.participating');
    Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');
    Route::post('/teams/{id}/join', [TeamController::class, 'joinTeam'])->name('teams.join');
    Route::post('/teams/{id}/leave', [TeamController::class, 'leaveTeam'])->name('teams.leave');
    Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::patch('/teams/{id}/update', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{id}/destroy', [TeamController::class, 'destroy'])->name('teams.destroy');
});

Route::middleware([TeamWorkspaceMiddleware::class])->group(function(){
    Route::get('/teams/{id}/workspace', [TeamController::class, 'showWorkspace'])->name('teams.workspace');
    Route::get('/teams/{id}/workspace/projects', [ProjectController::class, 'index'])->name('teams.projects');
    Route::get('/teams/{id}/workspace/projects/create', [ProjectController::class, 'create'])->name('teams.projects.create');
    Route::post('/teams/{id}/workspace/projects/store', [ProjectController::class, 'store'])->name('teams.projects.store');
});

Route::middleware([UserWorkspaceMiddleware::class])->group(function(){
    Route::get('/users/{id}/workspace', [ProfileController::class, 'showWorkspace'])->name('users.workspace');
    Route::get('/users/{id}/workspace/projects', [ProjectController::class, 'index'])->name('users.projects');
    Route::get('/users/{id}/workspace/projects/create', [ProjectController::class, 'create'])->name('users.projects.create');
    Route::post('/users/{id}/workspace/projects/store', [ProjectController::class, 'store'])->name('users.projects.store');
});

require __DIR__.'/auth.php';
