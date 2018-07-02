
<div class="container">
  <div class="row">
    @if($info)
    <input type="hidden" id="cardId" value="{{$info->cardId}}">
    <div class="col-md-4">
      <a href="/card/{{$info->img}}" target="_blank">{{$info->img}}</a>
      <div class="card-image" style="opacity:0;">
        <img id="mainImg" src="http://p7vlj38y9.bkt.clouddn.com/{{$info->
        img}}.png">
        <img src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}_thumb.jpg" style="width: 160px;"></div>
      <div class="sr-only">
        <img id="mainImg" src="http://p7vlj38y9.bkt.clouddn.com/{{$info->img}}.png"></div>
    </div>
    <div class="col-md-8">
      <div class="panel-body">
        <div class="input-group">
          <span id="name_tran" class="input-group-addon">{{ checkName($info->title) }}</span>
          <input type="text" id="input_name_{{$info->
          titleId}}" class="form-control" type="text" class="form-control" value="{{$info->title}}">
          <span class="input-group-btn">
            <button class="btn btn-default btn-power" type="button" data-type="name" data-id="{{$info->titleId}}">保存</button>
          </span>
        </div>
      </div>
      <div class="abilitys">
      @if($abilitys && $abilitys->bodyName)
        <div id="ability-{{ $abilitys->abilityId }}" class="panel panel-default">
          <div class="panel-body">
            <label>
              <span class="label label-primary">特殊体质</span>
              {{ $abilitys->bodyName }}&nbsp;/&nbsp;{{ $abilitys->bodyNameEn }}
            </label>
            <div class="input-group">
              <input id="input_title_{{$abilitys->bodyId}}" type="text" class="form-control" value="{{ $abilitys->bodyName }}">
              <span class="input-group-btn">
                <button class="btn btn-default btn-power" type="button" data-type="title" data-id="{{$abilitys->bodyId}}">保存</button>
              </span>
            </div>
            @if($abilitys->bodyName != "" && $abilitys->bodyName == $abilitys->bodyNameEn)
            <iframe src="https://wiki.52poke.com/index.php?search={{$abilitys->
              bodyName}}" frameborder="0" style="width:100%; height:300px;">
            </iframe>
            @endif
            <div class="form-group">
              <label>{{ $abilitys->bodyContent }}</label>
              <label>{{ $abilitys->bodyContentEn }}</label>
              <textarea id="input_content_{{$abilitys->bodyContentId}}" rows="5" class="form-control">{{ $abilitys->bodyContent }}
              </textarea>
              <button type="button" data-type="content" data-id="{{$abilitys->bodyContentId}}" class="btn btn-info pull-right btn-xs btn-power">保存
              </button>
            </div>
            <div class="{{ ($abilitys->contentStatus2 != 1)?'':'hide' }}">
                      {!! analysis($abilitys->bodyContentEn) !!}
            </div>
          </div>
        </div>
      @endif
      @if($abilitys && $abilitys->abilityName)
        <div id="ability-{{ $abilitys->
          abilityId }}" class="panel panel-default">
          <div class="panel-body">
            <label>
              <span class="label label-primary">特性</span>
              {{ $abilitys->abilityName }}&nbsp;/&nbsp;{{ $abilitys->abilityNameEn }}
            </label>
            <div class="input-group">
              <input id="input_title_{{$abilitys->
              abilityId}}" type="text" class="form-control" value="{{ $abilitys->abilityName }}">
              <span class="input-group-btn">
                <button class="btn btn-default btn-power" type="button" data-type="title" data-id="{{$abilitys->abilityId}}">保存</button>
              </span>
            </div>
            @if($abilitys->abilityName != "" && $abilitys->abilityName == $abilitys->abilityNameEn)
            <iframe src="https://wiki.52poke.com/index.php?search={{$abilitys->
              abilityName}}" frameborder="0" style="width:100%; height:300px;">
            </iframe>
            @endif
            <div class="form-group">
              <label>{{ $abilitys->abilityContent }}</label>
              <label>{{ $abilitys->abilityContentEn }}</label>
              <textarea id="input_content_{{$abilitys->
                abilityContentId}}" rows="5" class="form-control">{{ $abilitys->abilityContent }}
              </textarea>
              <button type="button" data-type="content" data-id="{{$abilitys->
                abilityContentId}}" class="btn btn-info pull-right btn-xs btn-power">保存
              </button>
            </div>
            <div class="{{ ($abilitys->
              contentStatus != 1)?'':'hide' }}">
                      {!! analysis($abilitys->abilityContentEn) !!}
            </div>
          </div>
        </div>
      @endif
      </div>
      <div class="power">
            @if($power && count($power) != 0)
        @foreach ($power as $item)
        <div id="power-{{$item->
          id}}" class="panel panel-info">
          <div class="panel-body">

            <div class="form-group">
              <label>{{ $item->title }}&nbsp;/&nbsp;{{ $item->title_en }}</label>
              @if($item->title != "" && $item->title == $item->title_en)
              <iframe src="https://wiki.52poke.com/index.php?search={{$item->title}}" frameborder="0" style="width:100%; height:300px;"></iframe>
              @endif
              <div class="input-group">
                <input id="input_title_{{$item->
                tId}}" type="text" class="form-control" value="{{ $item->title }}">
                <span class="input-group-btn">
                  <button class="btn btn-default btn-power" type="button" data-type="title" data-id="{{$item->tId}}">保存</button>
                </span>
              </div>
            </div>
            @if($item->content)
            <div class="form-group">
              <label>{{ $item->content }}</label>
              <label>{{ $item->content_en }}</label>
              <textarea id="input_content_{{$item->cId}}" rows="5" class="form-control">{{ $item->content }}</textarea>
              <button type="button" data-type="content" data-id="{{$item->cId}}" class="btn btn-info pull-right btn-xs btn-power">保存</button>
            </div>
            <div class="{{ ($item->
              contentStatus != 1)?'':'hide' }}">
                        {!! analysis($item->content_en) !!}
            </div>
            @endif
          </div>
        </div>
        @endforeach
      @endif
      </div>
      <a href="{{ url('admin/cardEdit', [$info->cardId+1]) }}" class="btn btn-primary btn-lg">下一个</a>
      <div class="pull-right">
        <button type="button" class="btn btn-danger btn-ab">新建特性</button>
        <button type="button" class="btn btn-info btn-po">新建技能</button>
      </div>
    </div>
    @else
        找不到卡片
        @endif
        {!! hello() !!}
        {!! test() !!}
  </div>
