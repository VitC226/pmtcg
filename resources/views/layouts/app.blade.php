<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('seo')

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/iconfont/iconfont.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body>
    <div id="app">
        <header class="navbar navbar-static-top navbar-fixed navbar-inverse">
            <div class="container">
              <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span>
                </button> 

                <a href="/" class="navbar-brand"><i class="font_family icon-logo"></i></span>{{trans('website.title')}}</a>
              </div>
              <nav id="bs-navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                    <ul class="nav navbar-nav navbar-right">
                        <li id="langBar" class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span id="langText">{{ App::getLocale() == 'zh-cmn-Hans'?"简":"繁" }}</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a data-lang="zh-cmn-Hans">简体中文</a></li>
                                <li><a data-lang="zh-cmn-Hant">繁體中文</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/download">{{trans('website.menu_download')}}</a>
                        </li>
                        <li>
                            <a href="/shop">商店</a>
                        </li>
                        <li>
                            <a href="/login">登录</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>
        
        @yield('content')
        <div class="to-top">&uarr;</div>
        <footer class="footer">
            <div class="container">
                © 2016-2018 pmtcgo.com

                <div class="btn-qq pull-right" onclick='_czc.push(["_trackEvent", "底部","QQ群"]);'>
                    <img border="0" src="{{ asset('img/qq.png') }}" alt="口袋妖怪TCG中文网" title="口袋妖怪TCG中文网">
                    <div class="popover top" style="right:-7px; left:auto; top:-242px; width:200px;">
                        <div class="arrow" style="left: 91%;"></div>
                        <h3 class="popover-title">QQ交流群</h3>
                        <div class="popover-content text-center">
                            QQ群：<a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=3da5c2a9c7c6042440c546d5b4cc960689b19e671d511db11838bd34b1800aaf">168406561</a>
                            <img src="{{ asset('img/qun_ewm.png') }}" style="width:100%;">
                        </div>
                </div>
                </div>
                
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
    <div class="hide">
        <script src='http://veim.lrswl.com/s.php?id=11265'></script>
        <script src="https://s19.cnzz.com/z_stat.php?id=1273622184&web_id=1273622184" language="JavaScript"></script>
      <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();

        $(function(){
            $('.to-top').toTop();

            $("#langBar li").on("click","a",function(){
                var lang = $(this).data("lang");
                $.get('/lang',{ language: lang }, function(data){
                    if(data.lang){ window.location.reload(); }
                });
            });

            $(".btn-qq").on("click", function(){
                $(".btn-qq .popover").toggle();
            });
        });
    </script>
    </div>
</body>
</html>
