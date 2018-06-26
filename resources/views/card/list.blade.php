@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>卡牌列表-精灵宝可梦卡牌中文网</title>
@endsection
@section('style')
<link href="{{ asset('css/pokemon.css') }}" rel="stylesheet">
<style>
    .thumbnail{
        border:none;
        text-align: center;
    }
</style>
@endsection

@section('script')
<script>
    $(function(){
        $("#change").on("click","button",function(){
            if($(this).hasClass(".btn-primary")) return;
            $("#change .btn-primary").removeClass("btn-primary");
            $(this).addClass("btn-primary");
            $(".tab-pane.active").removeClass("active");
            $("#"+$(this).data("tab")).addClass("active");
            $.get('/tableOrList',{ show: $(this).data("tab") });
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    @if($list->count())
    <div class="row">

        <div class="nav" style="padding:0 15px; margin-bottom:30px;">
            <br>
            <a href="/search" class="btn btn-danger">{{trans('website.search_button')}}</a>
            <div id="change" class="btn-group pull-right" role="group">
              <button type="button" class="btn btn-default {{($thumb != 'table')?'btn-primary':''}}" data-tab="thumb"><i class="font_family icon-img"></i></button>
              <button type="button" class="btn btn-default {{($thumb == 'table')?'btn-primary':''}}" data-tab="table"><i class="font_family icon-list"></i></button>
            </div>
        </div>
        
        <div class="tab-content">
            <div id="thumb" role="tabpanel" class="tab-pane {{($thumb != 'table')?'active':''}}">
                @foreach ($list as $item)
                <div class="col-xs-6 col-md-3">
                    <a href="/card/{{ $item->img }}" class="thumbnail" target="_blank">
                        <img src="http://p7vlj38y9.bkt.clouddn.com/{{$item->img}}_thumb.jpg" alt="{{$item->title}}">
                        <div class="caption">
                            <div class="text-warning">{!! iconFont($item->title) !!}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div id="table" role="tabpanel" class="tab-pane {{($thumb == 'table')?'active':''}}">
                <div class="col-xs-12">
                    <table class="table table-bordered table-hover">
                        <tr><th>{{trans('website.cardNum')}}</th><th>{{trans('website.cardName')}}</th><th>{{trans('website.subcategory')}}</th><th>{{trans('website.cardType')}}</th><th>{{trans('website.cardEnergy')}}</th><th>HP</th></tr>
                    @foreach ($list as $item)
                        <tr>
                            <td>
                                {{ $item->pkmId }}
                            </td>
                            <td>
                                <a href="/card/{{ $item->img }}" target="_blank">{!! iconFont($item->title) !!}</a>
                            </td>
                            <td>
                                {{ $item->cate }}
                            </td>
                            <td>
                                {{ $item->tc }}
                            </td>
                            <td>
                                {!! energy($item->energy) !!}
                            </td>
                            <td>
                                {{ $item->hp }}
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $list->links() }}
    @else
    <h3>没有找到相关卡片！</h3>
    <a href="javascript:window.history.go(-1);">返回上一页</a>
    @endif
</div>
@endsection
