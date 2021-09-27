<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Components extends Model
{
    use HasFactory;
    protected $guarded = [];

    // 元件的分類
    public function Classifications()
    {
        return $this->hasMany('App\Models\ComponentClassify');
    }
}
