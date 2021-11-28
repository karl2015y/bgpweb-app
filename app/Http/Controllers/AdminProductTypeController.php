<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductTypeController extends Controller
{
    // 規格列表
    public function TypeListPage(Request $request)
    {
        $product_id = $request->input('product_id') ?? null;
        if ($product_id == null) {
            return redirect()->back();
        }
        $productType = 'App\Models\productType'::where('product_id', $product_id)->get(['id', 'name', 'options']);
        $data = [
            'product' => 'App\Models\product'::find($product_id),
            'productType' => $productType
        ];
        // return $data;
        return view('admin.product.type.TypeListPage', $data);
    }

    // 新增規格
    public function CreateTypePage(Request $request)
    {
        $product_id = $request->input('product_id') ?? null;
        if ($product_id == null) {
            return redirect()->back();
        }
        // $productType = 'App\Models\productType'::where('product_id', $product_id)->get(['name', 'options']);
        $data = [
            'product_id' => $product_id,
            // 'product' => 'App\Models\product'::find($product_id),
            // 'productType' => $productType
        ];
        // return $data;
        return view('admin.product.type.CreateTypePage', $data);
    }
    public function CreateType(Request $request){
        $data = $request->input();
        'App\Models\productType'::create($data);
        // return $data;
        $message_title = "成功";
        $message_type = "success";
        $message = "新增成功";
        return redirect()->route('admin_product_type.TypeListPage',['product_id'=>$data['product_id']])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 編輯規格
    public function EditTypePage(Request $request, $id)
    {
        $productType = 'App\Models\productType'::find($id, ['id', 'product_id', 'name', 'options']);
        $data = [
            'product_id' => $productType->product_id,
            // 'product' => 'App\Models\product'::find($product_id),
            'productType' => $productType
        ];
        // return $data;
        return view('admin.product.type.EditTypePage', $data);
    }
    public function EditType(Request $request, $id){
        $data = $request->input();
        // return $data;
        $productType = 'App\Models\productType'::find($id);
        $productType->update($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "更新成功";
        return redirect()->back()
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 刪除規格
    public function DeleteType($id){
        $productType = 'App\Models\productType'::find($id);
        $productType->delete();
        $message_title = "成功";
        $message_type = "success";
        $message = "已刪除";
        return redirect()->route('admin_product_type.TypeListPage',['product_id'=>$productType['product_id']])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    // 更新規格
    public function UpdateItems(Request $request){
        $product_id = $request->input('product_id') ?? null;
        if ($product_id == null) {
            return redirect()->back();
        }
        $productTypes = 'App\Models\productType'::where('product_id', $product_id)->get(['name', 'options']);
        $options_org = [];
        foreach ($productTypes as $type) {
            array_push($options_org, explode(", ", $type->options));
        }
        $items = array_shift($options_org);

        while (count($options_org)>0) {
            $item_temp = [];
            $current_array = array_shift($options_org);
            for ($i=0; $i < count($items); $i++) { 
                for ($j=0; $j < count($current_array); $j++) { 
                    array_push($item_temp, $items[$i].$current_array[$j]);
                }
            }
            $items =  $item_temp ;
        }

        $create_items = [];
        foreach ( $items as $item) {
            array_push($create_items, ['name'=>$item, 'product_id'=> $product_id]);
        }
        // return $create_items;

        // 清除所有Item
        'App\Models\productItem'::where('product_id', $product_id)->delete();
        foreach ($create_items as $c_item) {
            'App\Models\productItem'::create($c_item);
        }
        
        $message_title = "成功";
        $message_type = "success";
        $message = "已更新";
        return redirect()->route('admin_product.show',$product_id)
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }


}
