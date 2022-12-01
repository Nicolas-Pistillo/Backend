<?php

namespace App\Http\Middleware;

use App\Traits\BasicApiFunctions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJWTAuth
{
    use BasicApiFunctions;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) return $this->error('No autorizado', 
            'No se ha recibido un Token de acceso en la petición'
        );

        // Verificamos si el token es correcto
        try {
            
            $payload = Auth::payload();

        } catch (\Throwable $err) 
        {
            return $this->error('Token incorrecto', 
                "Es posible que el token ya haya expirado o que este mal formado. Puede volver a iniciar sesión para refrescar su token"
            );
        }

        /**
         * Agregamos la expiracion de este token a la request para
         * ser devuelto en la respuesta hacia el cliente
         */
        $request->merge(['tokenExpiration' => $payload->get('exp')]);

        return $next($request);
    }
}
