@extends('layouts.app')

@section('meta')
<title>更换头像 - {{ config('app.name', 'Discovery') }}</title>
<meta name="Keywords" content="Discovery,discovery,海是天的倒影">
<meta name="Description" content="海是天的倒影,Discovery,discovery">
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">更换头像</div>

                <div class="panel-body">
                            <avatar-component avatar="{{ $avatar }}"></avatar-component>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
