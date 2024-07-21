<?php

namespace App\Repositories;

use App\Models\Medicine;

interface StatusMedicineRepositoryInterface
{
    public function store(Medicine $medicine, array $data);
}
