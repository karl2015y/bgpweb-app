<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = [
        'start_at',
        'end_at',
    ];


    // 成交單
    public function Orders_Paid()
    {
        return $this->hasMany('App\Models\Order', 'coupon_code', 'code')->whereNotIn('status', ['preCreate', 'create', 'prePaid']);
    }

        // 搭配商品
        public function Need_Product()
        {
            return $this->hasOne('App\Models\product', 'id', 'product_id');
        }
    // 成交數量
    // public function Orders_Paid_Count()
    // {
    //     return $this->Orders_Paid()->count();
    // }
    // 成交金額
    // 總折扣金額
}
