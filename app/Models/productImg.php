<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productImg extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * 取得該圖片的商品
     */
    public function Product()
    {
        return $this->belongsTo('App\Models\product', 'product_id');
    }
}
