<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 觸及資料庫
use App\Models\Menu;

class MenuController extends Controller
{
    // Menu 管理 頁
    public function MenusPage(){
        $menus =  Menu::orderBy('index')->get();
        $data = [
            'menus' => $menus
        ];
        // return $data;
        return view('admin.menu.MenusPage', $data);
    }
    // 新增 Menu 頁
    public function MenusAddPage(){
        return view('admin.menu.MenusAddPage');
    }
    // 新增 Menu
    public function MenusAdd(Request $request){
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'name' => 'required',
            'link' => 'required',
        ],[
            'name.required' => ':attribute為必填',
            'link.required' => ':attribute為必填',
        ],[
            'name'=>'選單名稱',
            'link'=>'選單連結',
        ]);
        $datas = [];
        $datas['name'] = $request->input('name');
        $datas['link'] = $request->input('link');
        $datas['show_phone'] = $request->input('phone')?TRUE:FALSE;
        $datas['show_pc'] = $request->input('desktop')?TRUE:FALSE;
        //確認資料庫有多少數據
        $datas['index'] = Menu::count()+1;
        //存入資料庫
        Menu::create($datas);
        $message_title = "新增成功";
        $message_type = "success";
        $message = "已把該連結存入選單，請調整「選單順序」來調整選單位置";
        return redirect()->route('MenusPage')
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
    // 修改 Menu 頁
    public function MenusEditPage($menus_id){
        $menu = Menu::where('id',$menus_id)->first();
        // return $menu;
        $data = [
            'menu' => $menu
        ];
        return view('admin.menu.MenusEditPage', $data);
    }
    // 修改 Menu
    public function MenusEdit(Request $request, $menus_id){
        $validatedData = $request->validate([
            'name' => 'required',
            'link' => 'required',
        ],[
            'name.required' => ':attribute為必填',
            'link.required' => ':attribute為必填',
        ],[
            'name'=>'選單名稱',
            'link'=>'選單連結',
        ]);
        $datas = [];
        $datas['name'] = $request->input('name');
        $datas['link'] = $request->input('link');
        $datas['show_phone'] = $request->input('phone')?TRUE:FALSE;
        $datas['show_pc'] = $request->input('desktop')?TRUE:FALSE;
        Menu::where('id',$menus_id)->first()->update($datas);
        $message_title = "更新成功";
        $message_type = "success";
        $message = "已更新選單資料";
        return redirect()->route('MenusPage')
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
    // 刪除 Menu
    public function MenusDelete($menus_id){
        // 刪除選單
        Menu::where('id',$menus_id)->delete();
        // 調整選單排序
        $menus =  Menu::orderBy('index')->get();
        foreach ($menus as $index => $item) {
            $item->update(['index'=>$index+1]);
        }
        $message_title = "刪除成功";
        $message_type = "success";
        $message = "已更新選單，請注意選單順序是否需要調整";
        return redirect()->route('MenusPage')
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
    // 調整 Menu Index
    public function MenusAdjustIndex(Request $request, $menus_id){
        $validatedData = $request->validate([
            'UpOrDown' => 'required',
        ],[
            'UpOrDown.required' => ':attribute為必填',
        ],[
            'UpOrDown'=>'上或下',
        ]);
        $UpOrDown = $request->input('UpOrDown');
        $current_menu = Menu::where('id',$menus_id)->first();
        $menus_len = Menu::count();
        // 確認是不是第一個
        if($UpOrDown=='Up' && $current_menu->index==1){
            $message_title = "調整失敗";
            $message_type = "error";
            $message = "此選單已是第一個，無法再往上了";
            return redirect()->route('MenusPage')
                                ->with('message_title', $message_title)
                                ->with('message_type', $message_type)
                                ->with('message', $message);
        }
        // 確認是不是最後一個
        if($UpOrDown=='Down' && $current_menu->index==$menus_len){
            $message_title = "調整失敗";
            $message_type = "error";
            $message = "此選單已是最後一個，無法再往下了";
            return redirect()->route('MenusPage')
                                ->with('message_title', $message_title)
                                ->with('message_type', $message_type)
                                ->with('message', $message);
        }

        if($UpOrDown=='Up'){
            $next_menu = Menu::where('index',$current_menu->index-1)->first();
            $next_menu->update(['index'=>$current_menu->index]);
            $current_menu->update(['index'=>$current_menu->index-1]);
        }else{
            $next_menu = Menu::where('index',$current_menu->index+1)->first();
            $next_menu->update(['index'=>$current_menu->index]);
            $current_menu->update(['index'=>$current_menu->index+1]);
        }
        return redirect()->route('MenusPage');
        
    }
}
