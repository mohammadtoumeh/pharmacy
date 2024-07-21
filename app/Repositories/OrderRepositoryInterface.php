<?php

namespace App\Repositories;

interface OrderRepositoryInterface
{
    public function indexForPharmacist();
    public function indexForWarehouse();
    public function indexArchivedForPharmacist();
    public function indexArchivedForWarehouse();
    public function store(array $data);
    public function showForPharmacist(int $id);
    public function showForWarehouse(int $id);
    public function acceptOrder(int $id);
}
