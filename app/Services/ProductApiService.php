<?php
namespace App\Services;

class ProductApiService extends ApiService
{
    public function getAll()
    {
        return $this->get("/products");
    }

    public function getById($id)
    {
        return $this->get("/products/{$id}");
    }

    public function create($data)
    {
        return $this->post("/products", $data);
    }

    public function update($id, $data)
    {
        return $this->put("/products/{$id}", $data);
    }

    public function delete($id)
    {
        return $this->deleteReq("/products/{$id}");
    }

    public function getByCategory($categoryId)
    {
        return $this->get("/products/by-category/{$categoryId}");
    }
}

