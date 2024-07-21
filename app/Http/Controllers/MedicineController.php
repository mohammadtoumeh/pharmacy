<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicineUpdateRequest;
use App\Http\Requests\MedicineStoreRequest;
use App\Services\MedicineService;
use App\Traits\GetWarehouseFromTokenTrait;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    use GetWarehouseFromTokenTrait;

   protected MedicineService $medicineService;

    public function __construct(MedicineService $medicineService)
    {
       $this->medicineService = $medicineService;

        $this->middleware('OwnerOrWarehouseSupervisor')->only('store', 'update');
        $this->middleware('OwnerOrEmployee')->only('indexForWarehouse', 'showForWarehouse');
        $this->middleware('WarehouseOwner')->only('destroy');
        $this->middleware('Pharmacist')->only('addToFavorit', 'indexByFavorit');
    }

    public function index()
    {
        return $this->medicineService->index();
    }

    public function indexForWarehouse()
    {
        return $this->medicineService->indexForWarehouse();
    }

    public function indexByWarehouse(Request $request)
    {
        return $this->medicineService->indexByWarehouse($request->id);
    }

    public function indexByCategory(Request $request)
    {
        return $this->medicineService->indexByCategory($request->id);
    }

    public function indexByFavorit(Request $request)
    {
        return $this->medicineService->indexByFavorit();
    }

    public function store(MedicineStoreRequest $request)
    {
        return $this->medicineService->store($request->safe()->all());
    }

    public function show(Request $request)
    {
        return $this->medicineService->show($request->id);
    }

    public function showForWarehouse(Request $request)
    {
        return $this->medicineService->showForWarehouse($request->id);
    }

    public function update(MedicineUpdateRequest $request)
    {
        $data = $request->safe()->all();
        $data['medicine_id'] = $request->id;

        return $this->medicineService->update($data);
    }

    public function destroy(Request $request)
    {
        return $this->medicineService->destroy($request->id);
    }

    public function search(Request $request)
    {
        return $this->medicineService->search($request->search);
    }

    public function addToFavorit(Request $request)
    {
        return $this->medicineService->addToFavorit($request->id);
    }
}
