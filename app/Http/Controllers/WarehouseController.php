<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddleware\IsWarehouseOwner;
use App\Http\Requests\WarehouseStoreRequest;
use App\Http\Requests\WarehouseUpdateRequest;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    protected WarehouseService $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;

        $this->middleware(['auth:api', IsWarehouseOwner::class])->only(['update', 'destroy']);
    }

    public function index()
    {
        return $this->warehouseService->index();
    }

    public function indexByState(Request $request)
    {
        return $this->warehouseService->indexByState($request->id);
    }

    public function store(WarehouseStoreRequest $request)
    {
        return $this->warehouseService->store($request->safe()->all());
    }

    public function show(Request $request)
    {
        return $this->warehouseService->show($request->id);
    }

    public function update(WarehouseUpdateRequest $request)
    {
        return $this->warehouseService->update($request->safe()->all());
    }

    public function destroy()
    {
        return $this->warehouseService->destroy();
    }






}
