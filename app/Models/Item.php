<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'tradePrice',
        'customerPrice',
        'minPrice',
        'quantity',
        'image',
        'discount',
        'status',
        'categoryId',
    ];

    public function order()
    {
        return $this->belongsToMany(Orders::class,'order_items','orderId','itemId')->withPivot('price','quantity');
    }
    
    public function category()
    {
        return $this->belongsTo(category::class);
    }
}
