<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MyMiddleware\IsWarehouseOwner;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;

        $this->middleware(['auth:api', IsWarehouseOwner::class]);
    }


    public function index()
    {
        return $this->employeeService->index();
    }

    public function store(EmployeeStoreRequest $request)
    {
        return $this->employeeService->store($request->safe()->all());
    }

    public function show(Request $request)
    {
        return $this->employeeService->show($request->id);
    }

    public function update(EmployeeUpdateRequest $request)
    {
        $data = $request->safe()->all();
        $data['employee_id'] = $request->id;

        return $this->employeeService->update($data);
    }

    public function destroy(Request $request)
    {
        return $this->employeeService->destroy($request->id);
    }

}
