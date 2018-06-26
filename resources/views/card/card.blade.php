@extends('layouts.app')

@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网,{{$info->title}},{{$info->title_en}}">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>{{$info->title}} | {{$info->title_en}}__精灵宝可梦卡牌中文网</title>
@endsection

@section('style')
<link href="{{ asset('css/pokemon.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
<style>
    *{ font-size: 16px; }
    #card{ background-color: #fff; padding-top: 22px; padding-bottom: 40px; }
    #card .panel{
        border: none;
        margin-bottom: 30px;
        box-shadow: none;
    }
    #card .panel-heading{
        margin-top: 10px;
        line-height: 38px;
        margin-bottom: 0;
    }
    #card .panel-heading .pull-right{
        font-size: 25px;
    }
    #card .top .panel-heading{
        border-radius: 5px 5px 0 0;
        background-color: #ccc;
        color: #F2F2F2;
        font-size: 22px;
        padding: .6em 0.8em .3em;
    }
    #card .top .panel-content{
        display: flex;
        flex-wrap: nowrap;
        justify-content: space-between;
        align-items: center;
        background: #F2F2F2;
        color: #313131;
        clear: both;
        padding: 1.2em;
        overflow: hidden;
    }

    #card .abilitys .label {
        float: left;
        padding: .5em .6em .4em;
        margin-right: 16px;
        background-color: #d13f2d;
    }
    #card .abilitys .label.label-green{ background-color: #5c7746; }

    #card .input-group{
        margin-bottom: 30px;
        border-radius: 5px;
        overflow: hidden;
    }
    #card .input-group .input-group-addon{
        padding: 15px 20px;
        background-color: #d13f2d;
        color: #f3f3f3;
    }
    #card .input-group .form-control{
        padding: 15px 10px;
        display: inherit;
        background-color: #f2f2f2;
        border-color: #f2f2f2;
        box-shadow: none;
    }
    .jumbotron{
        background-color: #f2f2f2;
        margin: 1.5em 0;
        padding: 2em 0;
    }
    .card-image{ margin-top: 10px; }
    .stats-footer{ margin-bottom: 30px; }
    .hp{ font-size: 30px; font-weight: bolder; vertical-align: top; margin: 0 2px; }
    .right .energy{ margin-top: 8px; }
    .panel-body { line-height: 180%; }
    .break{ transform:rotate(90deg); }
    @media (min-width: 992px) {
        .card-image img{width: 80%;}
    }
    .legend{ transform:rotate(90deg); overflow: auto; margin: 56px -50px 30px; }
    .legend img{ float: left; width: 50%; }
    .-mob-share-ui-button{ width: 30%; margin: 0 auto; padding:.3em !important; border-radius: 5px; }
    .-mob-share-ui .-mob-share-close{ background-color:transparent !important; right: 20px; top: -6px; width: 25px !important; font-size: 27px !important; }
    .panel-heading i{ font-size: 26px; }
</style>
@endsection
@section('script')
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script>
    function loadCarousel(){
        var autoplay = 5000;
        $('.owl-carousel').owlCarousel({
            loop:false,
            stagePadding: 70,
            //nav:true,
            autoplay: autoplay?true:false,
            autoplayTimeout: autoplay,
            autoplaySpeed: 600,
            autoplayHoverPause: true,
            dots:false,
            margin:15,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:3
                },
                1200:{
                    items:4
                }
            }
        });
    }
    $(function(){
        loadCarousel();
    });
</script>
<script id="-mob-share" src="http://f1.webshare.mob.com/code/mob-share.js?appkey=25f9f97e0fa0a"></script>
<script>
mobShare.config( {
    appkey: '25f9f97e0fa0a',
    params: {
        title: '{!! iconFont($info->title) !!}（{{$info->img}}）',
        pic: 'http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}.png',
    },
} );
 
</script>
@endsection


@section('content')
<div id="card" class="container">
    <div class="row">
        @if($info)
        <div class="col-md-3 col-md-offset-1">
            <div class="card-image text-center">
                @if($info->typeClass == 6) 
                    <div class="legend">
                    @foreach ($info->img as $item)
                    <img src="http://p7vlj38y9.bkt.clouddn.com/{{$item->img}}.png" alt="{{$info->title}}">
                    @endforeach
                    </div>
                @else
                <img @if($info->typeClass == 3) class="break" @endif src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}.png" alt="{{$info->title}}">
                @endif
                <br><br>
                <label>插图：<a href="#">{{ $info->illustratorName }}</a></label>
            </div>
            <!--MOB SHARE BEGIN-->
            <div class="-mob-share-ui-button -mob-share-open">分享</div>
            <div class="-mob-share-ui" style="display: none">
                <ul class="-mob-share-list">
                    <li class="-mob-share-weixin"><p>微信</p></li>
                    <li class="-mob-share-weibo"><p>新浪微博</p></li>
                    <li class="-mob-share-qzone"><p>QQ空间</p></li>
                    <li class="-mob-share-qq"><p>QQ好友</p></li>
                    <li class="-mob-share-douban"><p>豆瓣网</p></li>
                    <li class="-mob-share-facebook"><p>Facebook</p></li>
                    <li class="-mob-share-twitter"><p>Twitter</p></li>
                    <li class="-mob-share-pocket"><p>Pocket</p></li>
                    <li class="-mob-share-google"><p>Google+</p></li>
                    <li class="-mob-share-tumblr"><p>Tumblr</p></li>
                    <li class="-mob-share-instapaper"><p>Instapaper</p></li>
                    <li class="-mob-share-linkedin"><p>Linkedin</p></li>
                </ul>
                <div class="-mob-share-close">×</div>
            </div>
            <div class="-mob-share-ui-bg"></div>
            <!--MOB SHARE END-->
            <div id="tab-sharing" class="hide">
                <div class="btn-group social-list social-likes social-likes_visible" data-counters="no">
                    <span class="btn btn-default social-likes__widget social-likes__widget_facebook" title="Share link on Facebook">
                        <span class="social-likes__button social-likes__button_facebook">
                            <span class="social-likes__icon social-likes__icon_facebook"></span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel top">
                <div class="panel-heading">
                    @if($info->pmId)
                    {!! pokemonIcon($info->pmId) !!}
                    @endif
                    {!! contentEnergy($info->title) !!}
                    @if($info->lv)
                    <span>
                        <small>Lv.</small>{{$info->lv}}
                    </span>
                    @endif

                    
                </div>
                <div class="panel-content">
                    <div class="left">
                        <label>
                            @if($info->plasma)<span class="label label-primary pull-left" style="margin-top:4px; margin-right:10px;">{{ trans('website.Plasma') }}</span>@endif
                            {{$info->tc}}@if($info->ub)&nbsp;-&nbsp;{{ trans('website.UltraBeast') }} @endif
                        </label>
                        @if($info->evolve)
                        <div>
                          进化自：<a href="#">{{$info->evolve}}</a>
                        </div>
                        @endif
                    </div>
                    
                    <span class="right">
                        @if($info->hp)<small>HP</small><span class="hp">{{ $info->hp }}</span>@endif<div class="pull-right">
                        @if($info->energy) {!! energy($info->energy) !!} @endif
                        </div>
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
            @if ($info->typeClass == 14)
                <div class="input-group">
                    <span class="input-group-addon">支援卡</span>
                    <p class="form-control">{{ trans('website.ruleSupport') }}</p>
                </div>
            @endif
            @if ($info->typeClass == 15)
                <div class="input-group">
                    <span class="input-group-addon">{{ trans('website.ruleToolTitle') }}</span>
                    <p class="form-control">{{ trans('website.ruleTool') }}</p>
                </div>
            @endif
            @if ($info->typeClass == 12)
                <div class="input-group">
                    <span class="input-group-addon">{{ trans('website.ruleItemTitle') }}</span>
                    <p class="form-control">{{ trans('website.ruleItem') }}</p>
                </div>
            @endif
            @if ($info->typeClass == 13)
                <div class="input-group">
                    <span class="input-group-addon">{{ trans('website.ruleStadiumTitle') }}</span>
                    <p class="form-control">{{ trans('website.ruleStadium') }}</p>
                </div>
            @endif
            @if($rule1)
                @foreach ($rule1 as $item)
                <div class="input-group">
                    <span class="input-group-addon">{!! $item->title !!}</span>
                    <p class="form-control">
                    @if($info->typeClass == 3 || $item->id == 4 || $item->id == 10) 
                    {!! contentRule($item->content, $info->title) !!}
                    @elseif($info->typeClass == 6) 
                    {{LEGEND($item->content, $info->title, $abilitys->exObject)}}
                    @elseif($info->typeClass == 8) 
                    {!! contentRule($item->content, $abilitys->exObject) !!}
                    @else
                    {!! $item->content !!}
                    @endif
                    </p>
                </div>
                @endforeach
            @endif
            @if($rule2)
                @foreach ($rule2 as $item)
                <div class="input-group">
                    <span class="input-group-addon">{!! $item->title !!}</span>
                    <p class="form-control">
                    @if($info->typeClass == 3 || $item->id == 4) 
                    {!! contentRule($item->content, $info->title) !!}
                    @else
                    {!! $item->content !!}
                    @endif
                    </p>
                </div>
                @endforeach
            @endif
            @if($abilitys)
            <div class="abilitys">
                @if($abilitys->bodyName)
                <div class="panel">
                  <h3 class="panel-heading">
                    <span class="label label-green">{{ trans('website.pokeBody') }}</span>
                    {{ $abilitys->bodyName }}
                  </h3>
                  <div class="panel-body">
                    {!! contentEnergy($abilitys->bodyContent) !!}
                  </div>
                </div>
                @endif
                @if($abilitys->abilityName)
                <div class="panel">
                  <h3 class="panel-heading">
                    @if($info->pokePower)
                    <span class="label">特殊能力</span>
                    @else
                    <span class="label">特性</span>
                    @endif
                    {{ $abilitys->abilityName }}
                  </h3>
                  <div class="panel-body">
                    {!! contentEnergy($abilitys->abilityContent) !!}
                  </div>
                </div>
                @endif
            </div>
            @endif
            @if($power)
              <div class="power">
                @foreach ($power as $item)
                <div class="panel">
                    @if($item->title)
                    <h3 class="panel-heading">
                        <span>{!! energy($item->cost) !!}</span>&nbsp;&nbsp;&nbsp;{{ $item->title }}<span class="pull-right">{{$item->damage}}</span>
                    </h3>
                    @endif
                    <div class="panel-body">
                        {!! contentEnergy($item->content) !!}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @if($info->type == 1)
            <div class="jumbotron">
                <div class="row text-center">
                    <div class="col-xs-4">
                        <label>{{ trans('website.weakness') }}</label>
                        <div class="rwbox">{!! statLoad($info->weakness) !!}</div>
                    </div>
                    <div class="col-xs-4">
                        <label>{{ trans('website.resistance') }}</label>
                        <div class="rwbox">{!! statLoad($info->resistance) !!}</div>
                    </div>
                    <div class="col-xs-4">
                        <label>{{ trans('website.retreat') }}</label>
                        <div class="energy-list">{!! statLoad($info->retreat) !!}</div>
                    </div>
                </div>
            </div>
            @endif
            <div class="stats-footer">
                <h3>
                    <i class="icon-symbol symbol-XY11"></i>
                    <a href="#">{{$info->cate}}</a>
                </h3>
                <span>{{$info->symbol}} {{$info->pkmId}}</span>
            </div>
            @if($info->type == 1 && $relateds)
            <div class="owl-carousel owl-theme">
                @foreach ($relateds as $item)
                <a href="/card/{{ $item->img }}" target="_blank" class="angled-img">
                    <div class="img">
                        <img src="http://p7vlj38y9.bkt.clouddn.com/{{$item->img}}_thumb.jpg" alt="{{$item->title}}" />
                    </div>
                    <div class="text-center">
                        <h5>{{$item->title}}</h5>
                        <h5>{{$item->symbol}} {{$item->pkmId}}</h5>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @else
        {{ trans('website.noCards') }}
        @endif
    </div>
</div>
@endsection
