@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>卡牌列表-精灵宝可梦卡牌中文网</title>
@endsection
@section('style')
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
        });
    });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="nav" style="padding:0 15px; margin-bottom:30px;">
            <div id="change" class="btn-group pull-right" role="group">
              <button type="button" class="btn btn-default btn-primary" data-tab="thumb"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></button>
              <button type="button" class="btn btn-default" data-tab="table"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></button>
            </div>
        </div>
        
        <div class="tab-content">
            <div id="thumb" role="tabpanel" class="tab-pane active">
                @foreach ($list as $item)
                <div class="col-xs-6 col-md-3">
                    <a href="/card/{{ $item->img }}" class="thumbnail" target="_blank">
                        <img src="http://p7vlj38y9.bkt.clouddn.com/{{$item->img}}_thumb.jpg" alt="...">
                        <div class="caption">
                            <div class="text-warning">{{ $item->title }}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div id="table" role="tabpanel" class="tab-pane">
                <table class="table table-bordered table-hover">
                    <tr><th>编号</th><th>卡片名</th><th>卡包</th><th>类型</th><th>属性</th><th>HP</th></tr>
                @foreach ($list as $item)
                    <tr>
                        <td>
                            {{ $item->pkmId }}
                        </td>
                        <td>
                            <a href="/card/{{ $item->img }}" target="_blank">{{ $item->title }}</a>
                        </td>
                        <td>
                            {{ $item->cate }}
                        </td>
                        <td>
                            {{ $item->tc }}
                        </td>
                        <td>
                            {{ $item->energyName }}
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
    {{ $list->links() }}
</div>
@endsection
