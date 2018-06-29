@extends('layouts.shop')

@section('title', '订单详情')

@section('content')
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    $(function(){
        var clipboard = new Clipboard('.btn');
        clipboard.on('success', function(e) {
            $(e.trigger).addClass("copied");
            setTimeout(clearBtn,2000);
            e.clearSelection();
        });
        function clearBtn(){
            $(".btn.copied").removeClass("copied");
        }
    });
</script>
<div class="content">
    <article class="weui-article">
        {{ $product['img'] }}
        <h1><b>{{ $product['title'] }}</b></h1>
        <h5><b><span class="text-warning">{{$order['money']}}</span>积分</b><!--  <span class="text-muted pull-right">已兑换：1111</span> --></h5>
        <hr>
        <div id="codes">
            @if($product['type'] === 0)
            <div class="alert alert-warning" role="alert">
                <b>代码</b>
                @foreach ($code as $c)
                <p>
                    <div class="input-group">
                        <input id="code{{$c['id']}}" type="text" class="form-control" value="{{$c['code']}}">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-clipboard-target="#code{{$c['id']}}">复制代码</button>
                        </span>
                    </div>
                </p>
                @endforeach
            </div>
            @endif
        </div>
        <section>
            <h4 class="title"><b>商品简介：</b></h4>
            <section>
                <p>
                    多换多得
                </p>
                <p>
                    少换少得
                </p>
        </section>
            <section>
                <h4 class="title"><b>温馨提示：</b></h4>
                <p>
                    买完找客服
                </p>
            </section>
        </section>
    </article>
</div>
@endsection