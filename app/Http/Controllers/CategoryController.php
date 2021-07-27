<?php

namespace App\Http\Controllers;

use App\Http\Requests\category\StoreCategoryPostRequest;
use App\Models\category;
use App\Services\category\CategoryService;
use Illuminate\Http\Request;

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
        $categories = category::paginate($request->perPage,['*'],'categoryPage',$request->pageNumber);
        return response()->json($categories, 200);
    }

    public function store(StoreCategoryPostRequest $request)
    {
        try {
            $category=$this->categoryService->Create($request);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json($category, 200);
    }
}
