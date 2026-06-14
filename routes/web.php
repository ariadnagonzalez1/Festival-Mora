<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Livewire\Public\Home\HomePage;
use App\Livewire\Public\Eventos\EventosPage;
use App\Livewire\Public\Experiencias\ExperienciasPage;

use App\Livewire\Auth\Login\LoginPage;
use App\Livewire\Auth\Register\RegisterPage;

use App\Livewire\User\MisEntradas\MisEntradasPage;

use App\Livewire\Admin\Dashboard\DashboardPage;
use App\Livewire\Admin\Eventos\EventosPage as AdminEventosPage;
use App\Livewire\Admin\Artistas\ArtistasPage;
use App\Livewire\Admin\Ventas\VentasPage;
use App\Livewire\Admin\ValidarQr\ValidarQrPage;
use App\Livewire\Admin\Usuarios\UsuariosPage;
use App\Livewire\Admin\Configuracion\ConfiguracionPage;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', HomePage::class)->name('public.inicio');

Route::get('/eventos', EventosPage::class)->name('public.eventos');

Route::get('/experiencias-mora', ExperienciasPage::class)->name('public.experiencias');


/*
|--------------------------------------------------------------------------
| Login y registro
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
});


/*
|--------------------------------------------------------------------------
| Rutas de usuario logueado
|--------------------------------------------------------------------------
| Mis entradas NO va dentro de admin.
*/

Route::middleware('auth')->group(function () {
    Route::get('/mis-entradas', MisEntradasPage::class)->name('user.mis-entradas');
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
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
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', DashboardPage::class)->name('dashboard');
        Route::get('/eventos', AdminEventosPage::class)->name('eventos');
        Route::get('/artistas', ArtistasPage::class)->name('artistas');
        Route::get('/ventas', VentasPage::class)->name('ventas');
        Route::get('/validar-qr', ValidarQrPage::class)->name('validar-qr');
        Route::get('/usuarios', UsuariosPage::class)->name('usuarios');
        Route::get('/configuracion', ConfiguracionPage::class)->name('configuracion');

        Route::redirect('/', '/admin/dashboard');
    });