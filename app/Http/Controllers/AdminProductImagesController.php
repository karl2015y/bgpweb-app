<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product_id = $request->input('product_id') ?? null;
        if ($product_id == null) {
            return redirect()->back();
        }
        $product = 'App\Models\product'::find($product_id);
        $imgs = $product->Imgs()->paginate(10);
        // $category = 'App\Models\productCategory'::find($category_id);
        $data = [
            'product' => $product,
            'imgs' => $imgs
        ];
        // return $data;
        return view('admin.product.productImg.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product_id = $request->input('product_id') ?? null;
        if ($product_id == null) {
            return redirect()->back();
        }
        $product = 'App\Models\product'::find($product_id);
        $data = [
            'product' => $product
        ];

        return view('admin.product.productImg.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'product_id.required' => ':attribute為必填',
            'image.required' => ':attribute為必填',
            'image.image' => ':attribute必須為圖片',
            'image.mimes' => ':attribute格是錯誤，目前只支援jpeg，png，jpg，gif，svg',
            'image.max' => ':attribute太大了，只支援5MB',
        ], [
            'product_id' => '商品編號',
            'image' => '商品圖片',
        ]);

        $org_imageName = time() . '.' . $request->image->extension();
        $new_imageName = time() . '.jpg';
        $request->image->move(public_path('images'), $org_imageName);
        $img = 'Intervention\Image\Facades\Image'::make(public_path('/images/' . $org_imageName))->encode('jpg', 75);
        $img->save(public_path('/images/' . $new_imageName));
        if($org_imageName != $new_imageName){
            'File'::delete(public_path('/images/' .$org_imageName ));
        }
        $data = [
            'product_id' => $request->input('product_id'),
            'img_url' => '/images/' . $new_imageName,
        ];
        if($request->input('name')){
            $data['name'] = $request->input('name');
        }

        $img = 'App\Models\productImg'::create($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "已新增";
        return redirect()->route('admin_product_imgs.edit', $img->id)
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $img = 'App\Models\productImg'::find($id);
        $product = $img->Product;
        $category = $product->Category;
        $data = [
            'img' => $img,
            'product'=> $product,
        ];
        return view('admin.product.productImg.edit', $data);

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
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ], [
            'image.image' => ':attribute必須為圖片',
            'image.mimes' => ':attribute格是錯誤，目前只支援jpeg，png，jpg，gif，svg',
            'image.max' => ':attribute太大了，只支援5MB',
        ], [
            'image' => '類別圖片',
        ]);
        $p_img = 'App\Models\productImg'::find($id);
        $org_img_path = $p_img->img_url;

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
        if($request->input('name')){
            $data['name'] = $request->input('name');
        }
        if($request->image){
            $data['img_url'] =  '/images/' . $new_imageName;
        }
    

        $p_img->update($data);

        $message_title = "成功";
        $message_type = "success";
        $message = "已修改";
        return redirect()->route('admin_product_imgs.edit', $p_img->id)
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
        $img = 'App\Models\productImg'::find($id);
        $org_img_path = $img->img_url;
        // 如果有上傳圖片，就移動圖片到public，接著刪除原有圖片
        if ('File'::exists(public_path($org_img_path))) {
            'File'::delete(public_path($org_img_path));
        }
        $img->delete();
        $message_title = "成功";
        $message_type = "success";
        $message = "已刪除";
        return redirect()->route('admin_product_imgs.index', ['product_id' => $img->product_id])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
}
