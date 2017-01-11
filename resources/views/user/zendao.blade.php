@extends('user.layouts')
@section('main')
    <div class="row">
        <div class="col-md-5 col-md-offset-1">
            <form role="form" class="form-horizontal" action="{{ url('user/update') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>禅道账号</label>
                    <input class="form-control" type="text" value="{{ $zendao_username }}" name="zendao_username">
                </div>

                <div class="form-group">
                    <label>禅道密码</label>
                    <input class="form-control" type="text" value="{{ $zendao_password }}" name="zendao_password">
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