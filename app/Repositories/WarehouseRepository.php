<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\State;
use App\Models\User;
use App\Models\Warehouse;
use App\Traits\GetWarehouseFromTokenTrait;
use App\Traits\ResponseTrait;
use App\Traits\StorePhotoTrait;
use Illuminate\Support\Facades\DB;

class WarehouseRepository implements WarehouseRepositoryInterface
{

    use ResponseTrait, StorePhotoTrait, GetWarehouseFromTokenTrait;

    protected Warehouse $warehouse;
    protected UserRepositoryInterface $userRepository;

    public function __construct(Warehouse $warehouse, UserRepositoryInterface $userRepository)
    {
        $this->warehouse = $warehouse;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            return $this->warehouse->with('user', 'states')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexByState(int $id)
    {
        try {
            return State::where('id', $id)->firstOrFail()->warehouses()->with('user', 'states')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }


    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->store($data);

            $this->warehouse->warehouse_name = $data['warehouse_name'];
            $this->warehouse->location = $data['location'] ?? null;
            $this->warehouse->description = $data['description'] ?? null;
            $this->warehouse->photo = isset($data['photo']) ? self::storePhoto($data['photo'], 'warehouses-photos') : null;

            $user->warehouse()->save($this->warehouse);

            $this->warehouse->states()->attach($data['states']);

            DB::commit();
            return $this->warehouse->load('user', 'states');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function show(int $id)
    {
        try {
            return $this->warehouse->where('id', $id)->firstOrFail()->load('user', 'states');
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();

            $this->warehouse = self::warehouse();

            $this->userRepository->update($this->warehouse->user, $data);

            $this->warehouse->update([
                'warehouse_name' => $data['warehouse_name'] ?? $this->warehouse->warehouse_name,
                'location' => $data['location'] ?? $this->warehouse->location,
                'description' => $data['description'] ?? $this->warehouse->description,
            ]);

            if(isset($data['states']))
                $this->warehouse->states()->sync($data['states']);
            else
                $this->warehouse->states()->detach();


            DB::commit();
            return $this->warehouse->load('user','states');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            DB::beginTransaction();

            $warehouse = self::warehouse();

            //delete "employees users" because each employee belongTo user
            $employeesUserId = $warehouse->employees()->pluck('user_id');
            User::whereIn('id', $employeesUserId)->delete();

            //warehouse is belongToUser
            $this->userRepository->destroy(auth('api')->user());
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
