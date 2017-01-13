@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <div>
                    <h4>编辑需求</h4>
                    <input type="hidden" value="{{ $id }}" ref="requirement_id">
                    <p><span>需求编号：</span><mark>{{ $serial_number }}</mark></p>
                    <p><span>需求名称：</span><mark>{{ $name }}</mark></p>
                    <p><span>需求发起人：</span><mark>{{ $sponsor }}</mark></p>
                    <p><span>截止日期：</span><mark>{{ $finished_at }}</mark></p>
                    <p><strong><span>上线时间：</span><mark>2017-01-08 12:00:00</mark></strong></p>
                </div>

                <div>
                    <h6>备注</h6>
                    <p><textarea class="form-control" name="remark" id="remark" rows="5" ref="textarea_remark">{{ $remark }}</textarea></p>
                    <div class="alert alert-sm" v-cloak v-bind:class="{ 'hidden': alert_update_remark_hidden, 'alert-success': alert_update_remark_success,'alert-danger': alert_update_remark_fail }" ref="alert_update_remark"></div>
                    <p><button class="btn btn-primary btn-sm" v-on:click="addRemark()" ref="button_save_remark">更新备注</button></p>
                </div>

            </div>

            <div class="col-md-4">
                <h4>&nbsp;</h4>
                <p><strong>上传代码</strong></p>
                <form method="post" enctype="multipart/form-data" action="/requirement/uploadfile">
                    <input type="hidden" name="requirement_id" value="{{ $id }}">
                    <p><input id="code-file" class="file" type="file" name="code_file" multiple></p>
                    {{ csrf_field() }}
                    <p>
                        <h6>本地路径</h6>
                        <div><input id="local-path" type="text" name="local_path" value="" class="form-control" placeholder="选填项"></div>
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
                            <li><mark>{{ $file['name'] }}</mark>
                                @if ($file['local_path'])
                                <br>[ {{ $file['local_path'] }} ]
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </p>

            </div>

            <div class="col-md-4">
                <h4>&nbsp;</h4>
                <div>
                    <p><button class="btn btn-primary btn-sm" v-on:click="addSql(newSql)" ref="button_add_sql">新增SQL</button></p>

                    <p><textarea class="form-control" name="sql" id="new-sql" v-model="newSql" rows="5"></textarea></p>
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
