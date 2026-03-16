<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageApiService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageApi;

    public function __construct(ImageApiService $imageApi)
    {
        $this->imageApi = $imageApi;
    }

    public function store(Request $request, $productId)
    {
        try {
            if ($request->hasFile('file')) {
                $isMain = filter_var($request->is_main, FILTER_VALIDATE_BOOLEAN);
                $sortOrder = intval($request->sort_order ?? 0);
                
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('images/products'), $filename);
                $imagePath = 'images/products/' . $filename;
                
                $this->imageApi->upload($productId, $imagePath, $isMain, $sortOrder);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function setMain($id)
    {
        try {
            $this->imageApi->setMain($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->imageApi->deleteImage($id);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
