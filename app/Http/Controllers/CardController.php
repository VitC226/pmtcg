<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class CardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($cate = null)
    {
        $han = (App::getLocale() === "zh-cmn-Hant") ? "_t" : "";
        $list = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->select('pm_card.pkmId', 'pm_card_title.title'.$han.' as title', 'pm_card.img', 'pm_subcategory.name'.$han.' as cate', 'pm_card_type_class.name'.$han.' as tc', 'pm_description.energy', 'pm_description.hp')
                ->orderBy('pm_subcategory.releaseDate', 'desc')
                ->orderBy('pm_card.subId', 'asc')->when($cate, function ($query) use ($cate) {
                    return $query->where('pm_subcategory.symbol', $cate);
                })->paginate(24);
        return view('card.list', [ 'list' => $list, 'thumb' => session('show') ]);
    }

    public function tableOrList(Request $request){
        $data = $request->all();
        session(['show'=>$data['show']]);
        $json = array('show' => $data['show']);
        return response()->json($json);
    }

    public function card($card){
        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$card)){
            return view('card.error');
        }
        $han = (App::getLocale() === "zh-cmn-Hant") ? "_t" : "";

        $info = DB::table('pm_card as c')
                ->leftJoin('pm_subcategory as s', 'c.subcategory', '=', 's.id')
                ->leftJoin('pm_card_title as t', 'c.titleId', '=', 't.id')
                ->leftJoin('pm_description as d', 'c.cardId', '=', 'd.cardId')
                ->leftJoin('pm_card_title as evolve', 'd.evolve', '=', 'evolve.id')
                ->leftJoin('pm_card_type as ty', 'c.type', '=', 't.id')
                ->leftJoin('pm_card_type_class as tc', 'c.typeClass', '=', 'tc.id')
                ->leftJoin('pm_illustrator as i', 'c.illustrator', '=', 'i.id')
                ->select('c.cardId', 'c.pkmId', 'c.pmId', 't.title'.$han.' as title','t.title_en', 'c.img', 'c.type', 'ty.name as typeName', 'c.subcategory', 's.name'.$han.' as cate', 'c.rarity', 'c.typeClass','tc.ruleId', 'tc.name'.$han.' as tc', 'd.energy', 'd.hp', 'd.lv', 'd.ub', 'd.plasma', 'evolve.title as evolve', 'd.weakness', 'd.resistance', 'd.retreat', 's.symbol', 'i.name as illustratorName','s.releaseDate')
                ->where('c.img', $card)->first();
        if(!$info){ return view('card.error'); }

        //判断使用特性还是特殊能力
        $info->pokePower = (strtotime($info->releaseDate)-strtotime("2011-02-10")<0)?true:false;

        //LEGEND
        if($info->typeClass == 6){
            $img = DB::table('pm_card as c')
            ->leftJoin('pm_card_title as t', 'c.titleId', '=', 't.id')
            ->select('c.cardId','c.img')
            ->where('t.title_en', $info->title_en)->orderBy("cardId")->get();
            $info->img = $img;
        }

        $cardId = $info->cardId;
        $abilitys = DB::table('pm_ability as a')
                    ->leftJoin('pm_power_title as t', 'a.abilitytitle', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'a.abilitycontent', '=', 'c.id')
                    ->leftJoin('pm_power_title as t2', 'a.bodytitle', '=', 't2.id')
                    ->leftJoin('pm_power_content as c2', 'a.bodycontent', '=', 'c2.id')
                    ->leftJoin('pm_rule as r', 'a.exId', '=', 'r.id')
                    ->select('t.title'.$han.' as abilityName', 'c.content'.$han.' as abilityContent', 'a.restored', 'a.exId', 'a.exObject', 'r.title'.$han.' as ruleName', 'r.content'.$han.' as ruleContent', 't2.title'.$han.' as bodyName','c2.content'.$han.' as bodyContent', 'a.LV', 'a.BODY2')
                    ->where('a.cardId', $cardId)->first();
        if($info->typeClass == 8 && $abilitys && $abilitys->exObject){
            $exName = DB::table('pm_card_title')->where('title_en', $abilitys->exObject)->select("title".$han." as title")->first();
            $abilitys->exObject = $exName->title?$exName->title:$abilitys->exObject;
        }
        $rules = null;
        $rule1 = null;
        $rule2 = null;
        if($info->ruleId){
            //$arr = explode(",", $abilitys->exId);
            $rule1 = DB::table('pm_rule')->select("id", "title".$han.' as title',"content".$han.' as content')->where(function($query) use($info) {  
                if($info->ruleId == 2){
                    $query->whereIn('id', [$info->ruleId,1]);
                }else{
                    $query->where('id', $info->ruleId);
                }
            })->get();
        }
        if($abilitys && $abilitys->exId){
            $arr = explode(",", $abilitys->exId);
            $rule2 = DB::table('pm_rule')->select("id", "title".$han.' as title',"content".$han.' as content')->whereIn('id', $arr)->get();
        }

        $power = DB::table('pm_ability_power as p')
                ->leftJoin('pm_power_title as t', 'p.title', '=', 't.id')
                ->leftJoin('pm_power_content as c', 'p.content', '=', 'c.id')
                ->select('p.id', 'p.cardId', 'p.cost', 'p.damage', 't.title'.$han.' as title', 'c.content'.$han.' as content', 't.title_en', 'c.content_en')
                ->where('p.cardId', $cardId)->orderBy('p.id')->get();

        $relateds = null;
        if($info->pmId){
            $relateds = DB::table('pm_card as c')
                ->leftJoin('pm_card_title as t', 'c.titleId', '=', 't.id')
                ->leftJoin('pm_subcategory as s', 'c.subcategory', '=', 's.id')
                ->select('c.pkmId', 'c.pmId', 't.title'.$han.' as title','t.title_en', 'c.img', 's.symbol')
                ->whereIn('c.pmId', explode(",",$info->pmId))
                ->where('c.cardId', '<>', $info->cardId)
                ->where('s.status', 1)
                ->orderBy('s.releaseDate', 'desc')
                ->get();
        }
        return view('card.card',[ 'info' => $info, 'rule1' => $rule1, 'rule2' => $rule2, 'abilitys' => $abilitys, 'power' => $power, 'relateds' => $relateds ]);
    }

    function search(){
        $lang = (App::getLocale() === "zh-cmn-Hant") ? "name_t as name" : "name";
        $list = DB::table('pm_subcategory')->where("status", 1)->orderBy("releaseDate", "desc")->select('id', 'symbol', 'releaseDate', $lang, 'series')->get();
        return view('card.search', [ 'list' => $list ]);
    }

    public function result(){
        $han = (App::getLocale() === "zh-cmn-Hant") ? "_t" : "";
        $para = array();

        $pm_title_lang = request('pm_title_lang');
        $pm_title_lang = inject_check($pm_title_lang);
        if($pm_title_lang) $para['pm_title_lang'] = $pm_title_lang;

        $pm_title = request('pm_title');
        if($pm_title) $para['pm_title'] = $pm_title;
        //$pm_power_content = request('pm_power_content');
        //Energy
        $pm_energy = request('pm_energy');
        if($pm_energy) $para['pm_energy'] = $pm_energy;
        //Pokemon Type
        //$pm_pokemon_type = request('pm_pokemon_type');
        //if($pm_pokemon_type) $para['pm_pokemon_type'] = $pm_pokemon_type;
        //HP
        $pm_hp_from = request('pm_hp_from');
        if($pm_hp_from){ $para['pm_hp_from'] = $pm_hp_from; }
        else{ $pm_hp_from = 30; }
        $pm_hp_to = request('pm_hp_to');
        if($pm_hp_to){ $para['pm_hp_to'] = $pm_hp_to; }
        else{$pm_hp_to = 250;}
        //Weakness
        $pm_weakness = request('pm_weakness');
        if($pm_weakness) $para['pm_weakness'] = $pm_weakness;
        //Resistance
        $pm_resistance = request('pm_resistance');
        if($pm_resistance) $para['pm_resistance'] = $pm_resistance;
        //Retreat
        $pm_retreat_from = request('pm_retreat_from');
        if($pm_retreat_from){ $para['pm_retreat_from'] = $pm_retreat_from; }
        else{ $pm_retreat_from = 0; }
        $pm_retreat_to = request('pm_retreat_to');
        if($pm_retreat_to){ $para['pm_retreat_to'] = $pm_retreat_to; }
        else{ $pm_retreat_to = 5; }
        //type
        $pm_type = request('pm_type');
        if($pm_type) $para['pm_type'] = $pm_type;
        //category
        $pm_category = request('pm_category');
        if($pm_category) $para['pm_category'] = $pm_category;

        $list = DB::table('pm_card as c')
            ->leftJoin('pm_subcategory as s', 'c.subcategory', '=', 's.id')
            ->leftJoin('pm_card_title as t', 'c.titleId', '=', 't.id')
            ->leftJoin('pm_description as d', 'c.cardId', '=', 'd.cardId')
            ->leftJoin('pm_card_type_class as tc', 'c.typeClass', '=', 'tc.id')
            ->select('c.pkmId', 't.title'.$han.' as title', 'c.img', 's.name'.$han.' as cate', 'tc.name'.$han.' as tc', 'd.energy', 'd.hp')
            ->where('s.status', 1)
            ->when($pm_title, function ($query) use ($pm_title, $han, $pm_title_lang) {
                if($pm_title_lang){
                    return $query->where('t.title_en', 'like', '%'.$pm_title.'%');
                }else{
                    return $query->where('t.title'.$han, 'like', '%'.$pm_title.'%');
                }
            })
            ->when($pm_energy, function ($query) use ($pm_energy) {
                $e = implode(",", $pm_energy);
                return $query->whereRaw('(d.ene1 in ('.$e.') or d.ene2 in ('.$e.'))');
            })
            ->when(($pm_hp_from != 30 || $pm_hp_to != 250), function ($query) use ($pm_hp_from, $pm_hp_to) {
                return $query->whereBetween('d.hp', [$pm_hp_from, $pm_hp_to]);
            })
            ->when($pm_weakness, function ($query) use ($pm_weakness) {
                $e = implode("|", $pm_weakness);
                return $query->whereRaw('weakness regexp\''.$e.'\'');
            })
            ->when($pm_resistance, function ($query) use ($pm_resistance) {
                $e = implode("|", $pm_resistance);
                return $query->whereRaw('resistance regexp\''.$e.'\'');
            })
            ->when(($pm_retreat_from != 0 || $pm_retreat_to != 5), function ($query) use ($pm_retreat_from, $pm_retreat_to) {
                return $query->whereBetween('d.retreat', [$pm_retreat_from, $pm_retreat_to]);
            })
            ->when($pm_type, function ($query) use ($pm_type) {
                return $query->whereIn('c.typeClass', $pm_type);
            })
            ->when($pm_category, function ($query) use ($pm_category) {
                return $query->whereIn('s.id', $pm_category);
            })
            ->orderBy('s.releaseDate', 'desc')
            ->orderBy('c.subId', 'asc')
            ->paginate(24);

        $list->appends($para);
        return view('card.list', [ 'list' => $list, 'thumb' => session('show') ]);
    }
}