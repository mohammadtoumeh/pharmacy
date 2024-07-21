<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddleware\OrderNotRefused;
use App\Http\Requests\OrderStoreRequest;
use App\Services\OrderService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ResponseTrait;

    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;

        $this->middleware('Pharmacist')->only('store', 'indexForPharmacist', 'showForPharmacist', 'indexArchivedForPharmacist');
        $this->middleware('OwnerOrOrdersSupervisor')->only('indexForWarehouse', 'showForWarehouse', 'indexArchivedForWarehouse');
        $this->middleware(['OwnerOrOrdersSupervisor', OrderNotRefused::class])->only('acceptOrder');
    }

    public function indexForPharmacist()
    {
        return $this->orderService->indexForPharmacist();
    }

    public function indexForWarehouse()
    {
        return $this->orderService->indexForWarehouse();
    }

    public function indexArchivedForPharmacist()
    {
        return $this->orderService->indexArchivedForPharmacist();
    }

    public function indexArchivedForWarehouse()
    {
        return $this->orderService->indexArchivedForWarehouse();
    }

    public function store(OrderStoreRequest $request)
    {
        return $this->orderService->store($request->safe()->all());
    }

    public function showForPharmacist(Request $request)
    {
        return $this->orderService->showForPharmacist($request->id);
    }

    public function showForWarehouse(Request $request)
    {
        return $this->orderService->showForWarehouse($request->id);
    }

    public function acceptOrder(Request $request)
    {
        return $this->orderService->acceptOrder($request->id);
    }
}
