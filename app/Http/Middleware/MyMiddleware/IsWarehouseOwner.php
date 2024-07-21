<?php

namespace App\Http\Middleware\MyMiddleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsWarehouseOwner
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            //checking if user are warehouse owner
            if (auth('api')->payload()->get('user_type') === 'warehouse')
                return $next($request);
            else
                throw new \Exception('access only for warehouses owners');
        }catch (\Exception $e){
            return self::failed($e->getMessage(), 403);
        }
    }
}
