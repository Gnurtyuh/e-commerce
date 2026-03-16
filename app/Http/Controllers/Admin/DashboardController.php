<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    private $api = "http://localhost:8080";

    public function index()
    {

        $orders = collect(Http::get($this->api."/orders")->json());

        $totalOrders = $orders->count();

        $totalRevenue = $orders
            ->where('status','PAID')
            ->sum('totalAmount');

        $recentOrders = $orders
            ->sortByDesc('createdAt')
            ->take(5);

        $revenueByMonth = $orders
            ->where('status','PAID')
            ->groupBy(fn($o)=>\Carbon\Carbon::parse($o['createdAt'])->format('Y-m'))
            ->map(fn($g)=>$g->sum('totalAmount'));

        $ordersByDay = $orders
            ->groupBy(fn($o)=>\Carbon\Carbon::parse($o['createdAt'])->format('Y-m-d'))
            ->map(fn($g)=>$g->count());

        $products = Http::get($this->api."/products")->json();
        $users = Http::get($this->api."/users/user/users")->json();

        $totalProducts = count($products ?? []);
        $totalUsers = count($users ?? []);

        /* inventory */

        $variants = collect(Http::get($this->api."/variants")->json());

        $lowStock = $variants
            ->where('stock','<',10)
            ->count();

        return view('admin.dashboard', [

            'totalOrders'=>$totalOrders,
            'totalRevenue'=>$totalRevenue,
            'totalProducts'=>$totalProducts,
            'totalUsers'=>$totalUsers,
            'recentOrders'=>$recentOrders,
            'revenueByMonth'=>$revenueByMonth,
            'ordersByDay'=>$ordersByDay,
            'lowStock'=>$lowStock

        ]);

    }

}
