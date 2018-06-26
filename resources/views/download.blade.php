@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网,游戏下载,客户端下载,Apk下载">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>游戏下载-精灵宝可梦卡牌中文网</title>
@endsection

@section('content')
<div class="container">
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="font_family icon-windows"></i> Windows</h3>
                </div>
                <div class="panel-body">
                    <a href="https://tcgo-installer.s3.amazonaws.com/PokemonInstaller.msi" target="_blank" class="btn btn-primary pull-right" onclick='_czc.push(["_trackEvent", "游戏", "下载", "PC"]);'>{{trans('website.download_button')}}</a>
                    <p><span class="text-muted">{{trans('website.download_version')}}</span>2.52.0.3746</p>
                    <p><span class="text-muted">{{trans('website.download_update')}}</span>2018-01-05</p>
                    <p><span class="text-muted">{{trans('website.download_file')}}</span>298 MB</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="font_family icon-iphone"></i> iPad</h3>
                </div>
                <div class="panel-body">
                    <a href="https://itunes.apple.com/us/app/pokemon-tcg-online/id841098932?mt=8" target="_blank" class="btn btn-primary pull-right" onclick='_czc.push(["_trackEvent", "游戏", "下载", "iPad"]);'>{{trans('website.download_button')}}</a>
                    <p><span class="text-muted">{{trans('website.download_version')}}</span>2.52.0.3746</p>
                    <p><span class="text-muted">{{trans('website.download_update')}}</span>2018-01-05</p>
                    <p><span class="text-muted">{{trans('website.download_file')}}</span>385 MB</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="font_family icon-android"></i> Android</h3>
                </div>
                <div class="panel-body">
                    <a href="https://pan.baidu.com/s/1kKcHsuwC6BRIhebwy4ezzQ" target="_blank" class="btn btn-primary pull-right" onclick='_czc.push(["_trackEvent", "游戏", "下载", "Android"]);'>{{trans('website.download_button')}}</a>
                    <p><span class="text-muted">{{trans('website.download_version')}}</span>2.52.0.3746</p>
                    <p><span class="text-muted">{{trans('website.download_update')}}</span>2018-01-05</p>
                    <p><span class="text-muted">{{trans('website.download_file')}}</span>26.2 MB</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="font_family icon-mac"></i> Mac</h3>
                </div>
                <div class="panel-body">
                    <a href="https://tcgo-installer.s3.amazonaws.com/PokemonInstaller_Mac.dmg" target="_blank" class="btn btn-primary pull-right" onclick='_czc.push(["_trackEvent", "游戏", "下载", "Mac"]);'>{{trans('website.download_button')}}</a>
                    <p><span class="text-muted">{{trans('website.download_version')}}</span>2.52.0.3746</p>
                    <p><span class="text-muted">{{trans('website.download_update')}}</span>2018-01-05</p>
                    <p><span class="text-muted">{{trans('website.download_file')}}</span>291 MB</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection