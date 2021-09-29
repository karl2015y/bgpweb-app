<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Menu 管理 頁
    public function MenusPage(Request $request){
        return view('admin.menu.MenusPage');
    }
    // 新增 Menu 頁
    public function MenusAddPage(){
        return view('admin.menu.MenusAddPage');
    }
    // 新增 Menu
    public function MenusAdd(){
        return 'MenusAdd';
    }
    // 修改 Menu 頁
    public function MenusEditPage(){
        return view('admin.menu.MenusEditPage');
    }
    // 修改 Menu
    public function MenusEdit(){
        return 'MenusEdit';
    }
    // 刪除 Menu
    public function MenusDelete(){
        return 'MenusDelete';
    }
}
