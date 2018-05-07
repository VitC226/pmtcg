<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $list = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card_title.title', 'pm_card.img', 'pm_subcategory.name as cate', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp')
                ->orderBy('pm_subcategory.releaseDate', 'desc')
                ->orderBy('pm_card.cardId', 'asc')->when($cate, function ($query) use ($cate) {
                    return $query->where('pm_subcategory.symbol', $cate);
                })->paginate(25);
        return view('card.list', [ 'list' => $list ]);
    }

    public function card($card){
        if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$card)){
            return view('card.error');
        }
        $info = DB::table('pm_card')
                ->leftJoin('pm_subcategory', 'pm_card.subcategory', '=', 'pm_subcategory.id')
                ->leftJoin('pm_card_title', 'pm_card.titleId', '=', 'pm_card_title.id')
                ->leftJoin('pm_description', 'pm_card.cardId', '=', 'pm_description.cardId')
                ->leftJoin('pm_card_type', 'pm_card.type', '=', 'pm_card_type.id')
                ->leftJoin('pm_card_type_class', 'pm_card.typeClass', '=', 'pm_card_type_class.id')
                ->leftJoin('pm_energy', 'pm_description.energy', '=', 'pm_energy.id')
                ->leftJoin('pm_illustrator', 'pm_card.illustrator', '=', 'pm_illustrator.id')
                ->select('pm_card.cardId', 'pm_card.pkmId', 'pm_card.pmId', 'pm_card_title.title', 'pm_card.img', 'pm_card.type', 'pm_card_type.name as typeName', 'pm_subcategory.name as cate', 'pm_card.rarity', 'pm_card_type_class.name as tc', 'pm_energy.name as energyName', 'pm_description.hp', 'pm_description.lv', 'pm_description.evolve_en as evolve', 'pm_description.weakness', 'pm_description.resistance', 'pm_description.retreat', 'pm_subcategory.name as illustratorName')
                ->where('pm_card.img', $card)->first();
        if(!$info){ return view('card.error'); }
        $cardId = $info->cardId;
        $abilitys = DB::table('pm_ability as a')
                    ->leftJoin('pm_power_title as t', 'a.abilitytitle', '=', 't.id')
                    ->leftJoin('pm_power_content as c', 'a.abilitycontent', '=', 'c.id')
                    ->leftJoin('pm_power_title as t2', 'a.bodytitle', '=', 't2.id')
                    ->leftJoin('pm_power_content as c2', 'a.bodycontent', '=', 'c2.id')
                    ->leftJoin('pm_rule as r', 'a.exId', '=', 'r.id')
                    ->select('t.title as abilityName', 'c.content as abilityContent', 'a.restored', 'a.exId', 'a.exObject', 'r.title as ruleName', 'r.content as ruleContent', 't2.title as bodyName','c2.content as bodyContent', 'a.LV', 'a.BODY2')
                    ->where('a.cardId', $cardId)->first();

        $rules = null;
        if($abilitys && $abilitys->exId){
            $arr = explode(",", $abilitys->exId);
            $rules = DB::table('pm_rule')->whereIn('id', $arr)->get();
        }

        $power = DB::table('pm_ability_power as p')
                ->leftJoin('pm_power_title as t', 'p.title', '=', 't.id')
                ->leftJoin('pm_power_content as c', 'p.content', '=', 'c.id')
                ->select('p.id', 'p.cardId', 'p.cost', 'p.damage', 't.title', 'c.content', 't.title_en', 'c.content_en')
                ->where('p.cardId', $cardId)->orderBy('p.id')->get();
        return view('card.card',[ 'info' => $info, 'rule' => $rules, 'abilitys' => $abilitys, 'power' => $power ]);
    }
}
