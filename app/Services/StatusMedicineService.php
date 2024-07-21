<?php

namespace App\Services;

use App\Repositories\StatusMedicineRepositoryInterface;
use App\Traits\GetWarehouseFromTokenTrait;
use App\Traits\ResponseTrait;

class StatusMedicineService
{
    use ResponseTrait, GetWarehouseFromTokenTrait;

    protected StatusMedicineRepositoryInterface $statusMedicineRepository;

    public function __construct(StatusMedicineRepositoryInterface $statusMedicineRepository)
    {
        $this->statusMedicineRepository = $statusMedicineRepository;
    }

    public function store(array $data)
    {
        try {
            $medicine = self::warehouse()->medicines()->where('id', $data['medicine_id'])->firstOrFail();

            $statusMedicine = $this->statusMedicineRepository->store($medicine, $data);

            return self::successWithData($statusMedicine, 'new quantity stored', 201);

        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

}
