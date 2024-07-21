<?php

namespace App\Services;

use App\Repositories\MedicineRepositoryInterface;
use App\Traits\GetWarehouseFromTokenTrait;
use App\Traits\ResponseTrait;

class MedicineService
{
    use ResponseTrait, GetWarehouseFromTokenTrait;

    protected MedicineRepositoryInterface $medicineRepository;

    public function __construct(MedicineRepositoryInterface $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    public function index()
    {
        try {
            $medicines = $this->medicineRepository->index();

            return self::successWithData($medicines, 'all medicine fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexForWarehouse()
    {
        try {
            $medicines = $this->medicineRepository->indexForWarehouse();

            return self::successWithData($medicines, 'all medicine in your warehouse fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexByWarehouse(int $id)
    {
        try {
            $medicines = $this->medicineRepository->indexByWarehouse($id);

            return self::successWithData($medicines, 'all medicines belongTo Warehouse');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexByCategory(int $id)
    {
        try {
            $medicines = $this->medicineRepository->indexBycategory($id);

            return self::successWithData($medicines, 'all medicines belongTo Category');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexByFavorit()
    {
        try {
            $medicines = $this->medicineRepository->indexByFavorit();

            return self::successWithData($medicines, 'medicines in your favorit');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }



    public function store(array $data)
    {
        try {
            $medicine = $this->medicineRepository->store($data);

            return self::successWithData($medicine, 'new medicine created successfully', 201);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }


    public function show(int $id)
    {
        try {
            $medicine = $this->medicineRepository->show($id);

            return self::successWithData($medicine, 'medicine fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function showForWarehouse(int $id)
    {
        try {
            $medicine = $this->medicineRepository->showForWarehouse($id);

            return self::successWithData($medicine, 'medicine fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }


    public function update(array $data)
    {
        try {
            $medicine = self::warehouse()->medicines()->where('id', $data['medicine_id'])->firstOrFail();

            $medicine = $this->medicineRepository->update($medicine, $data);

            return self::successWithData($medicine, 'medicine update successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $medicine = self::warehouse()->medicines()->where('id', $id)->firstOrFail();

            $this->medicineRepository->destroy($medicine);

            return self::successWithMessage('medicine deleted successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }

    }

    public function search(string $search)
    {
        try {
            $medicines = $this->medicineRepository->search($search);

            return self::successWithData($medicines, 'search results');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function addToFavorit(int $id)
    {
        try {
            $message = $this->medicineRepository->addToFavorit($id);

            return self::successWithMessage($message);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }



}
