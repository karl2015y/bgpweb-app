<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * 取得該品項細節的商品
     */
    public function Product()
    {
        return $this->belongsTo('App\Models\product', 'product_id');
    }
}
