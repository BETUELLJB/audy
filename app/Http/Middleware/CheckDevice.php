<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $deviceIdentifier = $request->header('X-Device-Identifier'); // Identificador passado no cabeçalho da requisição

        if (!$deviceIdentifier) {
            return response()->json(['error' => 'Dispositivo não identificado.'], 403);
        }

        // Verifica se o dispositivo está registrado
        $device = Device::where('user_id', $user->id)
                        ->where('device_identifier', $deviceIdentifier)
                        ->first();

        if (!$device) {
            return response()->json(['error' => 'Dispositivo não autorizado.'], 403);
        }

        return $next($request);
    }
}