</div>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  });
</script>
<script>
  $(function(){
      //url: "http://p7vlj38y9.bkt.clouddn.com/BW10_1.png",
      $(".card-image").on("mouseenter",function(){
        $(this).css("opacity",1);
      }).on("mouseleave",function(){
        $(this).css("opacity",0);
      });
    // $('img#mainImg').on('load', function() {
    //   $.post('loadImg',{
    //       cid:$("#cardId").val()
    //   },function(data){
    //     console.log(data);
    //   });
    // });

    $(".box").on("click","button",function(){
      var inputs = $(this).parent().next().find("input");
      var li = $(this).parent().next().find("li").eq(0);
      var key = li.data("value");
      if (key.indexOf(" ") == 0){ key="^"+key; }
      $.post('/mm/cardEdit/translate',{
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
      let type = $(this).data("type");
      let id = $(this).data("id");
      $.post('/mm/cardEdit/translateSave',{
          type:type,
          pid:id,
          text:$("#input_"+type+"_"+id).val()
      }, function(data){
          console.log(data);
      });
    });

    $(".btn-ab").on("click",function(){
      $(".abilitys").append('<div class="panel panel-default"><div class="panel-body"><label><span class="label label-primary">特性</span><input type="checkbox" class="pokeBody">PokeBody</label><input type="text" class="form-control name_en" placeholder="English Name"><textarea rows="5" class="form-control content_en" placeholder="English Content"></textarea></textarea><button type="button" data-type="content" class="btn btn-info pull-right btn-xs btn-new-ab">保存</button></div></div>');
    });

    $(".btn-po").on("click",function(){
      $(".power").append('<div class="panel panel-default"><div class="panel-body"><input type="text" class="form-control name_en" placeholder="English Name"><input type="text" class="form-control cost" placeholder="Cost"><input type="text" class="form-control damage" placeholder="damage"><textarea rows="5" class="form-control content_en" placeholder="English Content"></textarea><button type="button" class="btn btn-info pull-right btn-xs btn-new-po">保存</button></div></div>');
    });

    $(".abilitys").on("click",".btn-new-ab",function(){
      var div = $(this).parent();
      var name = div.find(".name_en").val();
      var content = div.find(".content_en").val();
      var pokeBody = div.find(".pokeBody").is(':checked');
      var ab = (div.find(".pokeBody").is(':checked'))?"pb":"ab";

      
      $.post('/mm/cardEdit/addAbility',{
          cid:$("#cardId").val(),
          ab:ab,
          name:name,
          content:content
      }, function(data){
          console.log(data);
          if(data.result){
            //window.location.reload();
          }
      });
    });

    $(".power").on("click",".btn-new-po",function(){
      var div = $(this).parent();
      var name = div.find(".name_en").val();
      var content = div.find(".content_en").val();
      var cost = div.find(".cost").val();
      var damage = div.find(".damage").val();

      $.post('/mm/cardEdit/addAbility',{
          cid:$("#cardId").val(),
          cost:cost,
          damage:damage,
          name:name,
          content:content
      }, function(data){
          console.log(data);
          if(data.result){
            window.location.reload();
          }
      });
    });

    $("#name_tran").on("click",function(){
      $(this).next().val($(this).text());
    });
  });
</script>