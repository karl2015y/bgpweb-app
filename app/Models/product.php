<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * 取得該商品的類別
     */
    public function Category()
    {
        return $this->belongsTo('App\Models\productCategory', 'category_id');
    }
    /**
     * 取得該商品下品項細節
     */
    public function Items()
    {
        return $this->hasMany('App\Models\productItem');
    }
    /**
     * 取得該商品下品項
     */
    public function Types()
    {
        return $this->hasMany('App\Models\productType');
    }
    /**
     * 取得該商品下圖片
     */
    public function Imgs()
    {
        return $this->hasMany('App\Models\productImg');
    }

}
