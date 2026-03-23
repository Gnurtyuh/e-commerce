<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Http\Traits\PaginatesFromArray;

class PaymentController extends Controller
{
    use PaginatesFromArray;

    private $api = "http://localhost:8080/payments";

    public function index(Request $request)
    {
        $orderId = $request->get('order_id');
        $allPayments = [];

        if ($orderId) {

            // search theo order
            $response = Http::get($this->api . "/orders/" . $orderId);

        } else {

            // lấy toàn bộ payments
            $response = Http::get($this->api . "/all");

        }

        if ($response->successful()) {

            $data = $response->json();

            // nếu API trả object
            if (isset($data['paymentId'])) {
                $allPayments = [$data];
            } else {
                $allPayments = $data;
            }

        }

        $payments = $this->paginateArray($allPayments, $request);

        return view('admin.payments.index', [
            'payments' => $payments,
            'orderId' => $orderId
        ]);
    }


    public function create($orderId)
    {

        $response = Http::post($this->api . "/create/" . $orderId);

        if ($response->successful()) {

            $data = $response->json();

            if(isset($data['checkoutUrl'])){
                return redirect($data['checkoutUrl']);
            }

        }

        return redirect()->back()->with('error','Payment creation failed');
    }

}
