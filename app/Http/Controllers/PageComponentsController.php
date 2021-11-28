<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 觸及資料庫
use App\Models\Page;
use App\Models\Classify;
use App\Models\Components;
use App\Models\PageComponent;

class PageComponentsController extends Controller
{
    // 頁面元件列表頁
    public function PageComponentsPage($pages_id)
    {
        $page = Page::where('id', $pages_id)->first();
        $data = [
            'page' => $page,
            'components' => $page->PageComponents()->with('Component')->orderBy('index')->get()
        ];
        // return $data;
        return view('admin.page.PageComponents.PageComponentsPage', $data);
    }
    // 新增頁面元件頁
    public function PageComponentsAddPage(Request $request, $pages_id)
    {
        $page = Page::where('id', $pages_id)->first();

        $isAllComponentsOrNot = $request->input('class_id') ? FALSE : TRUE;
        $classify = Classify::withCount('Components')->get();
        $data = [
            'page' => $page,
            'components_count' => Components::count(),
            'classify' => $classify
        ];

        // 如果是要全部的元件
        if ($isAllComponentsOrNot) {
            $data['components'] = Components::latest();
        } else {
            // 篩選元件
            $class_id = $request->input('class_id');
            $data['class_data'] = Classify::where('id', $class_id)->first();
            if (!$data['class_data']) {
                return redirect()->route('ComponentsPage');
            }

            $cc_id_list = array();
            foreach ($data['class_data']->Components as $component) {
                array_push($cc_id_list, $component->components_id);
            }
            $data['components'] = Components::latest()->whereIn('id', $cc_id_list);
        }
        $data['components'] = $data['components']->with('Classifications.Classify')->paginate(10);
        if ($request->input('class_id')) {
            $data['components']->appends(['class_id' => $class_id]);
        }
        return view('admin.page.PageComponents.PageComponentsAddPage', $data);
    }
    // 新增頁面元件
    public function PageComponentsAdd(Request $request, $pages_id)
    {
        $validatedData = $request->validate([
            'components_id' => 'required',
        ],[
            'components_id.required' => ':attribute為必填',
        ],[
            'name'=>'元素id',
        ]);
        $PageComponents = Page::where('id', $pages_id)->first()->PageComponents();
        $datas = [
            'index' => $PageComponents->count()+1,
            'components_id' => $request->input('components_id'),
            'name' => Components::where('id', $request->input('components_id'))->first()->name."_".rand(),
            'data'=>'{}'
        ];
        $PageComponents->create( $datas );
        $message_title = "新增成功";
        $message_type = "success";
        $message = "已將元件添加到該頁";
        return redirect()->back()
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }

    // 修改頁面元件index
    public function PageComponentsAdjustIndex(Request $request, $pages_id, $page_components_id){
        $validatedData = $request->validate([
            'UpOrDown' => 'required',
        ],[
            'UpOrDown.required' => ':attribute為必填',
        ],[
            'UpOrDown'=>'上或下',
        ]);
        $UpOrDown = $request->input('UpOrDown');
        $page_components = PageComponent::where('pages_id', $pages_id)->get();
        $current_pc =  $page_components->where('id',$page_components_id)->first();
        $pcs_len = $page_components->count();
        // 確認是不是第一個
        if($UpOrDown=='Up' && $current_pc->index==1){
            $message_title = "調整失敗";
            $message_type = "error";
            $message = "此元件已是第一個，無法再往上了";
            return redirect()->back()
                                ->with('message_title', $message_title)
                                ->with('message_type', $message_type)
                                ->with('message', $message);
        }
        // 確認是不是最後一個
        if($UpOrDown=='Down' && $current_pc->index==$pcs_len){
            $message_title = "調整失敗";
            $message_type = "error";
            $message = "此選單已是最後一個，無法再往下了";
            return redirect()->back()
                                ->with('message_title', $message_title)
                                ->with('message_type', $message_type)
                                ->with('message', $message);
        }

        if($UpOrDown=='Up'){
            $next_pc = $page_components->where('index',$current_pc->index-1)->first();
            $next_pc->update(['index'=>$current_pc->index]);
            $current_pc->update(['index'=>$current_pc->index-1]);
        }else{
            $next_pc = $page_components->where('index',$current_pc->index+1)->first();
            $next_pc->update(['index'=>$current_pc->index]);
            $current_pc->update(['index'=>$current_pc->index+1]);
        }
        return redirect()->back();
    }

    // 修改頁面元件頁
    public function PageComponentsEditPage($pages_id, $page_components_id)
    {
        $pc = PageComponent::where('id', $page_components_id)->with('Component')->first();
        $data = [
            'pc' => $pc
        ];
        // return $data;
        return view('admin.page.PageComponents.PageComponentsEditPage', $data);
    }
    // 修改頁面元件
    public function PageComponentsEdit(Request $request, $pages_id, $page_components_id)
    {
        $validatedData = $request->validate([
            'data' => 'required',
        ],[
            'data.required' => ':attribute為必填',
        ],[
            'data'=>'數據',
        ]);
        $data = $request->input('data');
        PageComponent::where('id',$page_components_id)->update(['data'=>$data]);
        $message_title = "更新成功";
        $message_type = "success";
        $message = "已更新元件資料";
        return redirect()->back()
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
    // 刪除頁面元件
    public function PageComponentsDelete($pages_id, $page_components_id)
    {
        $pcs = PageComponent::where('pages_id', $pages_id);
        // 刪除選單
        $pcs->where('id',$page_components_id)->delete();
        $pcs = PageComponent::where('pages_id', $pages_id);
        // 調整選單排序
        $pc =  $pcs->orderBy('index')->get();
        foreach ($pc as $index => $item) {
            $item->update(['index'=>$index+1]);
        }
        $message_title = "刪除成功";
        $message_type = "success";
        $message = "已更新元件清單，請注意順序是否需要調整";
        return redirect()->back()
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
}
