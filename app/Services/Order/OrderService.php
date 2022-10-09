<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Services\AbstractBaseService;

class OrderService extends AbstractBaseService
{
    /**
     * Return the latest orders.
     *
     * @return Order
     */
    public function orders()
    {
        return Order::query()->latest();
    }

    /**
     * Get a order by its ID.
     *
     * @param int $id The id of the order you want to get.
     *
     * @return Order
     */
    public function getOrderById($id)
    {
        return Order::query()
            ->whereId($id)
            ->firstOrFail();
    }
}
