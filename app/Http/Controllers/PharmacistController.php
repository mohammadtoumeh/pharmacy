<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacistStoreRequest;
use App\Http\Requests\PharmacistUpdateRequest;
use App\Services\PharmacistService;

class PharmacistController extends Controller
{

    protected PharmacistService $pharmacistService;

    public function __construct(PharmacistService $pharmacistService)
    {
        $this->pharmacistService = $pharmacistService;

        $this->middleware('Pharmacist')->only('update', 'destroy');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PharmacistStoreRequest $request)
    {
        return $this->pharmacistService->store($request->safe()->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PharmacistUpdateRequest $request)
    {
        return $this->pharmacistService->update($request->safe()->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        return $this->pharmacistService->destroy();
    }
}
