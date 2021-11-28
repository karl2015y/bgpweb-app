<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 商城首頁
    public function ShopIndexPage()
    {
        $data = [];
        return view('shop.index', $data);
    }

    // 商城分類頁
    public function categorysPage()
    {
        $data = [
            'categorys' => 'App\Models\productCategory'::all(),
            'product_count' => 'App\Models\product'::count(),
        ];
        return view('shop.categorys', $data);
    }


    // 商城多商品頁
    public function productsPage(Request $request)
    {
        $products = 'App\Models\product'::where('id','<>',null);
        $keyword = $request->input('keyword') ?? null;
        $category_id = $request->input('category_id') ?? null;
        $data = [];
        if($keyword){
            $products->where('name', 'like', '%' . $keyword . '%');
            $data['keyword'] = $keyword;
        }else if($category_id){
            $products->where('category_id', $category_id);
            $data['category'] = 'App\Models\productCategory'::find($category_id);
        }

        $data['products'] = $products = $products->paginate(10);
         

        // return $data;
        return view('shop.products', $data);
    }

    // 商城商品單頁
    public function productPage(Request $request, $id)
    {
        $product = 'App\Models\product'::with('Imgs', 'Types', 'Items')->find($id);
        $data = [
            'product' => $product,
        ];
        return view('shop.product', $data);
    }
}
