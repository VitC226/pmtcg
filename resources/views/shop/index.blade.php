@extends('layouts.app')

@section('title', '积分商店')

@section('content')
<div class="container shop">
    <br>
    <div class="row">
    @if(count($list) > 0)
        @foreach ($list as $item)
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="..." alt="...">
                <div class="caption">
                    <h5><a href="/shop/{{ $item->id }}">{{ $item->title }}</a></h5>
                    <p>价格：{{ $item->price }}积分</p>
                    <p><a href="#" class="btn btn-primary" role="button">Button</a>
                </div>
            </div>
        </div>
        @endforeach
    @else
    <br><br>
    <p>现在还没有可以兑换的商品哦</p>
    <a href="/userCenter">返回个人中心</a>
    @endif
    </div>
</div>
@endsection