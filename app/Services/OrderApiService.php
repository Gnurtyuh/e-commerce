<?php
namespace App\Services;

class OrderApiService extends ApiService
{
    public function getAll()
    {
        return $this->get("/orders");
    }

    public function getById($id)
    {
        return $this->get("/orders/{$id}");
    }

    public function getItems($orderId)
    {
        return $this->get("/orders/{$orderId}/items");
    }

    public function create($data)
    {
        return $this->post("/orders", $data);
    }
}

