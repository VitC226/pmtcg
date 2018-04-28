@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        @if($info)
        <div>
          <div class="mainImg">
            <img ion-img-cache ng-src="http://7xqnsl.com1.z0.glb.clouddn.com/{{$info->img}}.png" style="width: 245px; height: 342px">
          </div>
          <div class="header">
            <div class="top">
              <h2>
                <span class="pokemon-icon pokemon-icon-{{$info->pmId}}"></span>
                {{$info->title}}
                @if($info->lv)
                <i> Lv.<font>{{$info->lv}}</font></i>
                @endif
              </h2>
            </div>
            <div class="main">
              <div class="des">
                <label>{{$info->tc}}</label>
                @if($info->lv)
                <div>
                  进化自：<a href="#">{{$info->evolve}}</a>
                </div>
                @endif
              </div>
              @if($info->hp)
              <div class="right">
                <span>HP <font>{{$info->hp}}</font></span>
                <div class="energy-list">{{$info->energyName}}</div>
              </div>
              @endif
            </div>
          </div>

          <div class="middle">
            <div class="list-block">
            @if($abilitys)
              <div>
                <div class="card-item card-rule">
                  <div class="item-content">
                      <div class="item-media item-skew item-rule-"></div>
                      <div class="item-inner">
                        <div class="item-title">{{$abilitys->exId}}</div>
                    </div>
                  </div>
                </div>
                @if($abilitys->abilityName)
                <div class="card-item">
                  <div class="item-content">
                    <div class="item-media item-skew">特性</div>
                    <div class="item-inner">
                      <div class="item-title">{{$abilitys->abilityName}}</div>
                    </div>
                  </div>
                  <div class="card-content-inner">{{$abilitys->abilityContent}}</div>
                </div>
                @endif
              </div>
              @endif
              @if($power)
              <div class="card-item" ng-repeat="item in power">
                @foreach ($power as $item)
                <div class="item-content">
                  <div class="item-media">
                    <div class="energy-list">{{$item->cost}}</div>
                  </div>
                  <div class="item-inner">
                    <div class="item-title">{{$item->title}}</div>
                    <div class="item-after">{{$item->damage}}</div>
                  </div>
                </div>
                <div class="card-content-inner">{{ $item->content }}</div>
                @endforeach
              </div>
              @endif
            </div>
            <div class="bottom">
              <div class="row" ng-if="card.hp">
                <div class="col">
                  <label>弱点</label>
                  <div class="rwbox">{{$info->weakness}}</div>
                </div>
                <div class="col">
                  <label>抗性</label>
                  <div class="rwbox">{{$info->resistance}}</div>
                </div>
                <div class="col">
                  <label>撤退</label>
                  <div class="energy-list">{{$info->resistance}}</div>
                </div>
              </div>
              <div class="stats-footer">
                <h3>
                  <i class="icon-symbol symbol-XY11"></i>
                  <a href="#">{{$info->cate}}</a>
                </h3>
                <span>{{$info->pkmId}} {{$info->rarity}}</span>
              </div>
            </div>
          </div>
        </div>
        @else
        找不到卡片
        @endif
    </div>
</div>
@endsection
