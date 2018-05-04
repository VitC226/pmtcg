@extends('layouts.admin')
@section('script')
<script>
  $(function(){
      //url: "http://p7vlj38y9.bkt.clouddn.com/BW10_1.png",
      $(".card-image").on("mouseenter",function(){
        $(this).css("opacity",1);
      }).on("mouseleave",function(){
        $(this).css("opacity",0);
      });
    $('img#mainImg').on('error', function() {
      $.post('loadImg',{
          cid:$("#cardId").val()
      },function(data){
        console.log(data);
      });
    });

    $(".box").on("click","button",function(){
      var inputs = $(this).parent().next().find("input");
      var li = $(this).parent().next().find("li").eq(0);
      var key = li.data("value");
      if (key.indexOf(" ") == 0){ key="^"+key; }
      $.post('translate',{
          tid:$(this).parent().data("id"),
          rule:inputs.eq(0).val(),
          php:inputs.eq(1).val(),
          text:inputs.eq(2).val(),
          key:key
      }, function(data){
          console.log(data);
          
          if(data.address && data.address.length > 0){
              var html = "";
              for(var item of data.address){
                  html+=item+"\n";
              }
              $("#input2").val(html);
          }
      });
    });

    $(".btn-power").on("click",function(){
      $.post('translateSave',{
          pid:$(this).data("id"),
          text:$(this).prev().val()
      }, function(data){
          console.log(data);
      });
    });
  });
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @if($info)
        <input type="hidden" id="cardId" value="{{$info->cardId}}">
        <div class="col-md-4">
            <div class="card-image" style="opacity:0;">
                <img id="mainImg" src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}.png">
                <img src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}_thumb.jpg" style="width: 160px;">
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
                <div id="ability-{{ $abilitys->abilityId }}" class="panel panel-default">
                  <div class="panel-body">
                    <div class="form-group">
                        <label><span class="label label-primary">特性</span>{{ $abilitys->abilityName }}&nbsp;/&nbsp;{{ $abilitys->abilityNameEn }}</label>
                        <input type="text" class="form-control" value="{{ $abilitys->abilityName }}">
                    </div>
                    <div class="form-group">
                        <label>{{ $abilitys->abilityContent }}</label>
                        <label>{{ $abilitys->abilityContentEn }}</label>
                        <textarea rows="5" class="form-control">{{ $abilitys->abilityContent }}</textarea>
                        <button type="button" data-id="{{$abilitys->abilityContentId}}" class="btn btn-info pull-right btn-xs btn-power">保存</button>
                    </div>
                    {!! analysis($abilitys->abilityContentEn) !!}
                  </div>
                </div>
                @endif
            </div>
            @endif
            @if($power)
              <div class="power">
                @foreach ($power as $item)
                <div id="power-{{$item->id}}" class="panel panel-info">
                    <div class="panel-body">
                      
                      <div class="form-group">
                        <label>{{ $item->title }}&nbsp;/&nbsp;{{ $item->title_en }}</label>
                        <input type="text" class="form-control" value="{{ $item->title }}">
                      </div>

                      <div class="form-group">
                        <label>{{ $item->content }}</label>
                        <label>{{ $item->content_en }}</label>
                        <textarea rows="5" class="form-control">{{ $item->content }}</textarea>
                        <button type="button" data-id="{{$item->cId}}" class="btn btn-info pull-right btn-xs btn-power">保存</button>
                      </div>
                      
                      {!! analysis($item->content_en) !!}
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <a href="{{ url('admin/cardEdit', [$item->cardId+1]) }}" class="btn btn-primary btn-lg">下一个</a>
        </div>
        @else
        找不到卡片
        @endif
        {!! hello() !!}
    </div>
</div>
@endsection
