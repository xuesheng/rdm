@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div>
                    <h4>需求信息</h4>
                    <input type="hidden" value="{{ $id }}" ref="requirement_id">
                    <p><span>需求编号：</span><mark>{{ $serial_number }}</mark></p>
                    <p><span>需求名称：</span><mark>{{ $name }}</mark></p>
                    <p><span>需求发起人：</span><mark>{{ $sponsor }}</mark></p>
                    <p><span>截止时间：</span><mark>{{ $finished_at }}</mark></p>
                </div>

                <p>
                    <h6>备注</h6>
                    <div><textarea name="remark" id="remark" cols="30" rows="5"></textarea></div>
                    <div><button class="btn btn-primary btn-sm">保存备注</button></div>
                </p>

            </div>

            <div class="col-md-4">
                <h4>编辑需求</h4>
                <p>上传代码</p>
                <form method="post" enctype="multipart/form-data" action="/requirements/uploadfile">
                    <input type="hidden" name="requirement_id" value="{{ $id }}">
                    <p><input id="code-file" class="file" type="file" name="code_file"></p>
                    {{ csrf_field() }}
                    <p>
                        <h6>本地路径</h6>
                        <div><input id="local-path" type="text" name="local_path" value="" class="form-control"></div>
                    </p>
                    @if (session('msg'))
                    <div class="alert alert-danger alert-sm">
                        {{ session('msg') }}
                    </div>
                    @endif

                    @if (session('success_msg'))
                        <div class="alert alert-success alert-sm">
                            {{ session('success_msg') }}
                        </div>
                    @endif

                    <p><input  class="btn btn-primary" type="submit" value="上传"></p>
                </form>
                <p>
                    <h5>代码目录</h5>
                    <ul>
                        @foreach ($files as $file)
                            <li><mark>{{ $file['name'] }}</mark><br>[ {{ $file['local_path'] }} ]</li>
                        @endforeach
                    </ul>
                </p>

            </div>

            <div class="col-md-4">
                <h4>&nbsp;</h4>
                <div>
                    <p><button class="btn btn-primary btn-sm" v-on:click="addSql(newSql)" ref="button_add_sql">新增SQL</button></p>

                    <p><textarea name="sql" id="new-sql" cols="50" rows="2" v-model="newSql"></textarea></p>
                </div>
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
