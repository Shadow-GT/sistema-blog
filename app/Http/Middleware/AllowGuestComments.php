<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowGuestComments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Permitir comentarios tanto de usuarios autenticados como invitados
        // Este middleware se puede usar para agregar lógica adicional si es necesario
        // Por ejemplo, rate limiting para usuarios invitados

        if (!auth()->check()) {
            // Lógica adicional para usuarios invitados si es necesaria
            // Por ejemplo, verificar rate limiting por IP
        }

        return $next($request);
    }
}
