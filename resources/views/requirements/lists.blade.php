@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"><h5><strong>需求列表</strong></h5></div>
            <div class="col-md-2 col-md-offset-8 text-right">
                <a href="/requirement/import" class="btn btn-primary btn-sm" target="_blank">导入</a>
                <a href="/requirement/create" class="btn btn-primary btn-sm" target="_blank">新增</a>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>编号</th>
                            <th>名称</th>
                            <th>发起人</th>
                            <th>截止时间</th>
                            <th>上线时间</th>
                            <th>文件数</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($lists as $list)
                        <tr>
                            <td>{{ $list['serial_number'] }}</td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list['sponsor'] }}</td>
                            <td>{{ $list['finished_at'] }}</td>
                            <td>2017-01-05 12:00:00</td>
                            <td>{{ $list['files_count'] }}（个）</td>
                            <td>
                                <a href="/requirement/show/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">详细</a>
                                <a href="/requirement/edit/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">编辑</a>
                                <a href="/requirement/download/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">下载代码</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection