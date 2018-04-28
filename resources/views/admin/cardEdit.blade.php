@extends('layouts.admin')

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
            </h2>
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
                    <div class="panel-body">
                      
                      <div class="form-group">
                        <label>{{ $item->title }}&nbsp;/&nbsp;{{ $item->title_en }}</label>
                        <input type="text" class="form-control" value="{{ $item->title }}">
                      </div>

                      <div class="form-group">
                        <label>{{ $item->content }}</label>
                        <label>{{ $item->content_en }}</label>
                        <textarea rows="5" class="form-control">{{ $item->content }}</textarea>
                      </div>
                      
                      {!! analysis($item->content) !!}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @else
        找不到卡片
        @endif
    </div>
</div>
@endsection
