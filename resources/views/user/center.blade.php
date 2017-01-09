@extends('user.layouts')
@section('main')
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <form role="form" class="form-horizontal" action="">
                <div class="form-group">
                    <label>用户名</label>
                    <input class="form-control" type="text" value="薛升">
                </div>

                <div class="form-group">
                    <label>账号</label>
                    <input class="form-control" type="text" value="123456@qq.com" disabled>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary btn-sm" type="submit" value="更新信息">
                </div>
            </form>
        </div>
    </div>
@endsection

