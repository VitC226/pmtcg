@extends('layouts.app')

@section('title', '商品详细')

@section('style')
<style>
    .list-group{ max-height:360px; overflow-y:auto; margin: 8px 0; }
    .weui-gallery__del{ font-size: 30px; color: #fff; }
</style>
@endsection

@section('script')
<script>
    $(function(){
        $("#confrim").on("click",function(){
            $.post('/createOrder',{
                itemid:$("#itemId").val(),
                count:$("#count").val(),
            },function(data){
                if(data.status == 0){
                    $(".modal").hide().removeClass("in");
                    alert(data.msg);
                }
                else{
                    window.location.href="/order/"+data.order;
                }
            });
        });
        $("#pay").on("click",function(){
            $(".modal").show().addClass("in");
        });
        $(".close,#cancel").on("click",function(){
            $(".modal").hide().removeClass("in");
        });

        if($(".list-group").length>0){
            $.post('/getSkin',{
                price:$(".list-group").data("price")
            },function(data){
                var html = "";
                var l = data.list;
                for(var i=0;i<l.length;i++){
                    html+='<a href="javascript:;" class="list-group-item" data-img="{{ Config::get('resource.shop') }}'+ l[i].image +'.jpg"><img class="list-img" src="{{ Config::get('resource.shop') }}'+ l[i].thumb +'.jpg">'+ l[i].title +'</a>';
                }
                $(".list-group").html(html);
            });

            $(".list-group").on("click",".list-group-item",function(){
                $(".weui-gallery__img").css("background-image","url('"+$(this).data('img')+"')");
                $(".weui-gallery").show();
            });

            $(".weui-gallery__opr").on("click",function(){
                $(".weui-gallery").hide();
            });
        }
    });
</script>
@endsection

@section('content')
<div class="weui-gallery">
    <span class="weui-gallery__img"></span>
    <div class="weui-gallery__opr">
        <a href="javascript:" class="weui-gallery__del">×</a>
    </div>
</div>
<div class="content">
    <input type="hidden" id="itemId" value="{{ $item->id }}">
    <input type="hidden" id="count" value="1">
    <div class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"><span>&times;</span></button>
                    <h4 class="modal-title">确认兑换</h4>
                </div>
                <div class="modal-body">
                <p>兑换该商品将花费您<span class="text-warning">{{$item->price}}</span>积分，确认兑换？</p>
                </div>
                <div class="modal-footer">
                  <button type="button" id="cancel" class="btn btn-default">再想想</button>
                  <button type="button" id="confrim" class="btn btn-warning">确定</button>
                </div>
            </div>
        </div>
    </div>
    <div class="carousel slide">
        <div class="carousel-inner">
            <div class="item active">
                <img src="{{ Config::get('resource.shop') }}{{ $item->image }}.jpg" />
                <div class="carousel-caption">{{ $item->title }}</div>
            </div>
        </div>
    </div>
    <article class="weui-article">
        @if($item->isShop == 1)
        <h5><b><span class="text-warning" style="font-size:23px">{{ $item->price }}</span>&nbsp;积分</b><!--  <span class="text-muted pull-right">已兑换：1111</span> --></h5>
        <hr>
        @endif
        @if(isset($item->content))
        <section>
            <h4 class="title"><b>商品简介：</b></h4>
            <section>
                {!! $item->content !!}
            </section>
        </section>
        @endif
        @if(isset($item->instruction))
        <section>
            <h4 class="title"><b>兑换须知：</b></h4>
            <section>
                {!! $item->instruction !!}
            </section>
        </section>
        @endif
    </article>
    <div class="weui-tabbar">
        <div style="width:100%; padding:15px;">
            @if($item->isShop == 1)
                @if(isset($item->inventory) && $item->inventory <= 0)
            <button class="btn btn-warning btn-lg btn-block btn-circle" disabled="disabled">已经卖光了</button>
                @else
            <button class="btn btn-warning btn-lg btn-block btn-circle" id="pay">立即兑换</button>
                @endif
            @else
            <button class="btn btn-warning btn-lg btn-block btn-circle" disabled="disabled">不可兑换</button>
            @endif
        </div>
    </div>
</div>
@endsection