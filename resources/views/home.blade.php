@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>精灵宝可梦卡牌中文网</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
    @foreach ($list as $item)
        <a href="./database/{{ $item->symbol }}" class="col-xs-6 col-md-3">
            <div class="thumbnail">
                <img src="expansion-{{ $item->symbol }}.png" alt="{{ $item->name }}">
                <div class="caption">
                    <h5>{{ $item->name }}</h5>
                    <p><small>{{ $item->releaseDate }}</small></p>
                </div>
            </div>
        </a>
    @endforeach
    </div>
</div>
@endsection
