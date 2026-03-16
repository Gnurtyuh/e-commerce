<?php
namespace App\Services;

class CategoryApiService extends ApiService
{
    public function getAll()
    {
        return $this->get("/categories");
    }

    public function getById($id)
    {
        return $this->get("/categories/{$id}");
    }

    public function create($data)
    {
        return $this->post("/categories", $data);
    }

    public function update($id, $data)
    {
        return $this->put("/categories/{$id}", $data);
    }

    public function delete($id)
    {
        return $this->deleteReq("/categories/{$id}");
    }
}

