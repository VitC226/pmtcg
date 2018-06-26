<?php

namespace App\Http\Controllers;

use App\Libs\ImageDuel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use QL\QueryList;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    ///管理中心
    public function index(){
        return view('admin.index');
    }

    public function card($cate = null){
        $series = DB::select('select series from pm_subcategory GROUP BY series ORDER BY releaseDate desc');
        $symbol = DB::table('pm_subcategory')->orderBy('releaseDate', 'desc')->get();

        $list = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card_title.title', 'pm_card.img', 'pm_subcategory.name as cate', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp')
                ->orderBy('pm_subcategory.releaseDate', 'desc')
                ->orderBy('pm_card.subId', 'asc')->when($cate, function ($query) use ($cate) {
                    return $query->where('symbol', $cate);
                })
                ->paginate(24);
        return view('admin.card', [ 'list' => $list, 'series' => $series, 'symbol' => $symbol ]);
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
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card.pmId','pm_card.titleId', 'pm_card_title.title', 'pm_card.img', 'pm_card.type', 'pm_card_type.name as typeName', 'pm_subcategory.name as cate', 'pm_card.rarity', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp', 'pm_description.lv', 'pm_description.evolve', 'pm_description.weakness', 'pm_description.resistance', 'pm_description.retreat', 'pm_subcategory.name as illustratorName', 'pm_card.link')
                ->where('pm_card.cardId', $card)->first();
        //print_r($imageUrl);
        $abilitys = DB::table('pm_ability as a')
                    ->leftJoin('pm_power_title as t', 'a.abilitytitle', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'a.abilitycontent', '=', 'c.id')
                    ->leftJoin('pm_power_title as t2', 'a.bodytitle', '=', 't2.id')
                    ->leftJoin('pm_power_content as c2', 'a.bodycontent', '=', 'c2.id')
                    ->leftJoin('pm_rule as r', 'a.exId', '=', 'r.id')
                    ->select('t.id as abilityId', 't.title as abilityName', 'c.id as abilityContentId', 'c.content as abilityContent', 'c.status as contentStatus', 't.title_en as abilityNameEn', 'c.content_en as abilityContentEn', 'a.restored', 'a.exId', 'a.exObject', 'r.title as ruleName', 'r.content as ruleContent','t2.id as bodyId', 't2.title as bodyName', 't2.title_en as bodyNameEn', 'c2.id as bodyContentId', 'c2.content as bodyContent', 'c2.content_en as bodyContentEn', 'c2.status as contentStatus2', 'a.LV', 'a.BODY2')
                    ->where('a.cardId', $card)->first();
        $power = DB::table('pm_ability_power as p')
                    ->leftJoin('pm_power_title as t', 'p.title', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'p.content', '=', 'c.id')
                    ->select('p.id', 'p.cardId', 'p.cost', 'p.damage','t.id as tId', 't.title','c.id as cId', 'c.content', 't.title_en', 'c.content_en', 'c.status as contentStatus')
                    ->where('p.cardId', $card)->orderBy('p.id')->get();
        return view('admin.cardEdit',[ 'info' => $info, 'abilitys' => $abilitys, 'power' => $power ]);
        //return view('admin.cardEdit');
    }

    public function translate(Request $request)
    {
        $id = Input::get('tid');
        $rule = Input::get('rule');
        $text = Input::get('text');
        $key = Input::get('key');
        $key = str_replace("^","",$key);

        $php = Input::get('php');
        $json = array('rule' => $rule);
        $json["text"] = $text;
        $json["tid"] = $id;
        $json["key"] = $key;
        $json["php"] = $php;
        
        if($id){
            DB::table('translator')
                ->where('id', $id)
                ->update(['rule' => $rule, 'text' => $text, 'php' => $php]);
        }else{
            $id = DB::table('translator')->insertGetId(['key' => $key, 'rule' => $rule, 'text' => $text, 'php' => $php]);
        }
        //开始翻译
        if($rule){
            if(strpos($rule,'%')===false){
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en REGEXP\"".$rule."\" and status is null");
            }
            else{
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en  like \"%".$rule."%\"");
            }
            $cn = array("Confused"=>"混乱","Asleep"=>"睡眠","Poisoned"=>"中毒","Paralyzed"=>"麻痹","Burned"=>"灼伤");
            foreach ($list as $item) {
                $content = $item->content;
                $flag = true;
                $newTemp = "";
                preg_match_all("/".$php."/",$content,$str);
                if(count($str[0]) > 0){
                    $str = $str[0][0];
                    $cn = array("Confused"=>"混乱","Asleep"=>"睡眠","Poisoned"=>"中毒","Paralyzed"=>"麻痹","Burned"=>"灼伤");
                    preg_match_all("/\b(Confused|Asleep|Poisoned|Paralyzed|Burned)\b/",$str,$arr);
                    $arr = $arr[0];
                    $count = count($arr);
                    if($count>0 && $flag){
                        $flag = false;
                        foreach ($arr as $key => $value) {
                            $newTemp.= $cn[$value];
                            if($key+1 < $count){ $newTemp.= "、"; }
                        }
                        $newTemp = str_replace("*",$newTemp,$text);
                    }

                    preg_match_all("/\b(Grass|Fire|Water|Lightning|Psychic|Fighting|Darkness|Metal|Colorless|Fairy|Dragon)\b/",$str,$arr);
                    $arr = $arr[0];
                    $count = count($arr);
                    if($count>0 && $flag){
                        $flag = false;
                        for ($i=0; $i < $count; $i+=3) {  $newTemp.= "{".$arr[$i]."}"; }
                        $newTemp = str_replace("*",$newTemp,$text);
                    }

                    if(strpos($str,'0 ') !==false && $flag){
                        $flag = false;
                        preg_match_all("/\d+0/",$str,$arr);
                        $arr = $arr[0];
                        foreach ($arr as $key => $value) {
                            $newTemp.= $value;
                        }
                        $newTemp = str_replace("[0-9]*",$newTemp,$text);
                    }

                    if(strpos($rule,'%')!==false && $flag){
                        $flag = false;
                        $len = strlen($str);
                        $arr = explode('%',$rule);
                        $before = strlen($arr[0]);
                        $after = $len - $before - strlen($arr[1]);

                        $newTemp = substr($str, $before, $after);
                        $newTemp = str_replace("*",$newTemp,$text);
                    }

                    $newTemp = str_replace($str,$newTemp,$content);
                }
                
                $pos1 = strpos($newTemp,".");
                $pos2 = strpos($newTemp,",");
                if($newTemp != ""){
                    if(!$pos1 && !$pos2){
                        DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $newTemp, 'status' => 1]);
                    }else{
                        DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $newTemp]);
                    }
                    $item->content = $newTemp;
                }
            }
        }
        else{
            $list = DB::table('pm_power_content')->where('content_en', 'like', '%'.$key.'%')->whereNull('status')->get();
            foreach ($list as $item) {
                $new = str_replace($key,$text,$item->content);

                $pos1 = strpos($new,".");
                $pos2 = strpos($new,",");
                if($new != ""){
                    if(!$pos1 && !$pos2){
                        DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $new, 'status' => 1]);
                    }else{
                        DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $new]);
                    }
                    $item->content = $new;
                }
            }
        }
        $json["list"] = $list;

        return response()->json($json);
    }

    public function translateSave(Request $request){
        $pid = Input::get('pid');
        $type = Input::get('type');
        $newTemp = Input::get('text');
        if($type == "title"){
            DB::table('pm_power_title')->where('id', $pid)->update(['title' => $newTemp]);
        }else if($type == "name"){
            DB::table('pm_card_title')->where('id', $pid)->update(['title' => $newTemp]);
        }else if($type == "content"){
            $pos1 = strpos($newTemp,".");
            $pos2 = strpos($newTemp,",");
            if($newTemp != ""){
                if(!$pos1 && !$pos2){
                    DB::table('pm_power_content')->where('id', $pid)->update(['content' => $newTemp, 'status' => 1]);
                }else{
                    DB::table('pm_power_content')->where('id', $pid)->update(['content' => $newTemp]);
                }
            }
        }
        $json = array('text' => $newTemp);
        return response()->json($json);
    }

    public function addAbility(Request $request){
        $cid = Input::get('cid');
        $cid = (int) $cid;
        $name = Input::get('name')?Input::get('name'):null;
        $content = Input::get('content');
        $attr = Input::get('ab');
        $cost = Input::get('cost')?Input::get('cost'):null;
        $damage = Input::get('damage')?Input::get('damage'):null;
        $json = array('cid' => $cid);

        if($name){
            $abTitle = DB::table('pm_power_title')->select('id')->where('title_en',$name)->first();
            if(!$abTitle){
                $abTitle = DB::table('pm_power_title')->insertGetId(['title_en' => $name, 'title' => $name]);
            }else{
                $abTitle = $abTitle->id;
            }
            $json['name'] = $abTitle;
        }

        if($content){
            $abContent = DB::table('pm_power_content')->select('id')->where('content_en',$content)->first();
            if(!$abContent){
                $abContent = DB::table('pm_power_content')->insertGetId(['content_en' => $content, 'content' => $content]);
            }else{
                $abContent = $abContent->id;
            }
            $json['content'] = $content;
        }

        if($attr == "ab"){
            $ab = DB::table('pm_ability')->where('cardId', $cid)->where('abilitytitle', $abTitle)->where('abilitycontent', $abContent)->first();
            $json['ab'] = $ab;
            if(!$ab){
                $id = DB::table('pm_ability')->insertGetId(['cardId' => $cid, 'abilitytitle' => $abTitle, 'abilitycontent' => $abContent]);
                $json['result'] = $id;
            }
        }
        elseif($attr == "pb"){
            $ab = DB::table('pm_ability')->where('cardId', $cid)->where('bodytitle', $abTitle)->where('bodycontent', $abContent)->first();
            $json['ab'] = $ab;
            if(!$ab){
                $id = DB::table('pm_ability')->insertGetId(['cardId' => $cid, 'bodytitle' => $abTitle, 'bodycontent' => $abContent]);
                $json['result'] = $id;
            }
        }
        else{
            $po = DB::table('pm_ability_power')->where('cardId', $cid)->where('title', $abTitle)->where('content', $abContent)->first();
            $json['po'] = $po;
            if(!$po){
                $id = DB::table('pm_ability_power')->insertGetId(['cardId' => $cid, 'cost' => $cost, 'damage' => $damage, 'title' => $abTitle, 'content' => $abContent]);
                $json['result'] = $id;
            }
        }

        return response()->json($json);
    }

    public function loadImg(Request $request){
        $cid = Input::get('cid');
        $card = DB::table('pm_card')->where('cardId', $cid)->first();
        $image = new ImageDuel();
        $image->create($card->link,$card->img);
        $json = array('text' => "请求已提交");
        return response()->json($json);
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