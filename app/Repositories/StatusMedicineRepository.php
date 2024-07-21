<?php

namespace App\Repositories;

use App\Models\Medicine;
use App\Models\StatusMedicine;
use App\Traits\GetWarehouseFromTokenTrait;

class StatusMedicineRepository implements StatusMedicineRepositoryInterface
{
    use GetWarehouseFromTokenTrait;

    protected StatusMedicine $statusMedicine;

    public function __construct(StatusMedicine $statusMedicine)
    {
        $this->statusMedicine = $statusMedicine;
    }



    public function store(Medicine $medicine, array $data)
    {
        try {
            $this->statusMedicine->quantity = $data['quantity'];
            $this->statusMedicine->expiration_date = $data['expiration_date'];

            $medicine->statusMedicine()->save($this->statusMedicine);

            $medicine->update([
                'quantity' => $medicine->statusMedicine()->sum('quantity')
            ]);

            return $medicine->load('statusMedicine');
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }
}
