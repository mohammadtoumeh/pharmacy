<?php

namespace App\Http\Middleware\MyMiddleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsPharmacist
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
            if (auth('api')->payload()->get('user_type') === 'pharmacist')
                return $next($request);
            else
                throw new \Exception('access only for pharmacist');
        }catch (\Exception $e){
            return self::failed($e->getMessage(), 403);
        }
    }
}
