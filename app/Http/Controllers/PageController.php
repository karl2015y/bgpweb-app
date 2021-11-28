<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 觸及資料庫
use App\Models\Page;

use Illuminate\Validation\Rule;


class PageController extends Controller
{
    // 頁面列表頁
    public function PagesPage()
    {
        $pages = Page::paginate(10);
        $data = [
            'pages' => $pages
        ];
        return view('admin.page.PagesPage', $data);
    }
    // 新增頁面頁
    public function PagesAddPage()
    {
        return view('admin.page.PagesAddPage');
    }
    // 新增頁面
    public function PagesAdd(Request $request)
    {
        // 驗證傳入的數據
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|unique:pages',
        ], [
            'title.required' => ':attribute為必填',
            'description.required' => ':attribute為必填',
            'url.required' => ':attribute為必填',
            'url.unique' => ':attribute已存在，換一個試試看吧',
        ], [
            'title' => '頁面標題',
            'description' => '頁面簡介',
            'url' => '自定義連結',
        ]);
        $datas = [];
        $datas['title'] = $request->input('title');
        $datas['description'] = $request->input('description');
        $datas['url'] = $request->input('url');
        //存入資料庫
        Page::create($datas);
        $message_title = "新增成功";
        $message_type = "success";
        $message = "已新增頁面，趕快前往元件管理新增元件吧";
        return redirect()->route('PagesPage')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
    // 修改頁面頁
    public function PagesEditPage($pages_id)
    {
        $page = Page::where('id', $pages_id)->first();
        $data = [
            'page' => $page
        ];
        return view('admin.page.PagesEditPage',$data);
    }
    // 修改頁面
    public function PagesEdit(Request $request, $pages_id)
    {
            // 驗證傳入的數據
            $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => ['required',  Rule::unique('pages')->ignore($pages_id),],
        ], [
            'title.required' => ':attribute為必填',
            'description.required' => ':attribute為必填',
            'url.required' => ':attribute為必填',
            'url.unique' => ':attribute已存在，換一個試試看吧',
        ], [
            'title' => '頁面標題',
            'description' => '頁面簡介',
            'url' => '自定義連結',
        ]);
        $datas = [];
        $datas['title'] = $request->input('title');
        $datas['description'] = $request->input('description');
        $datas['url'] = $request->input('url');
        //存入資料庫
        Page::where('id', $pages_id)->update($datas);
        $message_title = "儲存成功";
        $message_type = "success";
        $message = "已將頁面資料更新";
        return redirect()->route('PagesPage')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
    // 刪除頁面
    public function PagesDelete($pages_id)
    {
        // 刪除選單
        Page::where('id',$pages_id)->delete();
        $message_title = "刪除成功";
        $message_type = "success";
        $message = "已刪除該頁面";
        return redirect()->route('PagesPage')
                            ->with('message_title', $message_title)
                            ->with('message_type', $message_type)
                            ->with('message', $message);
    }
    // 顯示畫面
    public function PagesPageView($url)
    {
        $page = Page::where('url', $url)->with('PageComponents.Component')->first();

        foreach ($page->pageComponents as $pc) {
            if($pc->data=="{}"){
                $pc->data=null;
            }else{
                $pc->data = json_decode($pc->data);
            }
        //    dd($pc->data);
        }
        $data = [
            'page' => $page
        ];
        // return $data;
        return view('admin.page.PagesPageView', $data);
    }
}
