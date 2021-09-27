<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageComponent extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Page()
    {
        return $this->belongsTo('App\Models\Page');
    }
    public function Component()
    {
        return $this->belongsTo('App\Models\Components');
    }
    public function Medias()
    {
        return $this->hasMany('App\Models\Media');
    }
}
