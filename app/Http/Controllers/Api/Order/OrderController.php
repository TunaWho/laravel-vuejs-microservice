<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;

class OrderController extends ApiController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orders = $this->orderService
                ->orders()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return OrderResource::collection($orders);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $orderId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        try {
            $order = $this->orderService->getOrderById($orderId);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new OrderResource($order);
    }
}
