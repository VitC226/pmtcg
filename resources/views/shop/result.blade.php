@extends('layouts.shop')

@section('title', '订单详情')

@section('style')
<style>
    .page__hd{padding:20px}.stamp *{margin:0;padding:0;list-style:none;font-family:Microsoft YaHei,Source Code Pro,Menlo,Consolas,Monaco,monospace}.stamp{position:relative;overflow:hidden;margin:10px auto 20px;padding:0 10px;width:90%;height:75pt}.stamp:before{top:0;right:5px;bottom:0;left:5px;z-index:-1}.stamp:after,.stamp:before{position:absolute;content:''}.stamp:after{top:10px;right:10px;bottom:10px;left:10px;z-index:-2;box-shadow:0 0 20px 1px rgba(0,0,0,.5)}.stamp i{position:absolute;top:45px;left:20%;z-index:1;width:390px;height:190px;background-color:hsla(0,0%,100%,.15);transform:rotate(-30deg)}.stamp .par{padding:9pt 10px;text-align:left}.stamp .par p{position:relative;z-index:2;color:#fff;font-size:1pc;line-height:21px}.stamp .par span{margin-right:5px;color:#fff;font-size:50px;line-height:65px}.stamp .par .sign{position:relative;z-index:2;width:100%;border:none;background-color:transparent;color:hsla(0,0%,100%,.8);text-align:center;font-size:30px;line-height:58px}.stamp .weui-btn{float:right;margin-top:-4px;padding:0 10px}.stamp.blue{background:#10aeff;background:radial-gradient(transparent 0,transparent 4px,#10aeff 4px);background-position:-5px 10px;background-size:9pt 8px}.stamp.blue:before{background-color:#10aeff}.qq,.wx{margin-right:5px;width:20px;height:20px}.qq{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NDkxMSwgMjAxMy8xMC8yOS0xMTo0NzoxNiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxMkQwNDg5MUQzMjAxMUU3OTQxOEE1MkJFMThBOTMyRSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxMkQwNDg5MkQzMjAxMUU3OTQxOEE1MkJFMThBOTMyRSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjEyRDA0ODhGRDMyMDExRTc5NDE4QTUyQkUxOEE5MzJFIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjEyRDA0ODkwRDMyMDExRTc5NDE4QTUyQkUxOEE5MzJFIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+rXKK3AAABKVJREFUeNp0VG1MU2cUfu4X7W2hX7QUVoiKDJOhiIsUcQxGiJkzcToCOqfZ5h8lU/9sC/sxhmPTLPuzLSxLhBm2LH6OLItuEmGbMFGYGlEj4hb5cKCs1lKgtNz2tvfevfdSEMj2Jk3vxznnnuc8z3Mo/Meh+UTOXFRebikq385n5rppoykVoChZCHrDf9/pmew60zzxe3OzNOUPLc6lFj8wrdu80bmrpo5f8oxbIfdKTARkOR5Ng2I58kcjMjpw23vq00PjF058Pz+feVKaQuruwwddb312lDPbXbIYBqQYKIYFrTOA4nRamBIVoUhRsBa701JcUclanbbgjd9aIUsLC6a+UVfr3FlTJwsB0lV0BrreiNjYKISeNkQGerSPsvZ0UpV0TGLU7pNWlxSwZrsjcOVcy1xBk/ulDa799U1qsVl4arFQ148YOVQJ/y/HEez6Cf7WJrBiEHxu6UwXigJZFGDMWZ8f9Q73CwO3bjOEAF3Gu02nOIsjbbYzitMjOtyHB4e3Y82KTDxbUAiDKQnu/ALc/OFbcFYH+JyimfnGC/NZa/IJUd+w5vVbtvBLV66RI8KTcXIJCHY2Q5gKYM+Bt+EPhDA9LaCstAQdv7Yh0H4SSRt2Exi0hkiJRpDgXJJheWH7a6y5uGKnAgXzyZHJjKZH72nzaG09jxS7AXIsgu7OCEICSQ48Rmx6ElyijWTOjEhFZ163uZLlM1e7Z6FqL4g0kkIBLPM9wlRWEl5f243sNIboS0JIvIyLZcm41B1B8nQA4yY7aCmeR+Dr0rNX0YzRlDJLuXqkBD1MgzdRPTaClaEkHGuT0P2XDlf/NKKphUKoD/iIlvF032VE41LSDoFO80Ybq2GchUwuOfLieksjnAYO+5LT0HvlAQb+8ELHUHBNS9iYtRSdiSH8fK4RKYVbgQQe8xtiiZ18tCHRoX6BYjjEHo8gcLUFQ4VugLdieSSMrL17IYXDMGY8hbSSYhw/WAtfQwOs/T3g88ogh0Mzs48Ik2z4fm+PcdXzLypyJI45Cj49G35CumhiYMjJwYp9exbY0+v1Q+/K0lwzxyWbAHGot48hAmZN7k1bVTtpc9DxSCyqwGM+jegvE+Uf1ILm6LnE9o7L+OquAGfV50hwuOLrQCFGMGCs5et6RvQM3TMXvlzOWhx21bugWcg6E95fegZZvgZMwQqj0YYYcUR/3yU86KzGK89R6NJvRpThQSmStjCkSZ/34ZF3qhhFDEel4LjHWrJtm0K0ptEjSVgWvIUcmx8Tnqs4OmjA2bujsHuOICOVwR05D9eUtcQgFOlPAWO0wPPdh+8Fr7d1zK0v1/4v6x1b9x+IBcY00sPQg40JYCgZIqPXYjiZbBpZIfcG6KnwTDFTMiY6Tp8e/mTXqwphe27bBG9cOE+2hp0Y3a1uE5aQRDG0Zi8WMfKTtGv1GYcomQyndTZxsfnUyBdVbyqiIC3ch6S6uoKivodD/PK8XNaSYqPigp3VqapYmrCp7kcp4Hv46NjHNaON1dVkbNL/bmxNnLZUq7V0xw5TwaZyYqdcogSbGkt0Ni7+M9gXuHb+7ET7yWOi575nce6/AgwALYP+cjO4paoAAAAASUVORK5CYII=) no-repeat}.wx{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDIxIDc5LjE1NDkxMSwgMjAxMy8xMC8yOS0xMTo0NzoxNiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxRjBFODMyMUQzMjAxMUU3QTZFRkI0MUE0QjQ2M0Q5QiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxRjBFODMyMkQzMjAxMUU3QTZFRkI0MUE0QjQ2M0Q5QiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjFGMEU4MzFGRDMyMDExRTdBNkVGQjQxQTRCNDYzRDlCIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjFGMEU4MzIwRDMyMDExRTdBNkVGQjQxQTRCNDYzRDlCIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+IgWy3gAAA+BJREFUeNpslV9sFFUUxn8zs9PZ3bLtsl3aQgvEFxQ1ixUp4QVplJY0QZPyx7SaYOKLJsQXEyRqqIgxajQajUqi4QFM5E8NhjSARBAfENOHSq1WRExjCAlpkWW7pftndmc8925btksnmZ2Ze+/57ne/c76zBvNcRhg71ElXcBPP2CtpNSM0qmF/ijH3CoPZMxzL9HPMu82de2IrB4JPsinyMnvtFbSqb9+VH2960pSAQOlZ+Jfh9Oe8nfmOo+XxVjl0zS56a3v5yorR5OdkrKgQy1b702MFCayjIdzJNitOLHeB7/V4OWDkFfbUCDN/Uj7c0ozhyG3LbVQAUwJW7J11rDVjLMqe5eQsYLCNjdG3OKDBFNlqWXyb/9zLDMnR/jFMfAlaKE9mmMySzgroY6wpXueqO8KwIcFO/Bsu2vfTovUyyE3uZ8+dg3zhpUjrDWwhu4F2keTDwHIe8jMViaiSfca4Nr6FhBlq52kNltOBXqqX59Kf8r69itVmDTUqwH6ENflLDN7sZn3hKn8oKeawzMtRm1kafooeM9jJs0ofIwi5Ac5N9dFnLCASeYnXrSaaVUB4Oy8EH6ddmFSJVgeNSEmWOTXi6grZZtXu5iNsFpghkNo6mvuZs+TJT33LIe8m42qtsBoKrGCZ1GdYdLqUPUW/XyRT9QAtGtYvJc0UIgHZrV7VmSzAWsLyyrq0GljktLE+c5x+0XRS1qq0/J49x6n8RX6I7uOQ7wklTxsiZs4QV0JLtjeLdolywKpHWZU9yRkpZkOCP1Bj1T3sCG+lW05xJCOuEaC7V+MvjC0exl88hL/kMn7DT4xKJpfNzEt22yRZkmcpxzAhnVUHW/S0NfgOdjaNSvxv+I0DJAPuXww6a+lQWVbZMuM0O+20VS8l4Y1zy2qk3v2VAT+FK17WBSNr3dkTtLBOyaUMIFgjgexpDku1d8xSzuOLY740w5qVLn1vguTEe7xZqa8cuyfUwXbZSGc99yPHreI1/g5upEu8GVceFa2UeyzFVt/C3Gllg/0gK0XntGxjy/vDVj3R2tfYL7Vap8C9W4yl9vGiTkhoM1tin9Dnpefx7HTjMEKlriMbFKVmLVk7Ifn25D1q1kJqLzsnD/CZ9nLhCn+KdnXK6Mqb817utI8NOUNBtzFHdAuaUV2/R1Lv8qoiM9tt8hc4LQ0g7qyWPujf2wTmtDCFK5HSeBXY4eRunidbirDK25FqQcUbjIpGCbOOmO4ufpkMRqkRKJt6Sa6nP+aN1DvsInd3e2M+EmY9C8Xo3cEn6ArcR0I5QP8FZElKOxvJnefE1Am+loTeqIz9X4ABAJx3Wci5cB1BAAAAAElFTkSuQmCC) no-repeat}
</style>
@endsection

@section('script')
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script>
    var qq_jia=true;
    function jia_qq(){
        if(qq_jia){
            var sUserAgent=navigator.userAgent.toLowerCase();
            var bIsIpad=sUserAgent.match(/ipad/i)=="ipad";
            var bIsIphoneOs=sUserAgent.match(/iphone os/i)=="iphone os";
            var bIsMidp=sUserAgent.match(/midp/i)=="midp";
            var bIsUc7=sUserAgent.match(/rv:1.2.3.4/i)=="rv:1.2.3.4";
            var bIsUc=sUserAgent.match(/ucweb/i)=="ucweb";
            var bIsAndroid=sUserAgent.match(/android/i)=="android";
            var bIsCE=sUserAgent.match(/windows ce/i)=="windows ce";
            var bIsWM=sUserAgent.match(/windows mobile/i)=="windows mobile";
            if(!(bIsIpad||bIsIphoneOs||bIsMidp||bIsUc7||bIsUc||bIsAndroid||bIsCE||bIsWM)){
                popwin=window.location.href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=2187947868";
            }
            else{
                popwin=window.location.href="http://qm.qq.com/cgi-bin/qm/qr?k=EuoBtCA6fqDKIk3YI1Q-9tSkYJ7Dg609";
            }
            //setTimeout(window.history.go(-1),10000);
        }
    }
    $(function(){

        var clipboard = new Clipboard('[data-clipboard]');
        clipboard.on('success',function(e){
            $(e.trigger).html("复制成功").attr("class","weui-btn weui-btn_mini weui-btn_primary");
            e.clearSelection();
        });

        $("input[type=text]").on("click",function(){
            $(this).select();
        });

        $("#add").on("click",function(){
            $("#corner").show().addClass("in");
        });
        $(".close").on("click",function(){
            $(".modal").hide().removeClass("in");
        });
    });
</script>
@endsection

@section('content')
<div id="corner" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"><span>&times;</span></button>
                <h5 class="modal-title">添加客服微信</h5>
            </div>
            <div class="modal-body">
                <img src="{{ asset('img/kfwx.jpg') }}" alt="" width="100%">
            </div>
        </div>
    </div>
</div>
@if(!isset($order))
    没有找到订单，请重试
@else
    @if($order->status === 3)
    <div class="page__hd">
        <p class="text-center"><i class="weui-icon-success weui-icon_msg"></i></p>
        <p class="text-center">订单已完成！</p>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><b class="weui-label">完成时间</b></div>
        <div class="weui-cell__bd">
        <span class="weui-input">{{$order->success_date}}</span>
        </div>
    </div>
    @elseif($order->status === 2)
    <div class="page__hd">
        <p class="text-center"><i class="weui-icon-waiting weui-icon_msg"></i></p>
        <p class="text-center" data-clipboard-demo>订单提交成功，<br>等待发货中...</p>
    </div>
    @else
    <div class="page__hd">
        <p class="text-center"><i class="weui-icon-warn weui-icon_msg"></i></p>
        <p class="text-center">订单已取消</p>
    </div>
    @endif
    <div class="weui-cell">
        <div class="weui-cell__hd"><b class="weui-label">商&nbsp;品&nbsp;名</b></div>
        <div class="weui-cell__bd">
        <span class="weui-input"><a href="/shop/{{$order->item_id}}">{{$order->title}}</a></span>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><b class="weui-label">花费积分</b></div>
        <div class="weui-cell__bd">
        <span class="weui-input text-warning">{{$order->money}}</span>
        </div>
    </div>
    @if($order->status === 3)
    <div class="weui-cell">
        <div class="weui-cell__hd"><b class="weui-label">订&nbsp;单&nbsp;号</b></div>
        <div class="weui-cell__bd">
        <span class="weui-input">{{$order->order_id}}</span>
        </div>
    </div>
    @endif
    
    @if($order->type === 1 && isset($order->code))
        @foreach ($order->code as $c)
        <div class="stamp blue">
            <div class="par">
                <p>兑换码：
                <button class="weui-btn weui-btn_mini weui-btn_default" data-clipboard data-clipboard-text="{{$c->code}}">复制代码</button>
                </p>
                <input readonly type="text" class="sign" value="{{$c->code}}" >
            </div>
            <i></i>
        </div>
        @endforeach
        <div class="container">
            <a href="https://pvp.qq.com/act/agile/28443/index.html" class="weui-btn weui-btn_primary">微信&QQ大区兑换入口</a><br>
            <p>安卓用户兑换时请点击右上角菜单，选择“在浏览器打开”</p>
        </div>
    @elseif($order->type === 2 && $order->status === 2)
        <div class="stamp blue">
            <div class="par">
                <p>订单号：
                <button class="weui-btn weui-btn_mini weui-btn_default" data-clipboard data-clipboard-text="{{$order->order_id}}">复制代码</button>
                </p>
                <input readonly type="text" class="sign" id="orderId" value="{{$order->order_id}}" >
            </div>
            <i></i>
        </div>
        <div class="container">
            请联系客服并提交订单号☟
        </div>
        <a class="weui-cell weui-cell_access" href="javascript:;" id="add">
            <div class="weui-cell__hd">
                <div class="wx"></div>
            </div>
            <div class="weui-cell__bd">
                <h5>微信客服：<font class="text-success">wzcwh_xin</font></h5>
            </div>
            <div class="weui-cell__ft">添加客服微信</div>
        </a>
    @elseif($order->type === 4)
        <div style="width:100%; padding:15px;">
            <a href="/bonusHistory" class="weui-btn weui-btn_primary">积分已发放</a>
        </div>
    @endif
@endif
@endsection