<?php

namespace App\Repositories;

interface PharmacistRepositoryInterface
{
    public function store(array $data);
    public function update(array $data);
    public function destroy();

}
