<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function PageComponent()
    {
        return $this->belongsTo('App\Models\PageComponent');
    }
    public function Blog()
    {
        return $this->belongsTo('App\Models\Blog');
    }
}
