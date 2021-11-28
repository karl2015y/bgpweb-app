<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 觸及資料庫
use App\Models\Classify;
use App\Models\Components;
use Illuminate\Validation\Rule;


class ComponentController extends Controller
{
    // 元件列表頁
    public function ComponentsPage(Request $request)
    {
        $isAllComponentsOrNot = $request->input('class_id') ? FALSE : TRUE;

        $classify = Classify::withCount('Components')->get();
        $data = [
            'is_all_components_or_not' => $isAllComponentsOrNot,
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
        // return $data;
        return view('admin.component.ComponentsPage', $data);
    }

    // 新增元件頁
    public function ComponentsAddPage()
    {
        $classify = Classify::with('Components')->get();
        $data = [
            'classify' => $classify
        ];
        return view('admin.component.ComponentsAddPage', $data);
    }

    // 新增元件
    public function ComponentsAdd(Request $request)
    {
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'name' => 'required|unique:components',
            'show_name' => 'required|unique:components',
            'component_classifies' => 'required',
        ], [
            'name.required' => ':attribute為必填',
            'name.unique' => ':attribute已存在，換一個試試看吧',
            'show_name.required' => ':attribute為必填',
            'show_name.unique' => ':attribute已存在，換一個試試看吧',
            'component_classifies.required' => ':attribute為必填',
        ], [
            'name' => '元件顯示名稱',
            'show_name' => '元件程式名稱',
            'component_classifies' => '元件類型',
        ]);
        // 新增元件
        $datas = [
            'name' => $request->input('name'),
            'show_name' => $request->input('show_name'),
        ];
        $component = Components::create($datas);
        // 新增元件的類型
        $class_ids = explode(",", $request->input('component_classifies'));
        foreach ($class_ids as $class_id) {
            $component->Classifications()->create([
                'classifies_id' => $class_id
            ]);
        }

        $message_title = "新增成功";
        $message_type = "success";
        $message = "已新增元件";
        return redirect()->route('ComponentsPage')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 修改元件頁
    public function ComponentsEditPage($components_id)
    {
        $classify =
            $data = [
                'component' => Components::where('id', $components_id)->with('Classifications')->first(),
                'components_count' => Components::count(),
                'classify' => Classify::withCount('Components')->get()
            ];
        // return $data;
        return view('admin.component.ComponentsEditPage', $data);
    }
    // 修改元件
    public function ComponentsEdit(Request $request, $components_id)
    {
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'name' => ['required',  Rule::unique('components')->ignore($components_id),],
            'show_name' => ['required',  Rule::unique('components')->ignore($components_id),],
            'component_classifies' => 'required',
        ], [
            'name.required' => ':attribute為必填',
            'name.unique' => ':attribute已存在，換一個試試看吧',
            'show_name.required' => ':attribute為必填',
            'show_name.unique' => ':attribute已存在，換一個試試看吧',
            'component_classifies.required' => ':attribute為必填',
        ], [
            'name' => '元件顯示名稱',
            'show_name' => '元件程式名稱',
            'component_classifies' => '元件類型',
        ]);
        // 新增元件
        $datas = [
            'name' => $request->input('name'),
            'show_name' => $request->input('show_name'),
        ];
        $component = Components::where('id', $components_id);
        $component->update($datas);
        $component = $component->first();
        // 新增元件的類型
        $component->Classifications()->delete();
        $class_ids = explode(",", $request->input('component_classifies'));
        foreach ($class_ids as $class_id) {
            $component->Classifications()->create([
                'classifies_id' => $class_id
            ]);
        }

        $message_title = "儲存成功";
        $message_type = "success";
        $message = "已新增元件";
        return redirect()->route('ComponentsPage')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 刪除元件
    public function ComponentsDelete($components_id)
    {
        $component = Components::where('id', $components_id)->first();
        $component->Classifications()->delete();
        $component->delete();
        $message_title = "刪除成功";
        $message_type = "success";
        $message = "已刪除該元件";
        return redirect()->route('ComponentsPage')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 預覽元件頁
    public function ComponentsPreviewPage($components_id)
    {
        $component = Components::where('id', $components_id)->first();
        $data=[
            'component' => $component
        ];
        return view('admin.component.ComponentsPreviewPage', $data);
    }
}
