<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Adicione os cabeçalhos de CORS à resposta
        $response->header('Access-Control-Allow-Origin', '*'); // Permite todas as origens (não recomendado para produção)
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Requested-With, Authorization');

        return $response;
    }
}
