<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaginatesFromArray;
use App\Services\ProductApiService;
use App\Services\CategoryApiService;
use App\Services\VariantApiService;
use App\Services\ImageApiService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use PaginatesFromArray;

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
            $allProducts = $this->productApi->getAll() ?? [];
            $categories = $this->categoryApi->getAll() ?? [];
        } catch (\Exception $e) {
            $allProducts = [];
            $categories = [];
            request()->session()->flash('error', 'Lỗi tải dữ liệu: ' . $e->getMessage());
        }

        // FIX: đồng bộ tên field
        $categoryId = $request->input('categoryId');
        $search = strtolower($request->input('search', ''));

        // Filter theo category
        if ($categoryId) {
            $allProducts = array_filter($allProducts, function ($p) use ($categoryId) {
                return $p['categoryId'] == $categoryId;
            });
        }

        // Filter theo search
        if ($search) {
            $allProducts = array_filter($allProducts, function ($p) use ($search) {
                return str_contains(strtolower($p['name']), $search) ||
                       str_contains(strtolower($p['sku'] ?? ''), $search);
            });
        }

        // reset index cho đẹp (optional nhưng nên có)
        $allProducts = array_values($allProducts);

        $products = $this->paginateArray($allProducts, $request);

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
