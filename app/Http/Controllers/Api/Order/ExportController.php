<?php

namespace App\Http\Controllers\Api\Order;

use App\Exports\OrdersExport;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Log;

class ExportController extends ApiController
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            return (new OrdersExport())->download();
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        }
    }
}
