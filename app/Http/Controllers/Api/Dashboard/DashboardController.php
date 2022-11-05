<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Dashboard\ChartResource;
use App\Services\Order\OrderService;
use Illuminate\Database\QueryException;

class DashboardController extends ApiController
{
    /**
     * A constructor for services is used in this controller.
     *
     * @param OrderService $orderService Instance class.
     */
    public function __construct(protected OrderService $orderService)
    {
        parent::__construct();
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->authorizeViewFor('orders');

        try {
            $orders = $this->orderService
                ->orderStatistics()
                ->get();
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return ChartResource::collection($orders);
    }
}
