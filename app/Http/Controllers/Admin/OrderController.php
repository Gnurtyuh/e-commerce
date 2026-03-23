<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaginatesFromArray;
use App\Services\OrderApiService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use PaginatesFromArray;

    protected $orderApi;

    public function __construct(OrderApiService $orderApi)
    {
        $this->orderApi = $orderApi;
    }

    public function index(Request $request)
    {
        try {

            $allOrders = $this->orderApi->getAll();

            if(!$allOrders){
                $allOrders = [];
            }

            $orders = $this->paginateArray($allOrders, $request);

            return view('admin.orders.index', compact('orders'));

        } catch (\Exception $e) {

            return view('admin.orders.index', [
                'orders' => []
            ])->with('error','Lỗi tải danh sách đơn hàng: '.$e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $order = $this->orderApi->getById($id);

            if(!$order){
                $order = [];
            }

            $items = $this->orderApi->getItems($id);

            if(!$items){
                $items = [];
            }

            return view('admin.orders.show', [
                'order'=>$order,
                'items'=>$items
            ]);

        } catch (\Exception $e) {

            return redirect()
                ->route('orders.index')
                ->with('error','Không tìm thấy đơn hàng hoặc lỗi API: '.$e->getMessage());

        }
    }
}
