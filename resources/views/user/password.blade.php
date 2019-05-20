@extends('layouts.app')

@section('meta')
<title>修改密码 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">修改密码</div>

                <div class="panel-body">
                        <form action="{{ route('password') }}" method="post" role="form" class="form-horizontal">

                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">原始密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="old_password" required>

                                        @if ($errors->has('old_password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('old_password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">输入新密码</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"  class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">确认新密码</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            修改
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
