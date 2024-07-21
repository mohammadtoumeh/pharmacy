<?php

namespace App\Traits;

trait GetPharmacistFromTokenTrait
{
    use ResponseTrait;

    /**
     * return pharmacist from token
     *
     * */
    static function pharmacist()
    {
        try {
            return auth('api')->user()->pharmacist;
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }
}
