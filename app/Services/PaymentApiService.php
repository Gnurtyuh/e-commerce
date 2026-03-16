<?php
namespace App\Services;

class PaymentApiService extends ApiService
{
    public function create($data)
    {
        return $this->post("/payments", $data);
    }

    public function getByOrder($orderId)
    {
        return $this->get("/payments/orders/{$orderId}");
    }
}

