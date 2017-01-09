<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * 用户中心
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Xues
     */
    public function center()
    {
        return view('user.center', [
            'active' => true,
        ]);
    }

}
