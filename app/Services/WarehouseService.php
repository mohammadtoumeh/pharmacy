<?php

namespace App\Services;

use App\Repositories\WarehouseRepositoryInterface;
use App\Traits\ResponseTrait;

class WarehouseService
{

    use ResponseTrait;

    protected WarehouseRepositoryInterface $warehouseRepository;

    public function __construct(WarehouseRepositoryInterface $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function index()
    {
        try {
            $warehouses = $this->warehouseRepository->index();

            return self::successWithData($warehouses, 'warehouses fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexByState(int $id)
    {
        try {
            $warehouses = $this->warehouseRepository->indexByState($id);

            return self::successWithData($warehouses, 'warehouses fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            $data['user_type'] = 'warehouse';

            $warehouse = $this->warehouseRepository->store($data);

            $token = auth('api')->login($warehouse->user);

            $warehouse = self::withToken($warehouse, $token); //for attaching token in response

            return self::successWithData($warehouse, 'new warehouse created successfully', 201);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $warehouse = $this->warehouseRepository->show($id);

            return self::successWithData($warehouse, 'warehouse fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            $warehouse = $this->warehouseRepository->update($data);

            return self::successWithData($warehouse, 'warehouse updated successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->warehouseRepository->destroy();

            return self::successWithMessage('warehouse deleted successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

}
