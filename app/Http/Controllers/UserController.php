<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        return view('user.secure');
    }

    public function passwordReset(Request $request)
    {
        $input = $request->all();

        $oldPassword = $request->input('old_password');
        $password = $request->input('password');
        $rules = [
            'old_password' => 'required|between:6,20',
            'password' => 'required|between:6,20|confirmed',
        ];
        $messages = [
            'required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];

        $validator = Validator::make($input, $rules, $messages);

        $user = Auth::user();
        $validator->after(function ($validator) use ($oldPassword, $user) {
            if (!Hash::check($oldPassword, $user->password)) {
                $validator->errors()->add('old_password', '原密码错误');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();
        return redirect('/login');
    }

}
