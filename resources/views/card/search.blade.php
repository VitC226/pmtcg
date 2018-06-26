@extends('layouts.app')
@section('seo')
<meta name="keywords" content="pokemon,精灵宝可梦,宝可梦,口袋妖怪,宠物小精灵,神奇宝贝,卡牌,卡牌游戏,精灵宝可梦卡牌,口袋妖怪卡牌,神奇宝贝卡牌,集换式卡牌游戏,精灵宝可梦卡牌中文网">
<meta name="description" content="精灵宝可梦卡牌中文网，提供最新卡牌中文数据库查询。">
<title>卡片搜索-精灵宝可梦卡牌中文网</title>
@endsection
@section('style')
<link href="{{ asset('css/pokemon.css') }}" rel="stylesheet">
<link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
<link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet">
<link href="{{ asset('css/ion.rangeSlider.skinNice.css') }}" rel="stylesheet">
<style>
    .panel ul{ list-style: none; padding-bottom: 0px; margin-bottom: 8px; }
    .panel li{ display: inline-block; margin-right: 10px; margin-bottom: 10px; padding: 5px; border: 1px solid #ccc; }
    .checkbox-inline+.checkbox-inline, .radio-inline+.radio-inline {margin-left: 0px;margin-right: 5px;}
</style>
@endsection
@section('script')
<script src="{{ asset('js/ion.rangeSlider.min.js') }}"></script>
<script>
    $(function(){
        $("#title_lang").on("click", function(){
            if($(this).text() == "En"){
                $(this).text("中");
                $("#pm_title_lang").val("");
                $("#pm_title").attr("placeholder","请输入中文卡片名");
            }else{
                $(this).text("En");
                $("#pm_title_lang").val("en");
                $("#pm_title").attr("placeholder","请输入英文卡片名");
            }
        });
        $("#pm_hp").ionRangeSlider({
            min: 30,
            max: 250,
            type: 'double',
            step: 10,
            prettify: true,
            onFinish: function (data) {
                var from = (data.from != data.min)?data.from:"";
                $("input[name='pm_hp_from']").val(from);
                var to = (data.to != data.max)?data.to:"";
                $("input[name='pm_hp_to']").val(to);
            }
        });
        $("#pm_retreat").ionRangeSlider({
            min: 0,
            max: 5,
            type: 'double',
            step: 1,
            prettify: true,
            onFinish: function (data) {
                var from = (data.from != data.min)?data.from:"";
                $("input[name='pm_retreat_from']").val(from);
                var to = (data.to != data.max)?data.to:"";
                $("input[name='pm_retreat_to']").val(to);
            }
        });
        $("#typeelse").on("click",function(){
            $(".typeelse").attr("checked",$(this).is(":checked"));
        });
    });
</script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <form action="/result" method="GET" action="{{ url('/result',[request()->route('customer_type')])}}">
            <div class="col-md-7">
                <h4 class="block-title">基本信息</h4>
                <div class="block-content">
                    <div class="form-group">
                        <label for="pm_title">{{trans('website.cardName')}}</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="title_lang">中</button>
                            </span>
                            <input type="hidden" id="pm_title_lang" name="pm_title_lang" value="">
                            <input type="text" class="form-control" id="pm_title" name="pm_title" placeholder="请输入中文卡片名">
                        </div>
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="pm_power_content">技能描述</label>
                        <input type="text" class="form-control" id="pm_power_content" name="pm_power_content" placeholder="" />    
                    </div> -->
                </div>
                    <h4 class="block-title">{{trans('website.cardPokemon')}}</h4>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pm_weakness">{{trans('website.cardEnergy')}}</label>
                            <div class="form-group" role="group" for="pm_energy[]">
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="1" name="pm_energy[]"> <i class="energy energy-grass"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="2" name="pm_energy[]"> <i class="energy energy-fire"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="3" name="pm_energy[]"> <i class="energy energy-water"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="4" name="pm_energy[]"> <i class="energy energy-lightning"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="5" name="pm_energy[]"> <i class="energy energy-psychic"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="6" name="pm_energy[]"> <i class="energy energy-fighting"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="7" name="pm_energy[]"> <i class="energy energy-darkness"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="8" name="pm_energy[]"> <i class="energy energy-metal"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="9" name="pm_energy[]"> <i class="energy energy-colorless"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="10" name="pm_energy[]"> <i class="energy energy-fairy"></i>
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="11" name="pm_energy[]"> <i class="energy energy-dragon"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group" for="pm_type[]">
                                <label>{{trans('website.cardType')}}</label>
                                <div class="form-group" role="group">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="2" name="pm_type[]"> {{trans('website.cardType2')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="10" name="pm_type[]"> {{trans('website.cardType10')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="11" name="pm_type[]"> {{trans('website.cardType11')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="18" name="pm_type[]"> {{trans('website.cardType18')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="7" name="pm_type[]"> {{trans('website.cardType7')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="5" name="pm_type[]"> MEGA
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="3" name="pm_type[]"> BREAK
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="8" name="pm_type[]"> {{trans('website.cardType8')}}
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="6" name="pm_type[]"> {{trans('website.cardType6')}}
                                    </label>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="pm_hp">HP</label>
                                <input name="pm_hp_from" type="hidden" value="" />
                                <input name="pm_hp_to" type="hidden" value="" />
                                <input id="pm_hp" type="text" />
                            </div>
                            <div class="form-group">
                                <label for="pm_retreat">{{trans('website.retreat')}}</label>
                                <input name="pm_retreat_from" type="hidden" value="" />
                                <input name="pm_retreat_to" type="hidden" value="" />
                                <input type="text" id="pm_retreat" />    
                            </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pm_weakness">{{trans('website.weakness')}}</label>
                            <div class="form-group" role="group" for="pm_weakness[]">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="grass" name="pm_weakness[]"> <i class="energy energy-grass"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fire" name="pm_weakness[]"> <i class="energy energy-fire"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="water" name="pm_weakness[]"> <i class="energy energy-water"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="lightning" name="pm_weakness[]"> <i class="energy energy-lightning"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="psychic" name="pm_weakness[]"> <i class="energy energy-psychic"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fighting" name="pm_weakness[]"> <i class="energy energy-fighting"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="darkness" name="pm_weakness[]"> <i class="energy energy-darkness"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="metal" name="pm_weakness[]"> <i class="energy energy-metal"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="colorless" name="pm_weakness[]"> <i class="energy energy-colorless"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fairy" name="pm_weakness[]"> <i class="energy energy-fairy"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="dragon" name="pm_weakness[]"> <i class="energy energy-dragon"></i>
                                    </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                                <label for="pm_resistance">{{trans('website.resistance')}}</label>
                                <div class="form-group" role="group" for="pm_resistance[]">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="grass" name="pm_resistance[]"> <i class="energy energy-grass"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fire" name="pm_resistance[]"> <i class="energy energy-fire"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="water" name="pm_resistance[]"> <i class="energy energy-water"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="lightning" name="pm_resistance[]"> <i class="energy energy-lightning"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="psychic" name="pm_resistance[]"> <i class="energy energy-psychic"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fighting" name="pm_resistance[]"> <i class="energy energy-fighting"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="darkness" name="pm_resistance[]"> <i class="energy energy-darkness"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="metal" name="pm_resistance[]"> <i class="energy energy-metal"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="colorless" name="pm_resistance[]"> <i class="energy energy-colorless"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="fairy" name="pm_resistance[]"> <i class="energy energy-fairy"></i>
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="dragon" name="pm_resistance[]"> <i class="energy energy-dragon"></i>
                                    </label>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="side-block">
                            <h4 class="block-title">{{trans('website.cardTrainer')}}</h4>
                            <div class="block-content">
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type12" value="12">    
                                    <label for="type12">{{trans('website.cardType12')}}</label>
                                </div>
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type13" value="13">    
                                    <label for="type13">{{trans('website.cardType13')}}</label>
                                </div>
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type14" value="14">    
                                    <label for="type14">支援</label>
                                </div>
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type15" value="15">    
                                    <label for="type15">{{trans('website.cardType15')}}</label>
                                </div>
                                <div class="youplay-checkbox">
                                    <input type="checkbox" id="typeelse">
                                    <input type="checkbox" name="pm_type[]" class="typeelse hide" value="16">
                                    <input type="checkbox" name="pm_type[]" class="typeelse hide" value="17">
                                    <label for="typeelse">其他</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="side-block">
                            <h4 class="block-title">能量卡</h4>
                            <div class="block-content">
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type1" value="1">    
                                    <label for="type1">基本能量</label>
                                </div>
                                <div class="youplay-checkbox">
                                    <input type="checkbox" name="pm_type[]" id="type9" value="9">    
                                    <label for="type9">特殊能量</label>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-5">
                <h4>{{trans('website.subcategory')}}</h4>
                <div class="panel-group">
                    <?php $i = ""; $now = "1"; $count=0; $first = true; ?>
                    @foreach ($list as $item)
                        <?php 
                        $now = $item->series;
                        if($now != $i){
                            $in = "";
                            if($first){
                                $first = false;
                                $in = " in";
                            }else{
                                echo '</ul></div></div>';
                            }
                            $count++;
                            $i = $now;
                            echo '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title" data-toggle="collapse" href="#collapse'.$i.'">'.$i.'系列</h4></div><div id="collapse'.$i.'" class="panel-collapse collapse'.$in.'"><ul class="panel-body">';
                        }
                         ?>
                        <li><label class="checkbox-inline"><input type="checkbox" value="{{ $item->id }}" name="pm_category[]">{{ $item->name }}</label>
                        </li>
                    @endforeach
                    <?php 
                        if($count != 0){
                            echo '</ul></div></div>';
                        }
                     ?>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">{{trans('website.search_button')}}</button>
            </div>
        </form>
    </div>
</div>
@endsection