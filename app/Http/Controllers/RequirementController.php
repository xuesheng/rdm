<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Requirements;
use App\RequirementsSqls;
use Illuminate\Support\Facades\Auth;

class RequirementController extends Controller
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
     * @return object
     * @author Xues
     */
    public function lists()
    {
        $lists = Requirements::where('user_id', Auth::id())->withCount('files')->get();

        return view('requirements.lists', [
            'lists' => $lists,
        ]);
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
        //code
    }

    /**
     * 查看需求
     * @param Request $request 请求参数
     * @param int $id 需求id
     * @return array
     * @author xues
     */
    public function show(Request $request, $id = 0)
    {
        $requirements = Requirements::findOrFail($id);

        return view('requirements.show', [
            'id' => $requirements->id,
            'serial_number' => $requirements->serial_number,
            'name' => $requirements->name,
            'sponsor' => $requirements->sponsor,
            'finished_at' => $requirements->finished_at,
            'sqls' => $requirements->sqls()->orderBy('id', 'desc')->pluck('sql'),
            'files' => $requirements->files()->get(['name','local_path']),
        ]);
    }

    /**
     * 存储新的sql语句
     * @param Request $request 请求参数
     * @return array
     * @author xues
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
        $requirements->finished_at = strtotime($data['finished_at']);

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
        $requirements = Requirements::findOrFail($id);

        return view('requirements.edit', [
            'id' => $requirements->id,
            'serial_number' => $requirements->serial_number,
            'name' => $requirements->name,
            'sponsor' => $requirements->sponsor,
            'finished_at' => $requirements->finished_at,
            'sqls' => $requirements->sqls()->orderBy('id', 'desc')->pluck('sql'),
            'files' => $requirements->files()->get(['name','local_path']),
        ]);
    }

}
