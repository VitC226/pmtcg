<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('css/pokemon.css') }}" rel="stylesheet">

    @yield('style')
</head>
<body>
    <div id="app">
        <header class="navbar navbar-static-top navbar-fixed">
          <div class="container">
            <div class="navbar-header">
              <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a href="../" class="navbar-brand">Bootstrap</a>
            </div>
            <nav id="bs-navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li class="active">
                  <a href="../getting-started/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-起步'])">起步</a>
                </li>
                <li>
                  <a href="../css/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-全局CSS样式'])">全局 CSS 样式</a>
                </li>
                <li>
                  <a href="../components/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-组件'])">组件</a>
                </li>
                <li>
                  <a href="../javascript/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-JavaScript插件'])">JavaScript 插件</a>
                </li>
                <li>
                  <a href="../customize/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-定制'])">定制</a>
                </li>
                <li><a href="http://www.youzhan.org" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-网站实例'])" target="_blank">网站实例</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <!-- <li><a href="http://mb.bootcss.com" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'themes'])" target="_blank">主题/模板</a></li> -->
                <li><a href="http://www.bootcss.com/" onclick="_hmt.push(['_trackEvent', 'docv3-navbar', 'click', 'V3导航-Bootstrap中文网'])" target="_blank">Bootstrap中文网</a></li>
              </ul>
            </nav>
          </div>
        </header>
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
</body>
</html>
