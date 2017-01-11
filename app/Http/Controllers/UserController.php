<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 要更新的字段
     *
     * @return void
     */
    protected $updatedField = [
        'name','zendao_username','zendao_password'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 基本信息
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Xues
     */
    public function baseInfo(Request $request)
    {
        $user = Auth::user();
        return view('user.center', [
            'name' => $request->old('name') ? $request->old('name') : $user->name,
        ]);
    }

    /**
     * 用户信息更新
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Xues
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        foreach ($this->updatedField as $field) {
            if ($request->has($field)) {
                $user->$field = $request->input($field);
            }
        }

        if (!$user->save()) {
            return back()->withInput()->with('msg', '更新失败');
        }

        return back()->with('success_msg', '更新成功');
    }

    public function zenDao()
    {
        return view('user.zendao', [
            'zendao_username' => Auth::user()->zendao_username,
            'zendao_password' => Auth::user()->zendao_password
        ]);
    }

    public function secure()
    {
        return view('user.secure', [
            'zendao_username' => Auth::user()->zendao_username,
            'zendao_password' => Auth::user()->zendao_password
        ]);
    }



}
