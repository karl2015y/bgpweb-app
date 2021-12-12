<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $coupons = 'App\Models\Coupon'::with('Orders_Paid')->paginate(10);
        $filter = $request['filter'] ?? 'Now';
        $coupons = [];
        $coupons = 'App\Models\Coupon'::where('code', '<>', '');
        $today = 'Carbon\Carbon'::now();
        // 通行中
        if ($filter == 'Now') {
            $coupons = $coupons->where('start_at', '<=', $today)->where('end_at', '>', $today);
        }
        // 已過期
        else if ($filter == 'Before') {
            $coupons = $coupons->where('end_at', '<=', $today);
        }
        // 尚未開放
        else if ($filter == 'After') {
            $coupons = $coupons->where('start_at', '>', $today);        }
        // 已刪除
        else if ($filter == 'Delete') {
            $coupons = $coupons->onlyTrashed();
        }

        $coupons = $coupons->paginate(10);
        $data = [
            'coupons' => $coupons
        ];
        return view('admin.coupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = 'App\Models\product'::get(['id', 'name']);
        $data = [
            'products' => $products
        ];
        return view('admin.coupon.create', $data);
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
            'code' => 'required',
            'title' => 'required',
            'number' => 'required',
            'minimum_price' => 'required',
            
        ], [
            'code.required' => ':attribute為必填',
            'title.required' => ':attribute為必填',
            'number.required' => ':attribute為必填',
            'minimum_price.required' => ':attribute為必填',
          
        ], [
            'code' => '專屬折扣碼',
            'title' => '優惠券名稱',
            'number' => '折扣數',
            'minimum_price' => '最低消費金額',
        ]);

        $res = $request->input();
        $coupon = 'App\Models\Coupon'::create($res);
        $coupon->end_at = $coupon->end_at->addDay();
        $coupon->end_at = $coupon->end_at->subSecond();
        $coupon->save();
        $message_title = "成功";
        $message_type = "success";
        $message = "已新增";
        return redirect()->route('coupon.index')
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
        $coupon = 'App\Models\Coupon'::find($id);
        $data = [
            'coupon' => $coupon
        ];
        return view('admin.coupon.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = 'App\Models\product'::get(['id', 'name']);
        $coupon = 'App\Models\Coupon'::find($id);
        $data = [
            'coupon' => $coupon,
            'products' => $products
        ];
        return view('admin.coupon.edit', $data);
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
        // return $request->input();
        $res = $request->input();
        $coupon = 'App\Models\Coupon'::find($id);
        $coupon->update($res);
        $coupon->end_at = $coupon->end_at->addDay();
        $coupon->end_at = $coupon->end_at->subSecond();
        $coupon->save();
        $message_title = "成功";
        $message_type = "success";
        $message = "已完成修改";
        return redirect()->back()
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
        $coupon = 'App\Models\Coupon'::find($id);
        $coupon->delete();
        $message_title = "成功";
        $message_type = "success";
        $message = "已刪除";
        return redirect()->route('coupon.index')
            ->with('message_title', $message_title)
            ->with('message_type', $message_type)
            ->with('message', $message);
    }
}
