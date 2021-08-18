<?php

namespace App\Http\Requests\item;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'tradePrice' => 'required',
            'customerPrice' => 'required',
            'minPrice' => 'required',
            'quantity' => 'required',
            'discount' => 'required',
            'status' => 'required',
        ];
    }
}
