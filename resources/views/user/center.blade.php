@extends('user.layouts')
@section('main')
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <form role="form" action="{{ url('user/update') }}" method="post">
                <h4 class="font-green">基本信息</h4>

                {{ csrf_field() }}
                <div class="form-group">
                    <label>用户名</label>
                    <input class="form-control" type="text" value="{{ $name }}" name="name">
                </div>

                <div class="form-group">
                    <label>账号</label>
                    <input class="form-control" type="text" value="123456@qq.com" disabled>
                </div>

                @if (session('msg'))
                    <div class="form-group">
                        <div class="alert alert-danger alert-sm">
                            {{ session('msg') }}
                        </div>
                    </div>
                @endif

                @if (session('success_msg'))
                    <div class="form-group">
                        <div class="alert alert-success alert-sm">
                            {{ session('success_msg') }}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <input class="btn btn-primary btn-sm" type="submit" value="保存">
                </div>

            </form>
        </div>
    </div>
@endsection

