<?php

use Illuminate\Support\Facades\Route;
use App\Models\Log;

use App\Http\Controllers\Auth\TwoFactorAuthController;
use App\Http\Controllers\Auth\SettingsController;

use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\WeatherController;

Route::get('/auth/github', [GithubController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [GithubController::class, 'handleGithubCallback'])->name('auth.github.callback');

Route::get('/two-factor', [TwoFactorAuthController::class, 'show'])->name('auth.two-factor');
Route::post('/two-factor', [TwoFactorAuthController::class, 'verify']);
Route::post('/two-factor/resend', [TwoFactorAuthController::class, 'resend'])->name('auth.two-factor.resend');


Route::get('/', function () {
    return view('welcome');
})->name('inicio');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
   

    Route::get('/clima', [WeatherController::class, 'showWeather'])->name('weather.show');


    
    Route::middleware('check.access:admin,gerente')->group(function () {
        // Visualizar
        Route::get('funcionarios/{funcionario}', [ FuncionarioController::class, 'show'])->name('funcionarios.show'); // Detalhes
        Route::get('funcionarios', [ FuncionarioController::class, 'index'])->name('funcionarios.index');
    });

    // Acesso exclusivo para administradores
    Route::middleware('check.access:admin')->group(function () {
       
        Route::post('funcionarios', [ FuncionarioController::class, 'store'])->name('funcionarios.store'); // Criar
        Route::put('funcionarios/{funcionario}', [ FuncionarioController::class, 'update'])->name('funcionarios.update'); // Atualizar
        Route::delete('funcionarios/{funcionario}', [ FuncionarioController::class, 'destroy'])->name('funcionarios.destroy'); // Apagar   
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/two-factor', [SettingsController::class, 'toggleTwoFactor'])->name('settings.toggleTwoFactor');
    });
  
});

require __DIR__.'/auth.php';
