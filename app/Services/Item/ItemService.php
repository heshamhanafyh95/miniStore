<?php

namespace App\Services\Item;

use App\Http\Requests\item\DeleteItemPostRequest;
use App\Http\Requests\item\StoreItemPostRequest;
use App\Http\Requests\item\UpdateItemPutRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class ItemService
{
    public function Create(StoreItemPostRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->handleUploadImage($request);
        $category = Item::create($data);
        return $category;
    }

    public function handleUploadImage($data, $item = null)
    {
        if ($data->hasFile('image')) {
            $imageName =  time() . '.' . $data->image->extension();
            $imagePath = 'storage/' . $data->image->storeAs('images/items', $imageName);
            $this->deleteOldPic($item->image);
            return $imagePath;
        } elseif ($item) {
            return $item->image;
        } else {
            return 'images/items/notFound.png';
        }
    }

    public function deleteOldPic($image)
    {
        $pic = explode("storage/", $image)[1];
        if (Storage::exists($pic)) {
            Storage::delete($pic);
        }
    }

    public function Update(UpdateItemPutRequest $request)
    {
        $data = $request->all();
        $item = Item::findOrFail($data['id']);
        $data['image'] = $this->handleUploadImage($request, $item);
        $item->update($data);
        return $item;
    }

    public function Delete(DeleteItemPostRequest $request)
    {
        $item = Item::findOrFail($request->id);
        if ($item->delete()) {
            return "The group deleted successfuly.";
        } else {
            return "The group deletion Failed.";
        }
    }
}
