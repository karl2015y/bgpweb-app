<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public $allKVs;
    function __construct()
    {
        $this->allKVs = $this->allKVs ?? Setting::all();
    }
    public function createFackData()
    {
        $kvs = [
            // ['key' => 'main_logo', 'value' => '/images/main_logo.png', 'type' => 'pic', 'text' => '主LOGO'],
            // ['key' => 'sec_logo', 'value' => '/images/sec_logo.png', 'type' => 'pic', 'text' => '副LOGO'],
            // // FB
            // ['key' => 'facebook_icon', 'value' => 'fab fa-facebook text-xl', 'text' => 'FB Icon'],
            // ['key' => 'facebook_icon_color', 'value' => 'text-gray-350', 'text' => 'FB Icon 顏色'],
            // ['key' => 'facebook_icon_hover_color', 'value' => 'text-gray-550', 'text' => 'FB Icon 滑鼠滑過時的顏色'],
            // ['key' => 'facebook_link', 'value' => '#FB', 'text' => 'FB 連結'],
            // // IG
            // ['key' => 'instagram_icon', 'value' => 'fab fa-instagram text-xl', 'text' => 'IG Icon'],
            // ['key' => 'instagram_icon_color', 'value' => 'text-gray-350', 'text' => 'IG Icon 顏色'],
            // ['key' => 'instagram_icon_hover_color', 'value' => 'text-gray-550', 'text' => 'IG Icon 滑鼠滑過時的顏色'],
            // ['key' => 'instagram_link', 'value' => '#IG', 'text' => 'IG 連結'],
            // // TWITTER
            // ['key' => 'twitter_icon', 'value' => 'fab fa-twitter text-xl', 'text' => 'Twitter Icon'],
            // ['key' => 'twitter_icon_color', 'value' => 'text-gray-350', 'text' => 'Twitter Icon 顏色'],
            // ['key' => 'twitter_icon_hover_color', 'value' => 'text-gray-550', 'text' => 'Twitter Icon 滑鼠滑過時的顏色'],
            // ['key' => 'twitter_link', 'value' => '#TWITTER', 'text' => 'Twitter 連結'],
            // // LINE
            // ['key' => 'line_icon', 'value' => 'fab fa-line text-xl', 'text' => 'LINE Icon'],
            // ['key' => 'line_icon_color', 'value' => 'text-gray-350', 'text' => 'LINE Icon 顏色'],
            // ['key' => 'line_icon_hover_color', 'value' => 'text-gray-550', 'text' => 'LINE Icon 滑鼠滑過時的顏色'],
            // ['key' => 'line_link', 'value' => '#LINE', 'text' => 'LINE 連結'],
            // // ECPAY
            // ['key' => 'ecpay_MerchantID', 'value' => '2000132', 'text' => '綠界特店編號(MerchantID)'],
            // ['key' => 'ecpay_HashKey', 'value' => '5294y06JbISpM5x9', 'text' => '綠界HashKey'],
            // ['key' => 'ecpay_HashIV', 'value' => 'v77hoKGq4kWxNNIS', 'text' => '綠界HashIV'],

            // ['key' => 'SenderName', 'value' => '李碩祺', 'text' => '寄件人姓名'],
            // ['key' => 'SenderPhone', 'value' => '886912345678', 'text' => '寄件人電話'],
            // ['key' => 'SenderCellPhone', 'value' => '0912345678', 'text' => '寄件人手機'],
            // ['key' => 'SenderZipCode', 'value' => '408', 'text' => '寄件人郵遞區號'],
            // ['key' => 'SenderAddress', 'value' => '臺中市南屯區', 'text' => '寄件人地址'],

            // // 物流價錢
            // ['key' => 'owner_shipping', 'value' => '110', 'text' => '基本物流(自訂物流)價錢'],
            // ['key' => 'HOME_TCAT', 'value' => '120', 'text' => '黑貓物流價錢'],
            // ['key' => 'HOME_ECAN', 'value' => '130', 'text' => '宅配通價錢'],
            // ['key' => 'CVS_FAMIC2C', 'value' => '65', 'text' => '全家物流價錢'],
            // ['key' => 'CVS_UNIMARTC2C', 'value' => '66', 'text' => '7-ELEVEN 超商物流價錢'],
            // ['key' => 'CVS_HILIFEC2C', 'value' => '67', 'text' => '萊爾富物流價錢'],
            // ['key' => 'CVS_OKMARTC2C', 'value' => '68', 'text' => 'OK 超商價錢'],

            // // FB Chat
            // ['key' => 'facebook_chat', 'value' => '', 'type' => 'textarea', 'text' => 'FB紛絲專頁聊天室'],
            // // GTM
            // ['key' => 'GTM', 'value' => '', 'type' => 'textarea', 'text' => 'GTM追蹤/GA追蹤'],
            ['key' => 'ad_title', 'value' => '', 'text' => '廣告標題'],
            ['key' => 'ad_content', 'value' => '', 'type' => 'textarea', 'text' => '廣告內容'],
            ['key' => 'ad_button', 'value' => '', 'text' => '廣告按鈕'],
            ['key' => 'ad_button_link', 'value' => '', 'text' => '廣告按鈕連結'],

        ];
        foreach ($kvs as $kv) {
            $data = ['value' => $kv['value'], 'text' => $kv['text']];
            if ($kv['type'] ?? false) {
                $data['type'] = $kv['type'];
            }
            Setting::updateOrCreate(['key' => $kv['key']], $data);
        }

        return Setting::all();
    }
    public function get($key)
    {
        $allKVs = $this->allKVs;
        // $allKVs = $allKVs ?? Setting::all();

        return $allKVs->where('key', $key)->first()->value ?? null;
    }

    public function index()
    {
        $allKVs = count($this->allKVs) == 0 ? $this->createFackData() : $this->allKVs;

        $data = [
            'kvs' => $allKVs,
        ];
        // return $data;
        return view('admin.setting.index', $data);
    }
    public function edit($id, $type)
    {
        $kv = Setting::find($id);
        $data = [
            'type' => $type,
            'kv' => $kv,
        ];
        // return $data;
        if ($type == 'pic') {
            return view('admin.setting.edit_pic', $data);
        }
        return view('admin.setting.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $data = $request->input();
        $kv = Setting::find($id);
        $kv->update($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "已儲存";
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    public function update_pic(Request $request, $id)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'image.image' => ':attribute必須為圖片',
            'image.mimes' => ':attribute格是錯誤，目前只支援jpeg，png，jpg，gif，svg',
            'image.max' => ':attribute太大了，只支援5MB',
        ], [
            'image' => '類別圖片',
        ]);
        $kv = Setting::find($id);
        $org_img_path = $kv->value;

        if ($request->image) {
            // 如果有上傳圖片，就移動圖片到public，接著刪除原有圖片
            if ('File'::exists(public_path($org_img_path))) {
                'File'::delete(public_path($org_img_path));
            }

            $org_imageName = time() . '.' . $request->image->extension();
            $new_imageName = time() . '.jpg';
            $request->image->move(public_path('images'), $org_imageName);
            $img = 'Intervention\Image\Facades\Image'::make(public_path('/images/' . $org_imageName))->encode('jpg', 75);
            $img->save(public_path('/images/' . $new_imageName));
            if ($org_imageName != $new_imageName) {
                'File'::delete(public_path('/images/' . $org_imageName));
            }
        }



        $data = [
            'value' =>  '/images/' . $new_imageName
        ];



        $kv->update($data);

        $message_title = "成功";
        $message_type = "success";
        $message = "已修改";
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
}
