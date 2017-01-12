@extends('user.layouts')
@section('main')
    <div class="row">
        <div class="col-md-5 col-md-offset-1">

            <form role="form" action="{{ url('user/passwordreset') }}" method="post">
                <h4 class="font-green"><strong>修改密码</strong></h4>

                @if(count($errors) > 0)
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{ csrf_field() }}
                <div class="form-group">
                    <label class="control-label">原密码</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="原密码" name="old_password">
                </div>

                <div class="form-group">
                    <label class="control-label">新密码</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="新密码" name="password">
                </div>

                <div class="form-group">
                    <label class="control-label">确认密码</label>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="确认密码" name="password_confirmation">
                </div>

                <div class="form-group">
                    <input class="btn btn-success uppercase pull-right" type="submit" value="确定">
                </div>

            </form>
        </div>
    </div>
@endsection