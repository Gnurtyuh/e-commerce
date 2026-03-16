<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProductApiService;
use App\Services\CategoryApiService;
use App\Services\VariantApiService;
use App\Services\ImageApiService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productApi, $categoryApi, $variantApi, $imageApi;

    public function __construct(
        ProductApiService $productApi, 
        CategoryApiService $categoryApi,
        VariantApiService $variantApi,
        ImageApiService $imageApi
    ) {
        $this->productApi = $productApi;
        $this->categoryApi = $categoryApi;
        $this->variantApi = $variantApi;
        $this->imageApi = $imageApi;
    }

    public function index(Request $request)
    {
        try {
            $products = $this->productApi->getAll() ?? [];
            $categories = $this->categoryApi->getAll() ?? [];
        } catch (\Exception $e) {
            $products = [];
            $categories = [];
            request()->session()->flash('error', 'Lỗi tải dữ liệu: ' . $e->getMessage());
        }

        $categoryId = $request->category_id;
        $search = strtolower($request->search ?? '');

        if ($categoryId) {
            $products = array_filter($products, fn($p) => $p['categoryId'] == $categoryId);
        }
        if ($search) {
            $products = array_filter($products, fn($p) => str_contains(strtolower($p['name']), $search) || str_contains(strtolower($p['sku'] ?? ''), $search));
        }

        return view('admin.products.index', compact('products', 'categories', 'categoryId', 'search'));
    }

    public function create()
    {
        $categories = $this->categoryApi->getAll() ?? [];
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $res = $this->productApi->create($request->except('_token'));
            
            // redirect to edit to add variants & images
            $id = $res['productId'] ?? null;
            if ($id) {
                return redirect()->route('products.edit', $id)->with('success', 'Product created successfully. You can now add variants and images.');
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $product = $this->productApi->getById($id);
            $categories = $this->categoryApi->getAll() ?? [];
            return view('admin.products.edit', compact('product', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Product not found or API error.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->productApi->update($id, $request->except(['_token', '_method']));
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->productApi->delete($id);
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function variants($id)
    {
        $variants = $this->variantApi->getByProduct($id) ?? [];
        return view('admin.products.partials._variants', compact('variants', 'id'));
    }

    public function images($id)
    {
        $images = $this->imageApi->getByProduct($id) ?? [];
        return view('admin.products.partials._images', compact('images', 'id'));
    }
}
