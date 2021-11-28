<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    public function index(Request $request)
    {
        $users = 'App\Models\User'::where('id','<>',null);
        $keyword = $request->input('keyword') ?? '';
        $users->where('name', 'like', '%' . $keyword . '%');
        $users->orWhere('email', 'like', '%' . $keyword . '%');
        $users = $users->paginate(10);
        $data = [
            'users' => $users,
            'keyword' => $keyword,
        ];
        // return $data;
        return view('admin.member.index', $data);
    }
}
