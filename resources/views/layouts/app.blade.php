<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apiToken" content="{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}">
    <link rel="shortcut icon" type="image/x-icon" href="https://www.djfml6.com/images/icon/green_48px_1220379_easyicon.net.ico">

    @yield('meta')

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <script>
        @if(Auth::check())
            window.Zhihu = {
                id:"{{Auth::user()->id}}",
                name:"{{Auth::user()->name}}",
                avatar:"{{Auth::user()->avatar}}",
            }
        @else
            window.Zhihu = {
                id:"",
                name:"",
                avatar:"",
            }

        @endif


    </script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <!-- {{ config('app.name', 'Laravel') }} -->
                        <span style="color: black;font-weight: 700">Disco</span><span style="color: #2ab27b;font-weight: 700">very</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="/">首页</a></li>
                        <li><a href="{{ route('topic.index') }}">话题</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-left">
                    <div class="search bar6">
                        <form action="{{ route('search') }}" method="GET">
                            <input type="text" placeholder="搜索喜欢的内容..." name="q">
                            <button type="submit"></button>
                        </form>
                    </div>                       

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->

                        @guest
                            <li><a href="{{ route('login') }}">登录</a></li>
                            <li><a href="{{ route('register') }}">注册</a></li>
                        @else
                            <li class="dropdown">
                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    <span class="badge" style="background-color: #c5464a;"> {{ getUnReadCount() }} </span>
                                    <img class="border-radis-img" style="width: 30px;height: 30px;" src="{{ Auth::user()->avatar }}">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('people.index', ['user' => Auth::user()->id]) }}">
                                            我的主页
                                        </a>                                                        
                                        <a href="{{ route('notifications') }}">
                                            消息通知
                                        </a>        
                                        <a href="{{ route('messages.index') }}">
                                            私信列表
                                        </a>
                                        <a href="{{ route('user.password') }}">
                                            更换密码
                                        </a>                                                                            
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">@include('flash::message')</div>
        @yield('content')
    </div>

    <div></div>
    <footer id="footer">
        <div class="container">

            <div class="copyright">
                Copyright © 2018-2019 <a href="/">www.djfml6.com</a>. 当前呈现版本 19-4-20<br>
                <a href="https://www.djfml6.com/" rel="nofollow">粤ICP备 18020076号</a> &nbsp;
                <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=33010602002000" rel="nofollow">邮箱</a>
                <span class="ml5">18565854805@163.com</span>
<!--                 <p class="mt30">CDN 存储服务由 <a target="_blank" href="https://www.upyun.com/?utm_source=segmentfault&amp;utm_medium=link&amp;utm_campaign=upyun&amp;md=segmentfault">又拍云</a> 赞助提供 </p> -->
            </div>

        </div>
    </footer>












    <!-- Scripts -->
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>

        // 订阅私信频道
        Echo.private('message-'+ Zhihu.id).listen('MessageEvent', (e) => {
                    var name = '发送人：'+e.from_user_name+'<br/>';
                    var message = '消息：'+e.message;
                    toastr.success(name + message,"有新消息了，请查收!");

                    var n = $('.badge').text();
                    $('.badge').text(parseInt(n)+1);

        });

        // 订阅文章推送频道
        Echo.channel('question-send').listen('QuestionSendEvent',(e) => {
                    var message = '标题：'+e.title;
                    toastr.success(message,'<a style="color:white" href="/questions/'+e.id+'">'+e.from_user+'用户发表了新文章了，赶紧评论吧</a>');

        });

        // 订阅用户关注频道
        Echo.private('myFollower-'+ Zhihu.id).listen('UserFollowerEvent',(e)=>{

            toastr.success('刚刚 '+e.username+'关注了你');

            var n = $('.badge').text();
            $('.badge').text(parseInt(n)+1);             

        });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/dist/js/social-share.min.js"></script>
    @yield('scripts')
        
    <script>

            // $('#flash-overlay-modal').modal();
           $('div .alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
</body>
</html>
