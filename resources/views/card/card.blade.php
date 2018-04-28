@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if($info)
        <div class="col-md-4">
            <div class="card-image">
                <img ng-src="http://7xqnsl.com1.z0.glb.clouddn.com/{{$info->img}}.png" style="width: 245px; height: 342px">
            </div>
            <label>插图：<a href="#">{{ $info->illustratorName }}</a></label>
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
            <h2 class="mt-0">
                <span class="pokemon-icon pokemon-icon-{{ $info->pmId }}" title="{{ $info->pmId }}"></span>
                {{$info->title}}
                @if($info->lv)
                <span class="pull-right">
                    <small>Lv.</small>
                    &nbsp;{{$info->lv}}&nbsp;
                </span>
                @endif
            </h2>
            <h2 class="mt-0">
                <label>{{$info->tc}}</label>
                @if($info->evolve)
                <div>
                  进化自：<a href="#">{{$info->evolve}}</a>
                </div>
                @endif
                <span class="pull-right">
                    @if($info->hp)
                    <small>HP</small>&nbsp;{{ $info->hp }}&nbsp;
                    @endif
                    @if($info->energyName)
                    {!! energy($info->energyName) !!}
                    @endif
                </span>
            </h2>
            <div class="clearfix"></div>
            @if($rule)
                @foreach ($rule as $item)
                <div class="alert alert-warning" role="alert">{{$item->title}}：{{$item->content}}</div>
                @endforeach
            @endif
            @if($abilitys)
            <div class="abilitys">
                @if($abilitys->abilityName)
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <span class="label label-primary">特性</span>
                    {{ $abilitys->abilityName }}
                  </div>
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
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <span>{!! energy($item->cost) !!}</span>
                        {{ $item->title }}
                        <span class="pull-right">{{$item->damage}}</span>
                    </div>
                    <div class="panel-body">
                        {{ $item->content }}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            @if($info->hp)
            <div class="row text-center">
                <div class="col-xs-4">
                    <label>弱点</label>
                    <div class="rwbox">{!! energy($info->weakness) !!}</div>
                </div>
                <div class="col-xs-4">
                    <label>抗性</label>
                    <div class="rwbox">{!! energy($info->resistance) !!}</div>
                </div>
                <div class="col-xs-4">
                    <label>撤退</label>
                    <div class="energy-list">{!! energy($info->resistance) !!}</div>
                </div>
            </div>
            @endif
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
