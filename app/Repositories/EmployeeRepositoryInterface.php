<?php

namespace App\Repositories;

interface EmployeeRepositoryInterface
{
    public function index();
    public function store(array $data);
    public function show(int $id);
    public function update(array $data);
    public function destroy(int $id);
}
