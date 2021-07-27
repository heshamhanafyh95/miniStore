<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'type',
        'status',
        'discount',
        'userId',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class,'order_items','orderId','itemId')->withPivot('price','quantity');
    }
}
