<?php

namespace App\Http\Middleware\MyMiddleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerOrOrdersSupervisor
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
            $userType = auth('api')->payload()->get('user_type');

            if($userType === 'warehouse')
                return $next($request);
            else if($userType === 'employee')
            {
                $roles = auth('api')->payload()->get('roles');

                if(in_array('orders_supervisor', $roles))
                    return $next($request);
                else
                    throw new \Exception('access only for orders_supervisor employee');
            }

            throw new \Exception('access only for owner or orders_supervisor employee');

        }catch (\Exception $e){
            return self::failed($e->getMessage(), 403);
        }
    }
}
