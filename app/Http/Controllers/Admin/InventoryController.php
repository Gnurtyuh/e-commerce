<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class InventoryController extends Controller
{

    private $api = "http://localhost:8080";

    public function index()
    {

        $variants = Http::get($this->api."/variants")->json();

        if(!$variants){
            $variants = [];
        }

        return view('admin.inventory.index',[
            'variants'=>$variants
        ]);

    }

}
