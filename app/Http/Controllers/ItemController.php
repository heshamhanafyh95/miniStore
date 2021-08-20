<?php

namespace App\Http\Controllers;

use App\Http\Requests\item\DeleteItemPostRequest;
use App\Http\Requests\item\StoreItemPostRequest;
use App\Http\Requests\item\UpdateItemPutRequest;
use App\Models\category;
use App\Models\Item;
use App\Services\Item\ItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // $items = Item::paginate($request->perPage, ['*'], 'itemPage', $request->pageNumber);
        try {
            $items = Item::with(['category'])->get();
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($items, 200);
    }
    public function show(Request $request)
    {
        try {
            $item = Item::with(['category'])->findOrFail($request->id);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
        return response()->json($item, 200);
    }

    public function store(StoreItemPostRequest $request)
    {
        try {
            $item = $this->itemService->Create($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($item, 200);
    }

    public function update(UpdateItemPutRequest $request)
    {
        try {
            $item = $this->itemService->Update($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($item, 200);
    }

    public function delete(DeleteItemPostRequest $request)
    {
        try {
            $item = $this->itemService->Delete($request);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }

        return response()->json($item, 200);
    }

    public function testItem(UpdateItemPutRequest $request)
    {
        $category = Item::findOrFail($request->id);
        // return response()->json(explode("storage/", $category->image)[1]);
        $pic = 'public' . parse_url($category->image)['path'];
        if (Storage::exists($pic)) {
            Storage::delete($pic);
        }
    }
}
