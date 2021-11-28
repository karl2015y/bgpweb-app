<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * 取得該分類下的商品
     */
    public function products()
    {
        return $this->hasMany('App\Models\product','category_id');
    }
}
