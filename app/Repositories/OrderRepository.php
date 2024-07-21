<?php

namespace App\Repositories;

use App\Models\Medicine;
use App\Models\Order;
use App\Traits\GetPharmacistFromTokenTrait;
use App\Traits\GetWarehouseFromTokenTrait;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    use GetPharmacistFromTokenTrait, GetWarehouseFromTokenTrait;

    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function indexForPharmacist()
    {
        try {
            return self::pharmacist()->orders()->whereNotIn('status', ['refused', 'accepted'])->with('medicines')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexForWarehouse()
    {
        try {
            $orders = self::warehouse()->orders()->whereNotIn('status', ['refused', 'accepted'])->with('medicines.statusMedicine')->get();

            $orders->each(function ($order) {
                $order->medicines->each(function ($medicine) {
                    $medicine->makeVisible('quantity');
                });
            });

            return $orders;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexArchivedForPharmacist()
    {
        try {
            return self::pharmacist()->orders()->whereNot('status', 'sent')->with('medicines')->get();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function indexArchivedForWarehouse()
    {
        try {
            $orders = self::warehouse()->orders()->whereNot('status', 'sent')->with('medicines.statusMedicine')->get();

            $orders->each(function ($order) {
                $order->medicines->each(function ($medicine) {
                    $medicine->makeVisible('quantity');
                });
            });

            return $orders;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $this->order->warehouse_id = Medicine::find($data['medicine'][0])->warehouse->id;
            self::pharmacist()->orders()->save($this->order);

            foreach ($data['medicine'] as $id)
            $this->order->medicines()->attach([
                $id => ['quantity' => $data['quantity'][$id]]
            ]);

            DB::commit();
            return $this->order->fresh()->load('medicines');
        }catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function showForPharmacist(int $id)
    {
        try {
            return self::pharmacist()->orders()->with('medicines')->where('id', $id)->firstOrFail();
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function showForWarehouse(int $id)
    {
        try {
            $order = self::warehouse()->orders()->with('medicines.statusMedicine')->where('id', $id)->firstOrFail();

            $order->medicines->each(function ($medicine) {
                $medicine->makeVisible('quantity');
            });

            return $order;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function acceptOrder(int $id)
    {
        try {
            DB::beginTransaction();

            $order = self::warehouse()->orders()->where('id', $id)->firstOrFail();

            // Loop through each medicine in the order
            foreach ($order->medicines as $medicine)
            {
                // Check if the warehouse has enough stock
                if ($medicine->quantity < $medicine->pivot->quantity)
                    throw new \Exception('Not enough stock for: ' . $medicine->commercial_name);


                // Deduct the ordered quantity from the warehouse's stock
                $quantityToDeduct = $medicine->pivot->quantity;

                $statusMedicines = $medicine->statusMedicine()->orderBy('expiration_date', 'asc')->get();

                foreach ($statusMedicines as $statusMedicine)
                {
                    if ($statusMedicine->quantity <= $quantityToDeduct) {
                        $quantityToDeduct -= $statusMedicine->quantity;
                        $statusMedicine->quantity = 0; // make the statusMedicine 0 if all its quantity is used
                        $statusMedicine->save();
                    } else {
                        $statusMedicine->quantity -= $quantityToDeduct;
                        $statusMedicine->save();
                        break; // exit the loop if all the required quantity has been deducted
                    }
                }

                $medicine->quantity -= $medicine->pivot->quantity;
                $medicine->save();
            }

            // If all medicines are in stock, accept the order
            $order->status = 'accepted';
            $order->save();


            DB::commit();
            return $order->with('medicines.statusMedicine')->get();
        }catch (\Exception $e){
            DB::rollBack();
            if(str_contains($e->getMessage(), 'Not enough stock for: '))
            {
                $order->status = 'refused';
                $order->save();
                throw new \Exception($e->getMessage());
            }
        }
    }



}
