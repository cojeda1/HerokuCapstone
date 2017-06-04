<?php
namespace App\Http\Middleware;
use Closure;
class Cors {
    public function handle($request, Closure $next)
    {
      if($request->isMethod("OPTIONS")) {
              // The client-side application can set only headers allowed in Access-Control-Allow-Headers
              return response('')
              ->header('Access-Control-Allow-Origin', '*')
              ->header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Bearer, OPTIONS, Authorization")
              ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

      }
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header("Access-Control-Allow-Headers", "Cache-Control, Pragma, Origin, Authorization, Content-Type, X-Requested-With")
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
