<?php

namespace App\Services;

use App\Repositories\PharmacistRepositoryInterface;
use App\Traits\ResponseTrait;

class PharmacistService
{
    use ResponseTrait;

    protected PharmacistRepositoryInterface $pharmacistRepository;

    public function __construct(PharmacistRepositoryInterface $pharmacistRepository)
    {
        $this->pharmacistRepository = $pharmacistRepository;
    }

    public function store(array $data)
    {
        try {
            $data['user_type'] = 'pharmacist';
            $pharmacist = $this->pharmacistRepository->store($data);

            $token = auth('api')->login($pharmacist->user);
            $pharmacist = self::withToken($pharmacist, $token);

            return self::successWithData($pharmacist, 'pharmacist stored successfully',201);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            $pharmacist = $this->pharmacistRepository->update($data);

            return self::successWithData($pharmacist, 'account updated successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function destroy()
    {
        try {
            $this->pharmacistRepository->destroy();

            return self::successWithMessage('account deleted successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }
}
