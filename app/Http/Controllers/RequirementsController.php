<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requirements;
use App\RequirementsSqls;
use Illuminate\Support\Facades\Auth;

class RequirementsController extends Controller
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
     * 需求列表
     *
     * @return void
     * @author Xues
     */
    public function lists()
    {

    }

    /**
     * 创建需求
     *
     * @return Response
     * @author Xues
     */
    public function create()
    {
        return view('requirements.create');
    }

    /**
     * 存储新的需求
     * @param Request $request 请求参数
     *
     */
    public function store(Request $request)
    {
        


    }

    /**
     * 存储新的sql语句
     * @param Request $request 请求参数
     * @return array
     */
    public function storeSql(Request $request)
    {
        $id = $request->input('id');
        $sql = $request->input('sql');

        //根据id判断需求是否存在
        if (!Requirements::find($id)) {
            return response()->json([
                'code' => 1,
                'msg' => '需求不存在',
                'data' => 0
            ]);
        }
        $requirementsSqls = new RequirementsSqls();
        $requirementsSqls->requirement_id = $id;
        $requirementsSqls->sql = $sql;

        if ($requirementsSqls->save()) {
            return response()->json([
                'code' => 0,
                'msg' => 'sql添加成功',
                'data' => $requirementsSqls->id
            ]);

        }

        return response()->json([
            'code' => 1,
            'msg' => 'sql添加失败',
            'data' => 0
        ]);


    }

    /**
     * 抓取禅道数据
     * @param Request $request 请求参数
     * @return json
     */
    public function fetch(Request $request)
    {
        $serialNumber = $request->input('serialNumber', 0);
        $requirements = new Requirements();
        return response()->json($requirements->fetchZenDaoData($serialNumber));
    }

    /**
     * 导入禅道数据
     * @param Request $request 请求参数
     * @return json
     */
    public function implode(Request $request)
    {
        $serialNumber = $request->input('serial_number', 0);
        //先验证该需求是否存在
        $dataModel = Requirements::where('serial_number', $serialNumber)->first(['id', 'serial_number', 'name', 'sponsor', 'finished_at']);
        if ($dataModel !== null) {
            return response()->json([
                'code' => 0,
                'msg' => '该需求已经存在',
                'data' => $dataModel->toArray(),
            ]);
        }

        $requirements = new Requirements();
        $data = $requirements->fetchZenDaoData($serialNumber);

        if (count($data) === 0) {
            return response()->json([
                'code' => 1,
                'msg' => '需求信息获取失败',
                'data' => []
            ]);
        }

        //添加数据
        $requirements->serial_number = $data['serial_number'];
        $requirements->user_id = Auth::id();
        $requirements->name = $data['name'];
        $requirements->sponsor = $data['sponsor'];
        $requirements->finished_at = $data['finished_at'];

        if ($requirements->save()) {
            return response()->json([
                'code' => 0,
                'msg' => '导入成功',
                'data' => array_merge($data,['id' => $requirements->id]),
            ]);
        }

        return response()->json([
            'code' => 1,
            'msg' => '导入失败',
            'data' => []
        ]);

    }

    /**
     * 编辑页面
     *
     * @param Request $request
     * @param $id
     * @return mixed
     * @author xues
     */
    public function edit(Request $request, $id = 0)
    {
        $dataModel = Requirements::findOrFail($id);
        return view('requirements.edit', [
            'id' => $dataModel->id,
            'serial_number' => $dataModel->serial_number,
            'name' => $dataModel->name,
            'sponsor' => $dataModel->sponsor,
            'finished_at' => $dataModel->finished_at,
            'sqls' => $dataModel->sqls()->orderBy('id', 'desc')->pluck('sql'),
            'files' => $dataModel->files()->get(['name','local_path']),
        ]);
    }

}
