<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductItemController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = 'App\Models\productItem'::find($id);
        $data = [
            'item' => $item,
        ];
        // return $id;
        return view('admin.product.productItem.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input();
        $item = 'App\Models\productItem'::find($id);
        $item->update($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "已修改";
        return redirect()->route('admin_product_item.edit', $id)
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }


    public function editPic($id)
    {
        $item = 'App\Models\productItem'::find($id);
        $data = [
            'item' => $item,
        ];
        // return $id;
        return view('admin.product.productItem.edit_pic', $data);
    }



    public function updatePic(Request $request, $id)
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

        $item = 'App\Models\productItem'::find($id);
        $org_img_path = $item->img_url;

        if ($request->image) {
            // 如果有上傳圖片，就移動圖片到public，接著刪除原有圖片
            if('File'::exists(public_path($org_img_path))){
                'File'::delete(public_path($org_img_path ));
            }

            $org_imageName = time() . '.' . $request->image->extension();
            $new_imageName = time() . '.jpg';
            $request->image->move(public_path('images'), $org_imageName);
            $img = 'Intervention\Image\Facades\Image'::make(public_path('/images/' . $org_imageName))->encode('jpg', 75);
            $img->save(public_path('/images/' . $new_imageName));
            if($org_imageName != $new_imageName){
                'File'::delete(public_path('/images/' .$org_imageName ));
            }
        }
        
        $data = [];
        if($request->image){
            $data['img_url'] =  '/images/' . $new_imageName;
        }
        $item->update($data);

        $message_title = "成功";
        $message_type = "success";
        $message = "已修改";
        return redirect()->route('admin_product_item.editPic', $id)
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
