<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentClassify extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Classify()
    {
        return $this->belongsTo('App\Models\Classify');
    }
    public function Component()
    {
        return $this->belongsTo('App\Models\Components');
    }
}
