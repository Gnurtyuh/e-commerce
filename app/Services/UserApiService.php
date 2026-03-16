<?php
namespace App\Services;

class UserApiService extends ApiService
{
    public function getUsers()
    {
        return $this->get("/users/user/users");
    }
    
    public function getUserInfo()
    {
        return $this->get("/users/user/info");
    }

    public function createUser($data)
    {
        return $this->post("/users/user", $data);
    }
}

