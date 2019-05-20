@extends('layouts.app')

@section('meta')
<title>设置个人信息 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">设置个人信息 <a href="{{ route('people.index',['user' => Auth::user()->id]) }}"><span class="f_right">返回我的主页<span></a></div>

                <div class="panel-body">


                        <div class="panel-body">
                                    <avatar-component avatar="{{ Auth::user()->avatar }}"></avatar-component>
                        </div>


                        <form action="{{ route('setting') }}" method="post" role="form" class="form-horizontal">

                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">性别</label>
                                    <div class="col-md-6">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" {{ isset($setting['gender']) && $setting['gender'] == '男' ? 'checked' : '' }} name="gender" id="gender" value="男" checked> 男
                                                </label>

                                                <label>
                                                    <input type="radio" {{ isset($setting['gender']) && $setting['gender'] == '女' ? 'checked' : '' }} name="gender" id="gender" value="女"> 女
                                                </label>

                                            </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('hy') ? ' has-error' : '' }}">
                                    <label for="hy" class="col-md-4 control-label">所在行业</label>
                                    <div class="col-md-6">
                                            <select class="form-control" name="hy">
                                              <option {{ isset($setting['hy']) && $setting['hy'] == '高新科技' ? 'selected' : '' }} value="高新科技">高新科技</option>
                                              <option {{ isset($setting['hy']) && $setting['hy'] == '互联网' ? 'selected' : '' }} value="互联网">互联网</option>
                                              <option {{ isset($setting['hy']) && $setting['hy'] == '电子商务' ? 'selected' : '' }} value="电子商务">电子商务</option>
                                              <option {{ isset($setting['hy']) && $setting['hy'] == '计算机硬件' ? 'selected' : '' }} value="计算机硬件">计算机硬件</option>
                                              <option {{ isset($setting['hy']) && $setting['hy'] == '出版业' ? 'selected' : '' }} value="出版业">出版业</option>
                                            </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="hy" class="col-md-4 control-label">职业经历</label>
                                    <div class="col-md-6 flex">
                                                <input type="text" name="company" class="form-control" id="company" placeholder="公司或组织名称" value="{{ isset($setting['company']) ? $setting['company'] : '' }}">
                                                <input type="text" name="position" class="form-control margin-left-5" id="position" placeholder="你的职位" value="{{ isset($setting['position']) ? $setting['position'] : '' }}">
                                    </div>
                                </div>




                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="col-md-4 control-label">现居城市</label>
                                    <div class="col-md-6">
                                        <input id="city" type="text" value="{{ $setting['city'] }}" class="form-control" name="city" required>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">自我描述</label>
                                    <div class="col-md-6">
                                        <input id="bio" type="text" value="{{ $setting['bio'] }}"  class="form-control" name="bio" required>

                                        @if ($errors->has('bio'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('bio') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('self') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">个人简介</label>
                                    <div class="col-md-6">
                                        <textarea id="self" type="text"  class="form-control" name="self" required>{{ $setting['self'] }}</textarea>

                                        @if ($errors->has('self'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('self') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            更新资料
                                        </button>
                                    </div>
                                </div>

                        </form>                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
