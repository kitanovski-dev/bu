<?php

namespace App\Src\Actions\V1\Order;

use App\Src\Responders\Order\CancelOrderResponder;
use App\Src\Domain\Services\Order\CancelOrderService;

class CancelOrderAction
{
    protected $service;

    protected $responder;

    public function __construct(CancelOrderService $service, CancelOrderResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $order = $this->service->handle($request);

        return $order;
    }
}
