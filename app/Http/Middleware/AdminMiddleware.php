<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $usuario = auth()->user();

        if ($usuario->bloqueado) {
            auth()->logout();
            return redirect()->route('login');
        }

        if (! $usuario->esAdministrador()) {
            abort(403, 'No tenés permiso para acceder al panel administrador.');
        }

        return $next($request);
    }
}