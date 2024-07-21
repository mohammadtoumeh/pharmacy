<?php

namespace App\Repositories;

use App\Models\Medicine;

interface MedicineRepositoryInterface
{
    public function index();
    public function indexForWarehouse();
    public function indexByCategory(int $id);
    public function indexByWarehouse(int $id);
    public function indexByFavorit();
    public function store(array $data);
    public function show(int $id);
    public function showForWarehouse(int $id);
    public function update(Medicine $medicine, array $data);
    public function destroy(Medicine $medicine);
    public function search(string $search);

    public function addToFavorit(int $id);
}
