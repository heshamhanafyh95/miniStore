<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\DeleteCategoryPostRequest;
use App\Http\Requests\category\StoreCategoryPostRequest;
use App\Http\Requests\category\UpdateCategoryPostRequest;
use App\Models\category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $categories = category::paginate($request->perPage, ['*'], 'categoryPage', $request->pageNumber);
        return response()->json($categories, 200);
    }

    public function store(StoreCategoryPostRequest $request)
    {
        try {
            $category = $this->categoryService->Create($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($category, 200);
    }

    public function update(UpdateCategoryPostRequest $request)
    {
        try {
            $category = $this->categoryService->Update($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($category, 200);
    }

    public function delete(DeleteCategoryPostRequest $request)
    {
        try {
            $category = $this->categoryService->Delete($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($category, 200);
    }
}
