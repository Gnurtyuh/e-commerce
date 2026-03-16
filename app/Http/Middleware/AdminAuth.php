<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_token')) {
            return redirect()->route('admin.login');
        }

        $role = strtolower(session('admin_role', ''));
        if ($role !== 'admin' && $role !== 'role_admin') {
            abort(403, 'Unauthorized access - Admins only');
        }

        return $next($request);
    }
}
