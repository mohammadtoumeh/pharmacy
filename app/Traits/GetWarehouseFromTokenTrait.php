<?php

namespace App\Traits;

trait GetWarehouseFromTokenTrait
{
    use ResponseTrait;


    /**
     * return warehouse from token
     *
     * */
    static function warehouse()
    {
        try {
            if(auth('api')->user()->user_type === 'warehouse')
                $warehouse = auth('api')->user()->warehouse;
            else
                $warehouse = auth('api')->user()->employee->warehouse;

            return $warehouse;
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

}
