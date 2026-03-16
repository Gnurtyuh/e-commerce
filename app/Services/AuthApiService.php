<?php
namespace App\Services;

class AuthApiService extends ApiService
{
    public function getStatus($email)
    {
        return $this->get("/users/auth/status", ['email' => $email]);
    }
    
    public function changePassword($data)
    {
        return $this->post("/users/auth/change-password", $data);
    }
}

