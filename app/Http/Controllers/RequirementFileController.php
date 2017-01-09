<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequirementsFiles;
use App\Requirements;

class RequirementFileController extends Controller
{

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
     * 上传需求代码
     * @param Request $request
     * @return mixed
     * @author xues
     */
    public function upload(Request $request)
    {
        $id = $request->input('requirement_id');
        $local_path = $request->input('local_path'); //文件上传前的本地路径
        if (!$request->hasFile('code_file')) {
            return redirect("/requirements/edit/{$id}")->with('msg', '必须选择上传文件！');
        }

        if (!$request->file('code_file')->isValid()){
            return redirect("/requirements/edit/{$id}")->with('msg', '文件上传出现异常！');
        }

        if (!Requirements::find($id)) {
            abort(404, '需求不存在！');
        }

        $file = $request->file('code_file');

        $name = $file->getClientOriginalName();
        $path = $file->store('codefiles'); //文件上传后的存储路径

        if ($path === false) {
            return redirect("/requirements/edit/{$id}")->with('msg', '文件上传失败！');
        }

        //如果文件已经上传，则更新
        if ($requirementsFiles = RequirementsFiles::where('name', $name)->where('requirement_id', $id)->first()) {

            if ($requirementsFiles->path == $path) {
                return redirect("/requirements/edit/{$id}")->with('msg', '文件未发生变化，无须重复上传！');
            }

            $requirementsFiles->path = $path;
            $requirementsFiles->local_path = $local_path;

            if (!$requirementsFiles->save()) {
                return redirect("/requirements/edit/{$id}")->with('msg', '文件更新失败！');
            }

            return redirect("/requirements/edit/{$id}")->with('msg', '文件更新成功！');
        }

        //新文件则添加
        $requirementsFiles = new RequirementsFiles();
        $requirementsFiles->requirement_id = $id;
        $requirementsFiles->path = $path;
        $requirementsFiles->name = $name;
        $requirementsFiles->local_path = $local_path; //文件上传前的本地路径

        if (!$requirementsFiles->save()) {
            return redirect("/requirements/edit/{$id}")->with('msg', '文件上传失败！');
        }

        return redirect("/requirements/edit/{$id}")->with('success_msg', '文件上传成功！');

    }
}
