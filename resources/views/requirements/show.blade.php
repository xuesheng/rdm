@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div>
                    <h4>
                        <span>编辑需求</span>
                        <a href="/requirement/edit/{{ $id }}" class="btn btn-primary btn-xs">编辑</a>
                    </h4>
                    <p><span>需求编号：</span><mark>{{ $serial_number }}</mark></p>
                    <p><span>需求名称：</span><mark>{{ $name }}</mark></p>
                    <p><span>需求发起人：</span><mark>{{ $sponsor }}</mark></p>
                    <p><span>截止日期：</span><mark>{{ $finished_at }}</mark></p>
                    <p><strong><span>上线时间：</span><mark>2017-01-08 12:00:00</mark></strong></p>
                    <p><span>备注：</span><mark>{{ $finished_at }}</mark></p>

                </div>
            </div>

            <div class="col-md-4">
                <h4>&nbsp;</h4>
                <p><strong>代码目录</strong></p>
                <p>
                <ul>
                    @foreach ($files as $file)
                        <li><mark>{{ $file['name'] }}</mark>
                            @if ($file['local_path']) [ {{ $file['local_path'] }} ] @endif
                        </li>
                    @endforeach
                </ul>
                </p>

            </div>

            <div class="col-md-4">
                <h4>&nbsp;</h4>
                <p>
                <h5>SQL语句</h5>
                <ol>
                    <li v-for="sql in sqls" v-cloak><code>@{{ sql }}</code></li>
                    @foreach ($sqls as $sql)
                        <li><code>{{ $sql }}</code></li>
                    @endforeach
                </ol>
                </p>
            </div>


        </div>
    </div>
@endsection
