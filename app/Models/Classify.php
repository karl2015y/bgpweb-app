<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Components()
    {
        return $this->hasMany('App\Models\ComponentClassify');
    }
}
