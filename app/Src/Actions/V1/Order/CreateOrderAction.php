<?php

namespace App\Src\Actions\V1\Order;

use App\Src\Domain\Services\Order\CreateOrderService;
use App\Src\Responders\Order\CreateOrderResponder;
use Illuminate\Http\Request;

class CreateOrderAction
{
    protected $service;

    protected $responder;

    public function __construct(CreateOrderService $service, CreateOrderResponder $responder)
    {
        $this->service = $service;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $order = $this->service->handle($request);

        return $order;
        // $order = $this->service->handle($request);
    }
}
