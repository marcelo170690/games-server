<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{

    public function handle($request, Closure $next)
    {
        $domains = ['http://localhost:8081'];

        return $next($request)
            //Url a la que se le dará acceso en las peticiones
            ->header("Access-Control-Allow-Origin", "http://localhost:8081")
            //Métodos que a los que se da acceso
            ->header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE")
            //Headers de la petición
            ->header("Access-Control-Allow-Headers", "X-Requested-With, Content-Type, X-Token-Auth, Authorization");
//        if (isset($request->server()['HTTP_ORIGIN'])){
//            $origin = $request->server()['HTTP_ORIGIN'];
//            if (in_array($origin, $domains)){
//                header('Access-Control-Allow-Origin: '.$origin);
//                header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization');
//                header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
//            }
//        }
//        return $next($request);
    }
}
