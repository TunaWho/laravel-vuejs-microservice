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

    /**
     * Statistics Orders.
     *
     * @return Order
     */
    public function orderStatistics()
    {
        return Order::query()
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw(
                "DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date
                , sum(order_items.quantity * order_items.price) as sum"
            )
            ->groupBy('date');
    }
}
