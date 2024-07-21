<?php

namespace App\Http\Controllers;


use App\Http\Requests\StatusMedicineStoreRequest;
use App\Services\StatusMedicineService;

class StatusMedicineController extends Controller
{
    protected StatusMedicineService $statusMedicineService;

    public function __construct(StatusMedicineService $statusMedicineService)
    {
        $this->statusMedicineService = $statusMedicineService;

        $this->middleware('OwnerOrWarehouseSupervisor')->only('store');
    }

    public function store(StatusMedicineStoreRequest $request)
    {
        return $this->statusMedicineService->store($request->safe()->all());
    }


}
