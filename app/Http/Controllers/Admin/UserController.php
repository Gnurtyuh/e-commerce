<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaginatesFromArray;
use App\Services\UserApiService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use PaginatesFromArray;

    protected $userApi;

    public function __construct(UserApiService $userApi)
    {
        $this->userApi = $userApi;
    }

    public function index(Request $request)
    {
        try {
            $allUsers = $this->userApi->getUsers() ?? [];
            $users = $this->paginateArray($allUsers, $request);
            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return view('admin.users.index', ['users' => []])->with('error', 'Lỗi tải danh sách người dùng: ' . $e->getMessage());
        }
    }
}
