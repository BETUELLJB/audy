<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\LogController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

Route::middleware('guest')->group(function () {
   
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/auth/google', function () {
        $query = http_build_query([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'response_type' => 'code',
            'scope' => 'email profile',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);
    
        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    })->name('google.login');
    
    Route::get('/auth/google/callback', function (\Illuminate\Http\Request $request) {
        $code = $request->input('code');
    
        if (!$code) {
            return redirect('/login')->with('error', 'Não foi possível autenticar com o Google.');
        }
    
        // Trocar o código por um token de acesso
        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => env('GOOGLE_REDIRECT_URI'),
            'grant_type' => 'authorization_code',
            'code' => $code,
        ]);
    
        $data = $response->json();
    
        if (!isset($data['access_token'])) {
            return redirect('/login')->with('error', 'Erro ao obter o token de acesso.');
        }
    
        // Obter informações do utilizador com o token de acesso
        $userResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $data['access_token'],
        ])->get('https://www.googleapis.com/oauth2/v2/userinfo');
    
        $googleUser = $userResponse->json();
    
        // Processar o utilizador no sistema
        $user = \App\Models\User::where('email', $googleUser['email'])->first();
    
        if (!$user) {
            $user = \App\Models\User::create([
                'name' => $googleUser['name'],
                'email' => $googleUser['email'],
                'google_id' => $googleUser['id'],
                'password' => bcrypt('senha_aleatoria'), // Opcional
            ]);
        }
    
        // Fazer login do utilizador
        \Illuminate\Support\Facades\Auth::login($user);
    
        return redirect('/dashboard');
    });
            
});

#, 'check.device'
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
       
    Route::middleware('check.access:admin')->group(function (){
        Route::get('users', [RegisteredUserController::class, 'index'])->name('users.index');
        Route::post('register', [RegisteredUserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [RegisteredUserController::class, 'update'])->name('users.update');
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        Route::delete('users/{user}', [RegisteredUserController::class, 'destroy'])->name('destroy');
    });
});
