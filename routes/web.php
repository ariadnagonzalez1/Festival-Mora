<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Livewire\Public\Home\HomePage;
use App\Livewire\Public\Eventos\EventosPage;
use App\Livewire\Public\Experiencias\ExperienciasPage;

use App\Livewire\Auth\Login\LoginPage;
use App\Livewire\Auth\Register\RegisterPage;

use App\Livewire\Admin\Dashboard\DashboardPage;
use App\Livewire\Admin\Eventos\EventosPage as AdminEventosPage;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
| Estas pantallas las puede ver cualquier persona sin iniciar sesión.
*/

Route::get('/', HomePage::class)->name('public.inicio');

Route::get('/eventos', EventosPage::class)->name('public.eventos');

Route::get('/experiencias-mora', ExperienciasPage::class)->name('public.experiencias');


/*
|--------------------------------------------------------------------------
| Login y registro
|--------------------------------------------------------------------------
| Solo aparecen si el usuario NO está logueado.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
| Cierra sesión y vuelve al inicio.
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('public.inicio');
})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas administrador
|--------------------------------------------------------------------------
| Solo puede entrar el usuario con rol administrador.
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', DashboardPage::class)->name('dashboard');

        Route::get('/eventos', AdminEventosPage::class)->name('eventos');

        Route::redirect('/', '/admin/dashboard');
    });