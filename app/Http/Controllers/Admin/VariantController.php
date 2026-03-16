<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\VariantApiService;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    protected $variantApi;

    public function __construct(VariantApiService $variantApi)
    {
        $this->variantApi = $variantApi;
    }

    public function store(Request $request, $productId)
    {
        try {
            $this->variantApi->create($productId, $request->except('_token'));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->variantApi->update($id, $request->except('_token', '_method'));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->variantApi->delete($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
