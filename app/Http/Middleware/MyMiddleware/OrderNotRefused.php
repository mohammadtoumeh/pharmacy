<?php

namespace App\Http\Middleware\MyMiddleware;

use App\Models\Order;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderNotRefused
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
            $order = Order::findOrFail($request->id);

            if ($order->status !== 'refused')
                return $next($request);
            else
                throw new \Exception('order already refused');

        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }
}
