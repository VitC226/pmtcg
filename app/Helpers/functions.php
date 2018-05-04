<?php

use Illuminate\Support\Facades\DB;

function energy($value=''){
    return "<i class='energy energy-".$value."'>".$value."</i>";
}

/* 翻译专用 */
function analysis($value=''){
    $arr = explode('.',str_replace(array(","),'.',$value));
    $rules = [];
    foreach ($arr as $key => $item) {
        if($item == ""){ array_splice($arr,$key); }
        else{ 
            $text = substr($value,strpos($value, $item),strlen($item)+1);
            $arr[$key] = $text;
            $rules[$key] = $arr[$key];
            
            $patternStatus = "/\b(Confused|Asleep|Poisoned|Paralyzed|Burned)\b/"; //是否包含状态
            preg_match_all($patternStatus,$text,$temp);
            $temp = $temp[0];
            if(count($temp)){
                $new = str_replace($temp,"*",$text);
                $rules[$key] = $new;
                continue;
            }

            $patternEnergy = "/\b(Grass|Fire|Water|Lightning|Psychic|Fighting|Darkness|Metal|Colorless|Fairy|Dragon)\b/"; //是否包含属性
            preg_match_all($patternEnergy,$text,$temp);
            $temp = $temp[0];
            if(count($temp)){
                $pattern = '/<span class="energy-symbol (.*?)" title="(.*?)">(.*?)<\/span>/';
                $new = preg_replace($pattern,"*",$text);
                $rules[$key] = $new;
                continue;
            }

        }
    }
    $html = "<div class='box'>";
    foreach ($rules as $key => $item) {

        $tran = DB::table('translator')->where("key", $item)->first();
        
        if($tran){
            $html .= '<h5 data-id="'.$tran->id.'">'.$tran->id.'<button type="button" class="btn btn-primary pull-right btn-xs">提交</button></h5><ul class="list-group"><li class="list-group-item key" data-value="'.$arr[$key].'">'.$arr[$key].'</li><li class="list-group-item"><input type="text" placeholder="规则" class="form-control" value="'.$tran->rule.'"></li><li class="list-group-item"><input type="text" placeholder="正则" class="form-control" value="'.$tran->php.'"></li><li class="list-group-item"><input type="text" placeholder="翻译" class="form-control" value="'.$tran->text.'"></li></ul>';
        }else{
            /*$dd = DB::table('translator')->insert([
                'key' => $arr[$key],
            ]);
            print_r($dd);*/
            $html .= '<h5 data-id="">new<button type="button" class="btn btn-primary pull-right btn-xs">提交</button></h5><ul class="list-group"><li class="list-group-item" data-value="'.$rules[$key].'">'.$rules[$key].'</li><li class="list-group-item"><input type="text" placeholder="规则" class="form-control" value=""></li><li class="list-group-item"><input type="text" placeholder="正则" class="form-control" value=""><li class="list-group-item"><input type="text" placeholder="翻译" class="form-control" value=""></li></ul>';
        }
    }
    $html.="</div>";
    //检查是否存在模板，没有则创建
    //向数据库查询翻译文本
    return $html;
}

function  hello(){
    /*
    $content = 'Search your deck for a <span class="energy-symbol Grass" title="Grass">Grass</span> ,<span class="energy-symbol Fighting" title="Fighting">Fighting</span><span class="energy-symbol Fighting" title="Fighting">Fighting</span> Energy card and attach it to 1 of your Pokémon.';
    $rule = "Search your deck for a % Energy card and attach it to 1 of your Pokémon\.";
    $text = "从卡组搜索1张*能量卡并放置到己方场上1只宝可梦身上，";
    $php = "[Ss]earch your deck for a (.*?) Energy card and attach it to 1 of your Pokémon[.]";
    if(strpos($rule,'%')===false){
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en REGEXP\"".$rule."\" and status is null");
            }
            else{
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en  like \"%".$rule."%\"");
            }
    $newTemp = "";
    foreach ($list as $item) {
        dump($item);
                $content = $item->content;
                $flag = true;
                $newTemp = "";
                preg_match_all("/".$php."/",$content,$str);
                if(count($str[0]) > 0){
                    $str = $str[0][0];
                    dump($str);
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
                        dump($arr);
                        $flag = false;
                        for ($i=0; $i < $count; $i+=3) {  $newTemp.= "{".$arr[$i]."}"; }
                        $newTemp = str_replace("*",$newTemp,$text);
                        dump($newTemp);
                    }

                    preg_match_all("/\d+/",$str,$arr);
                    $arr = $arr[0];
                    $count = count($arr);
                    if($count>0 && $flag){
                        $flag = false;
                        foreach ($arr as $key => $value) {
                            $newTemp.= $value;
                        }
                        $newTemp = str_replace("[0-9]*",$newTemp,$text);
                    }

                    $newTemp = str_replace($str,$newTemp,$content);
                }

                $pos1 = strpos($newTemp,".");
                $pos2 = strpos($newTemp,",");

                if($newTemp != ""){
                    if(!$pos1 && !$pos2){
                        //DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $newTemp, 'status' => 1]);
                    }else{
                        //DB::table('pm_power_content')->where('id', $item->id)->update(['content' => $newTemp]);
                    }
                    $content = $newTemp;
                }
                dump($newTemp);
                
    }*/
}