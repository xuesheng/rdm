@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>需求列表</h5>
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
                                <a href="/requirements/show/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">详细</a>
                                <a href="/requirements/edit/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">编辑</a>
                                <a href="/requirements/download/{{ $list['id'] }}" class="btn btn-primary btn-xs" target="_blank">下载代码</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection