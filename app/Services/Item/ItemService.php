<?php

namespace App\Services\Item;

use App\Http\Requests\item\StoreItemPostRequest;
use App\Models\Item;


class ItemService
{
    public function Create(StoreItemPostRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->handleUploadImage($request);
        $category = Item::create($data);
        return $category;
    }

    public function handleUploadImage($data)
    {
        if ($data->hasFile('image')) {
            $imageName =  time() . '.' . $data->image->extension();
            $imagePath = $data->image->storeAs('images/items', $imageName);
            return $imagePath;
        } else {
            return 'images/items/notFound.png';
        }
    }
}
