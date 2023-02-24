<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('team/create', [\App\Http\Controllers\Team\TeamController::class, 'create'])->name('teams.create');
    Route::post('team', [\App\Http\Controllers\Team\TeamController::class, 'store'])->name('teams.store');
    Route::get('team', [\App\Http\Controllers\Team\TeamController::class, 'show'])->name('teams.show');

    Route::post('team/{user}/detach', [\App\Http\Controllers\Team\MemberController::class, 'detachUser'])->name('teams.members.detach');

    Route::post('team/invite-member', [\App\Http\Controllers\Team\InviteController::class, 'store'])->name('teams.member.invite');
    Route::get('team/invite/{token}/accept', [\App\Http\Controllers\Team\InviteController::class, 'accept'])->name('teams.member.invite.accept');
    Route::delete('team/invite/{invite}', [\App\Http\Controllers\Team\InviteController::class, 'destroy'])->name('teams.member.invite.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
