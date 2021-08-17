<?php

namespace App\Http\Controllers;

use App\Http\Requests\item\StoreItemPostRequest;
use App\Models\Item;
use App\Services\item\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index(Request $request)
    {
        $items = Item::paginate($request->perPage,['*'],'itemPage',$request->pageNumber);
        return response()->json($items, 200);
    }

    public function store(StoreItemPostRequest $request)
    {
        try {
            $category=$this->itemService->Create($request);
        } catch (\Throwable $th) {
            return response()->json($th, 400);
        }

        return response()->json($category, 200);
    }
}