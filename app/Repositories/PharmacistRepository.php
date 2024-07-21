<?php

namespace App\Repositories;

use App\Models\Pharmacist;
use Illuminate\Support\Facades\DB;

class PharmacistRepository implements PharmacistRepositoryInterface
{
    protected Pharmacist $pharmacist;
    protected UserRepositoryInterface $userRepository;

    public function __construct(Pharmacist $pharmacist, UserRepositoryInterface $userRepository)
    {
        $this->pharmacist = $pharmacist;
        $this->userRepository = $userRepository;
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->store($data);

            $this->pharmacist->name = $data['name'];
            $this->pharmacist->location = $data['location'] ?? null;

            $user->pharmacist()->save($this->pharmacist);

            DB::commit();
            return $this->pharmacist->fresh()->load('user');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();

            $this->userRepository->update(auth('api')->user(), $data);

            $this->pharmacist = auth('api')->user()->pharmacist;

            $this->pharmacist->update([
                'name' => $data['name'] ?? $this->pharmacist->name,
                'location' => $data['location'] ?? $this->pharmacist->location
            ]);

            DB::commit();
            return $this->pharmacist->fresh()->fresh()->load('user');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->userRepository->destroy(auth('api')->user());
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}
