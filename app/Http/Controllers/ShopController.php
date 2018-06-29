<?php

namespace App\Http\Controllers;
use DB;
use App\WXuser;
use App\BonusHistory;
use App\CDKEY;
use App\Code;
use App\Order;
use App\Qrcode;
use App\Product;
use App\Http\Requests;
use App\Jobs\DestroyQRCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;

class ShopController extends Controller
{
    //商城首页
    public function index(){
        //$user = WXuser::getWXuser();
        $list = DB::table('shop_item')->where(['status' => 1, 'isShop' => 1])->orderBy('price')->get();
        return view('shop.index', ['list' => $list , 'bonus' => 10 ]);
    }

    public function item($item){
        $item = DB::table('shop_item')
            ->join('shop_item_type', 'shop_item.type', '=', 'shop_item_type.id')
            ->select('shop_item.*', 'shop_item_type.name', 'shop_item_type.instruction')
            ->where(['shop_item.id' => $item ])
            ->first();
        return view('shop.item',['item' => $item]);
    }

    public function result($orderId){
        $openid = WXuser::getOpenId();
        $order = DB::table('order')
            ->join('shop_item', 'order.item_id', '=', 'shop_item.id')
            ->select('order.order_id','order.item_id', 'order.money', 'order.type', 'order.status', 'order.success_date', 'shop_item.title')
            ->where(['order_id' => $orderId, 'openid' => $openid ])
            ->first();
        //$code = array();
        if(isset($order) && $order->status === 3){
            if($order->type === 1){
                $code = Code::where('remark', $order->order_id)->get();
                $order->code = $code;
            }
        }
        return view('shop.result',[ 'order' => $order ]);
    }
/*
    public function result(){
        $money = Input::get('money');
        $key = Input::get('key');
        $time = Input::get('time');

        $qrcode = Qrcode::where('status', 1)->where('remark', $key)->first();
        $order = Order::where('status', 1)->where('qrcode_id', $qrcode->id)->first();

        $order->success_date = $time;
        $order->status = 2;
        $order->save();

        $qrcode->status = 0;
        $qrcode->save();

        return $order->order_id;
    }*/

    public function cdkey(){
        return view('shop.cdkey');
    }

    public function orderList(){
        $openid = WXuser::getOpenId();

        $list = DB::table('order')
            ->join('shop_item', 'order.item_id', '=', 'shop_item.id')
            ->select('order.order_id', 'order.money', 'order.status', 'shop_item.image', 'shop_item.thumb', 'shop_item.title')
            ->where('order.openid',$openid)
            ->orderBy('order.updated_at','desc')
            ->get();
        return view('shop.order_list',[ 'list' => $list ]);
    }

    public function order($orderId){
        $openid = WXuser::getOpenId();

        $order = Order::where('order_id',$orderId)->first();
        $code = array();
        if($order->type === 1 && $order->status === 3){
            $code = Code::where('remark', $order->order_id)->get();
        }
        $product = Product::find($order->item_id);;
        return view('shop.order_detail',[ 'order' => $order, 'product' => $product ,'code' => $code ]);
    }

    public function cdkeyList($order){
        
        $list = DB::table('cdkey_code')->select("code")->where(['remark' => $order, 'status' => 1])->get();
        return view('shop.cdkey_list',['list' => $list]);
    }
/*
    public function pay($type = 'wechat'){
        if($type == 'wechat'){
            //创建订单
            $money = 0.01;
            $count = 1;
            $item_id = 1;
            $wxuser = session('wechat.oauth_user')['original'];
            $qrcode = Qrcode::where('status', 0)->where('money', $money)->first();

            $order = new Order;
            $order->order_id = uniqid();
            $order->openid = $wxuser['openid'];
            $order->item_id = $item_id;
            $order->money = $money;
            $order->count = $count;
            $order->qrcode_id = $qrcode->id;
            $order->status = 1;
            $order->save();

            $qrcode->status = 1;
            $qrcode->save();

            $job = (new DestroyQRCode($order, $qrcode))->delay(180);
            dispatch($job);

            return view('pay_wechat',['order' => $order, 'qrcode' => $qrcode]);
        }else{
            $order = Order::find(11);
            $qrcode = Qrcode::where('status', 1)->first();
            $job = (new DestroyQRCode($order, $qrcode))->delay(180);
            dispatch($job);
            return view('pay_bonus');
        }

    }
*/
    //创建订单并支付
    public function createOrder(Request $request){
        $item_id = Input::get('itemid');
        $count = Input::get('count');

        $json = array('status' => 0);

        //检查剩余量是否足够
        $item = Product::find($item_id);
        $money = $item->price * $count;
        if($item->status != 1){
            $json['msg'] = '当前商品已经下架！';
            return response()->json($json);
        }

        if($item->isShop != 1){
            $json['msg'] = '当前商品暂时无法兑换！';
            return response()->json($json);
        }

        if(isset($item->inventory) && $item->inventory < $count){
            $json['msg'] = '当前商品库存不足，请重新选择数量！';
            return response()->json($json);
        }
        
        if(!session()->has('wechat.oauth_user')){
            $json['msg'] = '登录信息已过期，请刷新页面！';
            return response()->json($json);
        }else{
            $user = WXuser::getWXuser();
            //检查积分是否足够
            if($user->bonus < $money){
                $json['msg'] = '您的积分不足，快去赚积分吧！';
                return response()->json($json);
            }
        }

        $order = new Order;
        $order->order_id = uniqid();
        $order->openid = $user['openid'];
        $order->item_id = $item_id;
        $order->type = $item->type;
        $order->money = $money;
        $order->count = $count;
        if($item->type == 1){
            $order->status = 3;
            $order->success_date = Carbon::now();
            //自动发码
            Code::where(['status' => 0, "item_id" => $order->item_id])->take($count)->update(['status' => 1, 'remark' => $order->order_id.'']);
        }
        else{
            //等待发货
            $order->status = 2;
        }
        $order->save();

        $user->bonus -= $money;
        $user->save();

        if(isset($item->inventory)){
            $item->inventory -= $count;
        }
        $item->saled += $count;
        $item->save();

        $log = new BonusHistory();
        $log->openid = $user['openid'];
        $log->change = -$money;
        $log->total = $user->bonus;
        $log->reason_type = 1;
        $log->reason = '积分兑换花费';
        $log->save();

        $json['order'] = $order->order_id;
        $json['status'] = $order->status;

        return response()->json($json);
    }

    public function checkpay(Request $request){
        $orderid = Input::get('orderid');
        //检查对应的订单是否已经支付
        $order = Order::where('order_id', $orderid)->first();

        if(count($order) != 1){
            $json['status'] = -2;//订单失效
        }else{
            $json = array('status' => $order->status);
            if($json['status'] == 2){
                $size = Code::where('status', 0)->count();
                if($size < $order->count){
                    $json['status'] = -1;//cdkey不足
                }else{
                    $json['order'] = $order->order_id;
                    Code::where(['status' => 0, "item_id" => $order->item_id])->take($order->count)->update(['status' => 1, 'remark' => $order->order_id]);
                    $order->status = 3;
                    $order->save();
                }
            }
        }
        return response()->json($json);
    }

    public function skin(Request $request){
        $price = Input::get('price');
        $p = Product::select(['thumb','image','title'])->where(['type' => 2, 'price' => $price, 'status' => 1])->get();
        $json['list'] = $p;
        $json['price'] = $price;
        return response()->json($json);
    }
}
