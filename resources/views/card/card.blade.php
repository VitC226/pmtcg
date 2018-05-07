@extends('layouts.app')
@section('style')
<style>
    *{ font-size: 16px; }
    #card .panel{
        border: none;
        margin-bottom: 60px;
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

    #card .label {
        float: left;
        padding: .5em .6em .4em;
        margin-right: 16px;
        background-color: #d13f2d;
    }

    #card .input-group{
        margin-bottom: 50px;
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
    .stats-footer{
        margin-bottom: 80px;
    }
</style>
@endsection
@section('content')
<div id="card" class="container">
    <div class="row">
        @if($info)
        <div class="col-md-4">
            <div class="card-image text-center">
                <img src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}.pn1g" alt="{{$info->title}}">
                <br><br>
                <label>插图：<a href="#">{{ $info->illustratorName }}</a></label>
            </div>
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
        <div class="col-md-8">
            <div class="panel top">
                <div class="panel-heading">
                    <span class="pokemon-icon pokemon-icon-{{ $info->pmId }}" title="{{ $info->pmId }}"></span>
                    {{$info->title}}
                    @if($info->lv)
                    <span class="pull-right">
                        <small>Lv.</small>
                        &nbsp;{{$info->lv}}&nbsp;
                    </span>
                    @endif
                </div>
                <div class="panel-content">
                    <div class="left">
                        <label>{{$info->tc}}</label>
                        @if($info->evolve)
                        <div>
                          进化自：<a href="#">{{$info->evolve}}</a>
                        </div>
                        @endif
                    </div>
                    
                    <span class="right">
                        @if($info->hp)
                        <small>HP</small>&nbsp;{{ $info->hp }}&nbsp;
                        @endif
                        @if($info->energyName)
                        {!! energy($info->energyName) !!}
                        @endif
                    </span>
                </div>
            </div>
            <div class="clearfix"></div>
            @if($rule)
                @foreach ($rule as $item)
                <div class="input-group">
                  <span class="input-group-addon">{{$item->title}}</span>
                  <p class="form-control">{{$item->content}}</p>
                </div>
                @endforeach
            @endif
            @if($abilitys)
            <div class="abilitys">
                @if($abilitys->abilityName)
                <div class="panel">
                  <h3 class="panel-heading">
                    <span class="label">特性</span>
                    {{ $abilitys->abilityName }}
                  </h3>
                  <div class="panel-body">
                    {{ $abilitys->abilityContent }}
                  </div>
                </div>
                @endif
            </div>
            @endif
            @if($power)
              <div class="power">
                @foreach ($power as $item)
                <div class="panel">
                    <h3 class="panel-heading">
                        <span>{!! energy($item->cost) !!}</span>
                        {{ $item->title }}
                        <span class="pull-right">{{$item->damage}}</span>
                    </h3>
                    <div class="panel-body">
                        {{ $item->content }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="jumbotron">
            @if($info->hp)
                <div class="row text-center">
                    <div class="col-xs-4">
                        <label>弱点</label>
                        <div class="rwbox">{!! statLoad($info->weakness) !!}</div>
                    </div>
                    <div class="col-xs-4">
                        <label>抗性</label>
                        <div class="rwbox">{!! statLoad($info->resistance) !!}</div>
                    </div>
                    <div class="col-xs-4">
                        <label>撤退</label>
                        <div class="energy-list">{!! statLoad($info->resistance) !!}</div>
                    </div>
                </div>
            @endif
            </div>
            <div class="stats-footer">
                <h3>
                    <i class="icon-symbol symbol-XY11"></i>
                    <a href="#">{{$info->cate}}</a>
                </h3>
                <span>{{$info->pkmId}} {{$info->rarity}}</span>
            </div>
        </div>
        @else
        找不到卡片
        @endif
    </div>
</div>
@endsection
