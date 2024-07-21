<?php

namespace App\Services;

use App\Repositories\OrderRepositoryInterface;
use App\Traits\ResponseTrait;

class OrderService
{
    use ResponseTrait;

    protected OrderRepositoryInterface $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function indexForPharmacist()
    {
        try {
            $orders = $this->orderRepository->indexForPharmacist();

            return self::successWithData($orders, 'your orders fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexForWarehouse()
    {
        try {
            $orders = $this->orderRepository->indexForWarehouse();

            return self::successWithData($orders, 'your orders fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexArchivedForPharmacist()
    {
        try {
            $orders = $this->orderRepository->indexArchivedForPharmacist();

            return self::successWithData($orders, 'your orders fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function indexArchivedForWarehouse()
    {
        try {
            $orders = $this->orderRepository->indexArchivedForWarehouse();

            return self::successWithData($orders, 'your orders fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function store(array $data)
    {
        try {
            $order = $this->orderRepository->store($data);

            return self::successWithData($order, 'new order created successfully', 201);
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function showForPharmacist(int $id)
    {
        try {
            $order = $this->orderRepository->showForPharmacist($id);

            return self::successWithData($order, 'your order fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function showForWarehouse(int $id)
    {
        try {
            $order = $this->orderRepository->showForWarehouse($id);

            return self::successWithData($order, 'your order fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

    public function acceptOrder(int $id)
    {
        try {
            $order = $this->orderRepository->acceptOrder($id);

            return self::successWithData($order, 'order accepted successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }
}
