<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $contacts = 'App\Models\Contact'::where('id', '<>', null);
        $status = $request->input('filter') ?? '未處理';
        if ($status) {
            $contacts = $contacts->where('status', $status);
        }


        $contacts = $contacts->paginate(10);
        $data = [
            'contacts' => $contacts,
        ];
        // return $data;
        return view('admin.contact.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'contact_name' => 'required',
            'contact_way' => 'required',
            'contact_message' => 'required',
        ], [
            'contact_name.required' => ':attribute為必填',
            'contact_way.required' => ':attribute為必填',
            'contact_message.required' => ':attribute為必填',

        ], [
            'name' => '您的姓名',
            'name' => '您的Email或手機號碼',
            'name' => '訊息',
        ]);

        $data = [
            'name' => $request->input('contact_name'),
            'email' => $request->input('contact_way'),
            'message' => $request->input('contact_message'),
        ];
        'App\Models\Contact'::create($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "已送出，我們會盡快與您聯繫";
        return redirect()->back()
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
        //
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
            'status' => 'required',
        ], [
            'status.required' => ':attribute為必填',
        ], [
            'status' => '狀態待碼',
        ]);

        $data =[
            'status' => $request->input('status')
        ];
        'App\Models\Contact'::find($id)->update($data);
        $message_title = "成功";
        $message_type = "success";
        $message = "已修改";
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
        //
    }
}
