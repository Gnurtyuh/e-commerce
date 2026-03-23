<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaginatesFromArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventoryController extends Controller
{
    use PaginatesFromArray;

    private $api = "http://localhost:8080";

    public function index(Request $request)
    {

        $allVariants = Http::get($this->api."/variants")->json();

        if(!$allVariants){
            $allVariants = [];
        }

        $variants = $this->paginateArray($allVariants, $request);

        return view('admin.inventory.index',[
            'variants'=>$variants
        ]);

    }

}
