<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function HomePage(){
        // $data = [];
        // return view('home.index', $data);
        return redirect('/home');
    }
}
