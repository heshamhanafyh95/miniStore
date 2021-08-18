<?php

namespace App\Services\Category;

use App\Http\Requests\category\StoreCategoryPostRequest;
use App\Models\category;



class CategoryService
{
    public function Create(StoreCategoryPostRequest $request)
    {
        $data = $request->all();
        $data['image'] = $this->handleUploadImage($request);
        $category = Category::create($data);
        return $category;
    }

    public function handleUploadImage($data)
    {
        if ($data->hasFile('image')) {
            $imageName =  time() . '.' . $data->image->extension();
            $imagePath = $data->image->storeAs('images/categories', $imageName);
            return $imagePath;
        } else {
            return 'images/categories/notFound.png';
        }
    }
}
