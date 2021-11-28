<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function Product_Item()
    {
        return $this->belongsTo('App\Models\productItem', 'product_item_id');
    }
}
