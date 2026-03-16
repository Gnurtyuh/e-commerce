<?php
namespace App\Services;

class VariantApiService extends ApiService
{
    public function getVariants()
    {
        return $this->get("/variants");
    }

    public function getById($id)
    {
        return $this->get("/variants/{$id}");
    }

    public function getByProduct($productId)
    {
        return $this->get("/by-product/{$productId}");
    }

    public function create($productId, $data)
    {
        return $this->post("/products/{$productId}/variants", $data);
    }

    public function update($id, $data)
    {
        return $this->put("/variants/{$id}", $data);
    }

    public function delete($id)
    {
        return $this->deleteReq("/variants/{$id}");
    }
}

