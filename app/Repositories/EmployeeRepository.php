<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Traits\GetWarehouseFromTokenTrait;
use Illuminate\Support\Facades\DB;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    use GetWarehouseFromTokenTrait;

    protected UserRepositoryInterface $userRepository;
    protected Employee $employee;

    public function __construct(Employee $employee, UserRepositoryInterface $userRepository)
    {
        $this->employee = $employee;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            return self::warehouse()->employees()->with('user.roles')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->store($data);

            $this->employee->warehouse_id = self::warehouse()->id;
            $this->employee->employee_name = $data['employee_name'];
            $this->employee->salary = $data['salary'];

            $user->employee()->save($this->employee);

            DB::commit();
            return $this->employee->load('user.roles');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $this->employee = self::warehouse()->employees()->where('id', $id)->firstOrFail()->load('user.roles');

            return $this->employee;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();

            $this->employee = self::warehouse()->employees()->where('id', $data['employee_id'])->firstOrFail();

            $this->userRepository->update($this->employee->user, $data);

            $this->employee->update([
                'employee_name' => $data['employee_name'] ?? $this->employee->employee_name,
                'salary' => $data['salary'] ?? $this->employee->salary,
            ]);

            DB::commit();
            return $this->employee->load('user.roles');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->employee = self::warehouse()->employees()->where('id', $id)->firstOrFail();

            $this->userRepository->destroy($this->employee->user); //employee is belongTo user
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
