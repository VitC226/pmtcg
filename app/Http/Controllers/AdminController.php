<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use QL\QueryList;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->collectIndex = "";
    }

    ///管理中心
    public function index(){
        return view('admin.index');
    }

    public function card(){
        $list = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card_title.title', 'pm_card.img', 'pm_subcategory.name as cate', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp')
                ->orderBy('pm_subcategory.releaseDate', 'desc')
                ->orderBy('pm_card.cardId', 'asc')
                ->paginate(25);
        return view('admin.card', [ 'list' => $list ]);
    }
    public function cardEdit($card){
        $card = (int) $card;
        $info = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type', 'pm_card.type', '=', 'pm_card_type.id')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->leftJoin('pm_illustrator', 'pm_card.illustrator', '=', 'pm_illustrator.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card.pmId', 'pm_card_title.title', 'pm_card.img', 'pm_card.type', 'pm_card_type.name as typeName', 'pm_subcategory.name as cate', 'pm_card.rarity', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp', 'pm_description.lv', 'pm_description.evolve', 'pm_description.weakness', 'pm_description.resistance', 'pm_description.retreat', 'pm_subcategory.name as illustratorName')
                ->where('pm_card.cardId', $card)->first();
        $abilitys = DB::table('pm_ability as a')
                    ->leftJoin('pm_power_title as t', 'a.abilitytitle', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'a.abilitycontent', '=', 'c.id')
                    ->leftJoin('pm_power_title as t2', 'a.bodytitle', '=', 't2.id')
                    ->leftJoin('pm_power_content as c2', 'a.bodycontent', '=', 'c2.id')
                    ->leftJoin('pm_rule as r', 'a.exId', '=', 'r.id')
                    ->select('t.title as abilityName', 'c.content as abilityContent', 'a.restored', 'a.exId', 'a.exObject', 'r.title as ruleName', 'r.content as ruleContent', 't2.title as bodyName','c2.content as bodyContent', 'a.LV', 'a.BODY2')
                    ->where('a.cardId', $card)->first();
        $power = DB::table('pm_ability_power as p')
                    ->leftJoin('pm_power_title as t', 'p.title', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'p.content', '=', 'c.id')
                    ->select('p.id', 'p.cardId', 'p.cost', 'p.damage', 't.title', 'c.content', 't.title_en', 'c.content_en')
                    ->where('p.cardId', $card)->orderBy('p.id')->get();
        return view('admin.cardEdit',[ 'info' => $info, 'abilitys' => $abilitys, 'power' => $power  ]);
    }


    public function collect(){
        $url = "https://www.pokemon.com/us/pokemon-tcg/pokemon-cards/sm-series/sm1/1/";
        $data = QueryList::get($url);
        //$pid = $data->find("meta[name=pkm-id]")->attrs("content");
        print_r($data->find('title')->text());
        print_r($data->all());
/*
        //采集某页面所有的图片
        $data = QueryList::get('http://www.nipic.com')->find('img')->attrs('src');;
        //打印结果
        print_r($data->all());

        //采集某页面所有的超链接和超链接文本内容
        //可以先手动获取要采集的页面源码
        $html = file_get_contents('http://cms.querylist.cc/google/list_1.html');
        //然后可以把页面源码或者HTML片段传给QueryList
        $data = QueryList::html($html)->rules([  //设置采集规则
            // 采集所有a标签的href属性
            'link' => ['a','href'],
            // 采集所有a标签的文本内容
            'text' => ['a','text']
        ])->query()->getData();
        //打印结果
        print_r($data->all());*/
        return view('admin.collect');
    }

    public function collectIndex(Request $request) {
        //$url = Input::get('url');
        $url = "https://pkmncards.com/set/dragon-vault/";
        $data = QueryList::get($url)->find('div.name a')->attrs('href');
        $json = array('address' => $data);
        return response()->json($json);
    }

    public function collectCard(Request $request) {
        $url = Input::get('url');
        $url = "https://www.pokemon.com/us/pokemon-tcg/pokemon-cards/sm-series/sm1/1/";
        $data = QueryList::get($url);
        $pid = $data->find("meta[name=pkm-id]")->attrs("content");

        $obj = array('pid' => $pid);
        //$json = array('card' => $this->collectIndex);
        $json = array('card' => $url);
        return response()->json($json);
    }


    public function userEdit($id = null){
        if(isset($id)){
            $user = WXuser::find($id);
            return view('auth.userEdit',['user'=>$user]);
        }else{
            return view('auth.userEdit');
        }
    }

    public function store(Request $request)
    {
        print_r($request->all());exit;
        return redirect('admin/user');
    }

    public function shop(){
        $list = Product::paginate(15);
        return view('auth.shop', [ 'list' => $list ]);
    }

    public function shopEdit($id = null){
        if(isset($id)){
            $item = Product::find($id);
            return view('auth.shopEdit',[ 'item' => $item ]);
        }else{
            return view('auth.shopEdit');
        }
    }

    public function itemSubmit(Request $request)
    {
        $id = $request->id;
        if(isset($request->id)){
            $p = Product::find($request->id);
        }else{
            $p = new Product;
        }
        $p->type=$request->type;
        $p->thumb=$request->thumb;
        $p->image=$request->image;
        $p->title=$request->title;
        $p->content=$request->content;
        $p->price=$request->price;
        $p->inventory=$request->inventory;
        $p->saled=isset($request->saled)?$request->saled:0;
        $p->status=$request->status;
        $p->isShop=$request->isShop;
        $p->save();
        return redirect('admin/shop');
    }

    public function shopDetail($id){
        return view('auth.shopDetail', [ 'item' => Product::find($id) ]);
    }

    public function shopDel($id){
        $json = array('status' => 1);
        Product::destroy($id);
        return response()->json($json);
    }

    public function invite(){
        $data = array('limit' => 40);
        $list = RankHistory::weekResult($data);
        return view('auth.invite', [ 'list' => $list ]);
    }
    public function addInvite(Request $request){
        $id = Input::get('robot');
        $add = Input::get('add');
        $add = isset($add)?$add:1;

        $json = array('status' => 1);
        DB::table('rank')->where('openid', $id)->increment('count', $add);
        return response()->json($json);
    }

    public function cdkey(){
        $list = DB::table('cdkey_code')->
        select('cdkey_code.*','shop_item.title')->
        leftJoin("shop_item",'cdkey_code.item_id','=','shop_item.id')->
        paginate(15);
        return view('auth.cdkey', [ 'list' => $list ]);
    }

    public function cdkeyEdit($id = null){
        if(isset($id)){
            $item = CDKEY::find($id);
            return view('auth.cdkeyEdit',[ 'item' => $item ]);
        }else{
            return view('auth.cdkeyEdit');
        }
    }

    public function cdkeySubmit(Request $request)
    {
        $id = $request->id;
        if(isset($request->id)){
            $p = CDKEY::find($request->id);
        }else{
            $p = new CDKEY;
        }
        $p->item_id=$request->item_id;
        $p->code=$request->code;
        $p->status=1;
        $p->save();
        return redirect('admin/cdkey');
    }

    public function prize(){
        $list = DB::table('invite_prize')->
        select('invite_prize.*','shop_item.title')->
        leftJoin("shop_item",'invite_prize.item_id','=','shop_item.id')->
        paginate(15);
        return view('auth.prize', [ 'list' => $list ]);
    }
    public function order(){
        $id = Input::get("order_id");

        $list = DB::table('order')->
        select('order.*','shop_item.title','wxuser.nickname')->
        leftJoin("shop_item",'order.item_id','=','shop_item.id')->
        leftJoin("wxuser",'order.openid','=','wxuser.openid')->
        orderBy("order.id","desc")->paginate(15);
        return view('auth.order', [ 'list' => $list ]);
    }

    public function orderFinish($id){
        //订单状态修改
        $order = Order::find($id);
        if($order->status === 3) return redirect('/admin/order');
        $order->status = 3;
        $order->success_date = Carbon::now();
        $order->save();

        //通知用户
        $user = WXuser::getWXuserByOpenId($order->openid);
        $user->notify(new InvoicePaid([
            'title' => "您有一份订单已发货",
            'content' => "您的订单（单号".$order->order_id."）已经发货，请注意查收",
            'urlTitle' => "查看订单",
            'url' => "/order/".$order->order_id,
        ]));

        return redirect('/admin/order');
    }

    public function orderCancel($id){
        //订单取消
        $order = Order::find($id);
        if($order->status === 0) return redirect('/admin/order');
        $order->status = 0;
        $order->save();

        $user = WXuser::getWXuserByOpenId($order->openid);
        //返还积分
        $user->bonus += $order->money;
        $user->save();

        $log = new BonusHistory();
        $log->openid = $order->openid;
        $log->change = $order->money;
        $log->total = $user->bonus;
        $log->reason_type = 8;
        $log->reason = '订单取消返还';
        $log->save();

        //通知用户
        $user->notify(new InvoicePaid([
            'title' => "您有一份订单已取消",
            'content' => "您的订单（单号".$order->order_id."）被管理员取消，积分已经回到您的账户。",
            'urlTitle' => "查看订单",
            'url' => "/order/".$order->order_id,
        ]));

        return redirect('/admin/order');
    }

    public function partime(){
        $list = DB::table('partime')->paginate(15);
        return view('auth.partime', [ 'list' => $list ]);
    }

    public function partimeEdit($id = null){
        if(isset($id)){
            $item = DB::table('partime')->find($id);
            return view('auth.partimeEdit',[ 'item' => $item ]);
        }else{
            return view('auth.partimeEdit');
        }
    }

    public function partimeSubmit(Request $request)
    {
        $id = $request->id;
        if(isset($id)){
            DB::table('partime')->where('id', $id)->update(['title' => $request->title, 'type' => $request->type, 'img' => $request->image, 'description' => $request->description, 'content' => $request->content, 'outlink' => $request->outlink, 'status' => $request->status]);
        }else{
            DB::table('partime')->insert(['title' => $request->title, 'type' => $request->type, 'img' => $request->image, 'description' => $request->description, 'content' => $request->content, 'outlink' => $request->outlink, 'status' => $request->status]);
        }
        return redirect('admin/partime');
    }

    public function hero(){
        //更新英雄数据库
        //game.gtimg.cn/images/yxzj/img201606/heroimg/179/179-smallskin-2.jpg
        //game.gtimg.cn/images/yxzj/img201606/skin/hero-info/167/167-bigskin-1.jpg
        
    }
}