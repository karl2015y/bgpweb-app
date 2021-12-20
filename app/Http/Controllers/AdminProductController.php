<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category_id = $request->input('category_id') ?? null;
        if ($category_id == null) {
            return redirect()->route('admin_product_category.index');
        }
        $category = 'App\Models\productCategory'::find($category_id);
        $products = 'App\Models\product'::where('category_id', $category_id)->with('Imgs')->paginate(10);
        $data = [
            'category' => $category,
            'products' => $products
        ];
        return view('admin.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.product.create', $request->input());
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
            'category_id' => 'required',
            'name' => 'required',
        ], [
            'name.required' => ':attribute為必填',
            'category_id.required' => ':attribute為必填',
        ], [
            'name' => '商品名稱',
            'category_id' => '商品類別編號',
        ]);
        $product = $request->input();
        'App\Models\product'::create($product);
        $message_title = "成功";
        $message_type = "success";
        $message = "已新增";
        return redirect()->route('admin_product.index', ['category_id' => $product['category_id']])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = 'App\Models\product'::find($id);
        $productItems = $product->Items()->paginate(10);
        $data = [
            'product' => $product,
            'productItems' => $productItems,
        ];
        return view('admin.product.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = 'App\Models\product'::find($id);
        $data = [
            'product' => $product,
            'category_id' => $product->category_id
        ];
        return view('admin.product.edit', $data);
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
        $product = 'App\Models\product'::find($id);
        if ($request->input('name')) {
            $product->name = $request->input('name');
        }
        if ($request->input('description')) {
            $product->description = $request->input('description');
        }
        $product->save();

        $message_title = "成功";
        $message_type = "success";
        $message = "已儲存";
        return redirect()->route('admin_product.edit', ['admin_product' => $product->id])
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
        $product = 'App\Models\product'::find($id);


        $product->Items()->delete();
        $product->Types()->delete();
        foreach ($product->Imgs as $img) {
            (new AdminProductImagesController())->destroy($img->id);
        }

        $product->delete();
        $message_title = "成功";
        $message_type = "success";
        $message = "已刪除";
        return redirect()->route('admin_product.index', ['category_id' => $product->category_id])
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
}
