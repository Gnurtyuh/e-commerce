<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserApiService;

class UserController extends Controller
{
    protected $userApi;

    public function __construct(UserApiService $userApi)
    {
        $this->userApi = $userApi;
    }

    public function index()
    {
        try {
            $users = $this->userApi->getUsers() ?? [];
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin.users.index', ['users' => []])->with('error', 'Lỗi tải danh sách người dùng: ' . $e->getMessage());
        }
    }
}
