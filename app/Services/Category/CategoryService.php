<?php

namespace App\Services\Category;

use App\Http\Requests\category\DeleteCategoryPostRequest;
use App\Http\Requests\category\StoreCategoryPostRequest;
use App\Http\Requests\category\UpdateCategoryPostRequest;
use App\Models\category;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function Create(StoreCategoryPostRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->handleUploadImage($request);
        $category = Category::create($data);
        return $category;
    }

    public function handleUploadImage($data, $category = null)
    {
        if ($data->hasFile('image')) {
            $imageName =  time() . '.' . $data->image->extension();
            $imagePath = 'storage/' . $data->image->storeAs('images/categories', $imageName);
            if ($category) {
                $this->deleteOldPic($category->image);
            }
            return $imagePath;
        } elseif ($category) {
            return $category->image;
        } else {
            return 'images/categories/notFound.png';
        }
    }

    public function deleteOldPic($image)
    {
        $pic = explode("storage/", $image)[1];
        if (Storage::exists($pic)) {
            Storage::delete($pic);
        }
    }

    public function Update(UpdateCategoryPostRequest $request)
    {
        $data = $request->all();
        $item = category::findOrFail($data['id']);
        $data['image'] = $this->handleUploadImage($request, $item);
        $item->update($data);
        return $item;
    }

    public function Delete(DeleteCategoryPostRequest $request)
    {
        $item = category::findOrFail($request->id);
        if ($item->delete()) {
            return "The group deleted successfuly.";
        } else {
            return "The group deletion Failed.";
        }
    }
}
