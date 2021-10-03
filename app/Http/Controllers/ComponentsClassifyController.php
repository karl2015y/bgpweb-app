<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 觸及資料庫
use App\Models\Classify;

class ComponentsClassifyController extends Controller
{
    // 新增元件類別頁 
    public function ComponentsClassifyAddPage(){
        return view('admin.component.ComponentsClassifyAddPage');
    }

    // 新增元件類別 
    public function ComponentsClassifyAdd(Request $request){
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'name' => 'required',
        ],[
            'name.required' => ':attribute為必填',
        ],[
            'name'=>'元件類別名稱',
        ]);
        $datas = [];
        $datas['name'] = $request->input('name');
        //存入資料庫
        Classify::create($datas);
        $message_title = "新增成功";
        $message_type = "success";
        $message = "已新增分類";
        return redirect()->route('ComponentsPage')
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }

    // 修改元件類別頁 
    public function ComponentsClassifyEditPage($class_id){
        $class_data = Classify::where('id', $class_id)->first();
        $data = [
            'class_data' => $class_data,
        ];
        return view('admin.component.ComponentsClassifyEditPage', $data);
    }

    // 修改元件類別 
    public function ComponentsClassifyEdit(Request $request, $class_id){
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'name' => 'required',
        ],[
            'name.required' => ':attribute為必填',
        ],[
            'name'=>'元件類別名稱',
        ]);
        $datas = [];
        $datas['name'] = $request->input('name');
        //存入資料庫
        Classify::where('id',$class_id)->first()->update($datas);
        $message_title = "更新成功";
        $message_type = "success";
        $message = "已更新元件類別";
        return redirect()->route('ComponentsPage', ['class_id'=>$class_id])
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
        return 'ComponentsClassifyEdit';
    }

    // 刪除元件類別 
    public function ComponentsClassifyDelete($class_id){
        $class_data = Classify::where('id',$class_id)->withCount('Components')->first();
        if($class_data->components_count==0){
            Classify::where('id',$class_id)->first()->delete();
            $message_title = "刪除成功";
            $message_type = "success";
            $message = "已刪除該元件類別 ";

        }else{
            $message_title = "刪除失敗";
            $message_type = "error";
            $message = "請先刪除該元件類別下的所有元件 ";
        }
        return redirect()->route('ComponentsPage',['class_id'=>$class_id])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
}
