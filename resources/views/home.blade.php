@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>精灵宝可梦卡牌中文网</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
    <?php $i = ""; $now = "1"; $count=0; ?>
    @foreach ($list as $item)
        <?php 
        $now = $item->series;
        
        if($now != $i){
            $i = $now;
            $count=0;
            echo '<div class="col-xs-12"><ol class="breadcrumb"><li>'.$i.'系列</li><a href="/search" class="pull-right">卡片搜索</a></ol></div>';
        }
        ?>
        <a href="./database/{{ $item->symbol }}" class="col-xs-6 col-md-3" style="margin-bottom:20px;">
            <div class="thumbnail">
                <img src="http://p86juraw2.bkt.clouddn.com/expansion-{{ $item->symbol }}.png" alt="{{ $item->name }}">
                <div class="caption">
                    <h5>{{ $item->name }}</h5>
                    <p><small>{{ $item->releaseDate }}</small></p>
                </div>
            </div>
        </a>
        <?php $count++; if($count%2==0) echo '<div class="clearfix visible-xs-block"></div>'; if($count%4==0) echo '<div class="clearfix visible-md-block"></div>'; ?>
        
    @endforeach
    </div>
</div>
@endsection
