@extends('layouts.shop')

@section('title', '订单记录')

@section('content')
<div class="container">
    <div class="weui-panel__bd orderList">
    @if(count($list) > 0)
    @foreach ($list as $order)
        <a href="order/{{$order->order_id}}" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__hd">
                <img class="weui-media-box__thumb" src="{{ Config::get('resource.shop') }}{{ $order->thumb }}.jpg" alt="">
            </div>
            <div class="weui-media-box__bd">
                <span class="pull-right bonus">{{ $order->money }}积分</span>
                <h4 class="weui-media-box__title">{{$order->title}}</h4>
                <p class="weui-media-box__desc">
                    @if ($order->status === 0)
                        <span class="label label-danger">已取消</span>
                    @elseif ($order->status === 1)
                        <span class="label label-warning">未支付</span>
                    @elseif ($order->status === 2)
                        <span class="label label-info">等待发货</span>
                    @elseif ($order->status === 3)
                        <span class="label label-success">已完成</span>
                    @endif
                </p>
            </div>
        </a>
    @endforeach
    @else
    <center>您还没有任何订单哦！</center>
    <center>
        <a href="/shop" class="btn btn-warning">返回积分商店</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="/userCenter" class="btn btn-warning">返回个人中心</a>
    </center>
    @endif
    </div>
</div>
@endsection