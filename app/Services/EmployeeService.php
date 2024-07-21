<?php

namespace App\Services;

use App\Repositories\EmployeeRepositoryInterface;
use App\Traits\ResponseTrait;

class EmployeeService
{
    use ResponseTrait;

    protected EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        try {
            $employees = $this->employeeRepository->index();

            return self::successWithData($employees, 'all employees in your warehouse');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            $data['user_type'] = 'employee';
            $employee = $this->employeeRepository->store($data);

            return self::successWithData($employee, 'new employee create successfully', 201);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $employee = $this->employeeRepository->show($id);

            return self::successWithData($employee, 'employee data');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            $employee = $this->employeeRepository->update($data);

            return self::successWithData($employee, 'employee updated');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->employeeRepository->destroy($id);

            return self::successWithMessage('employee destroyed');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }



}
