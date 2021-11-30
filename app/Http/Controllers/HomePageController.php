<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function HomePage(Request $request){
        // $data = [];
        // return view('home.index', $data);
        $request->session()->reflash();
        return redirect('/home');
    }
}
