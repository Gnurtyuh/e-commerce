<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CategoryApiService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryApi;

    public function __construct(CategoryApiService $categoryApi)
    {
        $this->categoryApi = $categoryApi;
    }

    public function index()
    {
        try {
            $categories = $this->categoryApi->getAll() ?? [];
        } catch (\Exception $e) {
            $categories = [];
            request()->session()->flash('error', 'Lỗi tải danh mục: ' . $e->getMessage());
        }
        
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $this->categoryApi->create($request->except(['_token', '_method']));
            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->categoryApi->update($id, $request->except(['_token', '_method']));
            return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryApi->delete($id);
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
