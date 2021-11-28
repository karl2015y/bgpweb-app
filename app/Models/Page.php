<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function PageComponents()
    {
        return $this->hasMany('App\Models\PageComponent', 'pages_id')->orderBy('index');
    }
}
