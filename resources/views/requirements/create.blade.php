@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h4>创建需求</h4>
                <form role="form">
                    <div class="form-group">
                        <label for="serial-number">需求编号</label>
                        <input type="text" id="serial-number" class="form-control" name="serial-number" v-model="serial_number" value="" ref="input_serial_number" placeholder="输入编号,如123456" required="required">
                    </div>
                    <p class="help-block">请输入指派给自己的需求编号，进行导入。</p>
                    <div>
                        <button id="fetch" class="btn btn-primary btn-sm" v-on:click="implode" ref="button_fetch">导入</button>
                    </div>
                </form>

                <div>
                    <h5>需求信息</h5>
                    <p>
                        <span>需求名称：</span><mark v-cloak>@{{ name }}</mark>
                    </p>
                    <p>
                        <span>需求发起人：</span><mark v-cloak>@{{ sponsor }}</mark>
                    </p>
                    <p>
                        <span>截止时间：</span><mark v-cloak>@{{ finished_at }}</mark>
                    </p>
                    <p>
                        <a href="javascript:;" class="btn btn-primary" v-cloak v-bind:class="{hidden: a_edit_hidden}" target="_blank" role="button" ref="a_edit">编辑</a>
                    </p>
                </div>

            </div>

        </div>
    </div>
@endsection
