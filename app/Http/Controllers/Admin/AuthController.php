<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $apiUrl = config('services.api.base_url') . '/users/auth/login';

        try {
            $response = Http::post($apiUrl, [
                'email'    => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                $role = isset($data['role']) ? strtolower($data['role']) : '';
                if ($role !== 'admin' && $role !== 'role_admin') {
                    \Illuminate\Support\Facades\Log::warning('Login failed: Invalid role', ['email' => $request->email, 'role' => $data['role'] ?? 'null']);
                    return back()->withErrors(['email' => 'Bạn không có quyền truy cập admin. (Role: ' . ($data['role'] ?? 'none') . ')']);
                }

                session([
                    'admin_token' => $data['token'] ?? '',
                    'admin_name'  => $data['fullName'] ?? $data['name'] ?? 'Admin',
                    'admin_role'  => $data['role'] ?? '',
                ]);

                \Illuminate\Support\Facades\Log::info('Admin login successful', ['email' => $request->email]);
                return redirect()->route('admin.dashboard');
            }

            \Illuminate\Support\Facades\Log::warning('Login failed: Invalid credentials', ['email' => $request->email, 'status' => $response->status()]);
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Login HTTP Error: ' . $e->getMessage(), ['email' => $request->email]);
            return back()->withErrors(['email' => 'Không thể kết nối đến API Server.']);
        }
    }

    public function logout()
    {
        session()->forget(['admin_token', 'admin_name', 'admin_role']);
        return redirect()->route('admin.login');
    }
}
