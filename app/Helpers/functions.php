<?php

use Illuminate\Support\Facades\DB;

function energy($value){
    if($value == "") return;
    $arr = explode(",",strtolower($value));
    $energyList = array("","grass","fire","water","lightning","psychic","fighting","darkness","metal","colorless","fairy","dragon");
    if(count($arr)>0){
        foreach($arr as $energy){
            if (is_numeric($energy)) {
                echo '<i class="energy energy-'.$energyList[$energy].'"></i>';
            }
            else{ echo '<i class="energy energy-'.$energy.'"></i>'; }
        }
    }
}

function iconFont($str){
    $str = str_replace('◇', '<i class="icon font_family icon-star"></i>', $str);
    if(strstr($str,"[")){
        $str = str_replace('[','<i>',$str);
        $str = str_replace(']', '</i>', $str);
    }
    $patternEnergy = "/(?:\{[Gg]rass\}|\{[Ff]ire\}|\{[Ww]ater\}|\{[Ll]ightning\}|\{[Pp]sychic\}|\{[Ff]ighting\}|\{[Dd]arkness\}|\{[Mm]etal\}|\{[Cc]olorless\}|\{[Ff]airy\}|\{[Dd]ragon\})/";
    preg_match_all($patternEnergy,$str ,$temp);
    if($temp[0]){
        $temp = $temp[0];
        foreach ($temp as $item) {
            $text = str_replace('{','<i class="icon font_family icon-',strtolower($item));
            $text = str_replace('}', '"></i>', $text);
            $str = str_replace($item, $text, $str);
        }
    }
    echo($str);
}

function contentEnergy($str){
    $str = str_replace('◇', '<img src=../img/star.png alt=棱镜之星>', $str);
    if(strstr($str,"[")){
        $str = str_replace('[','<i>',$str);
        $str = str_replace(']', '</i>', $str);
        echo $str;
        return;
    }
    $patternEnergy = "/(?:\{[Gg]rass\}|\{[Ff]ire\}|\{[Ww]ater\}|\{[Ll]ightning\}|\{[Pp]sychic\}|\{[Ff]ighting\}|\{[Dd]arkness\}|\{[Mm]etal\}|\{[Cc]olorless\}|\{[Ff]airy\}|\{[Dd]ragon\})/";
    preg_match_all($patternEnergy,$str ,$temp);
    if($temp[0]){
        $temp = $temp[0];
        foreach ($temp as $item) {
            $text = str_replace('{','<i class="energy energy-',strtolower($item));
            $text = str_replace('}', '"></i>', $text);
            $str = str_replace($item, $text, $str);
        }
    }
    echo($str);
}

function contentRule($str, $replace){
    $str = str_replace("????", $replace, $str);
    echo($str);
}

function LEGEND($str, $replace, $obj){
    if($obj){
        $var=explode("。",$str); 
        $str = $var[0]."。";
    }
    $str = str_replace("????", $replace, $str);
    echo($str);
}

function statLoad($str){
    if($str == "") return;
    $temp = "";
    $str = strtolower(trim($str));
    if(strlen($str) > 1){
        $patternEnergy = "/\b(grass|fire|water|lightning|psychic|fighting|darkness|metal|colorless|fairy|dragon)\b/";
        preg_match_all($patternEnergy,$str,$temp);
        $temp = $temp[0];
        foreach ($temp as $item) {
            $html = '<i class="energy energy-'.$item.'"></i>';
            $str = str_replace($item, $html, $str);
        }
        $temp = $str;
        
        if(strpos($temp,",")){
            $temp = str_replace(',','',$str);
        }/*
        else if(!strpos($str," ")){
            $temp = '<i class="energy energy-'.$str.'"></i>';
        }else{
            $temp = '<i class="energy energy-'.str_replace(' ','"></i> ',$str);
        }*/
    }
    else{
        $preg = intval($str);
        for($i=0;$i<$preg;$i++){
            $temp = $temp.'<i class="energy energy-colorless"></i>';
        }
    }
    echo $temp;
}

function pokemonIcon($str){
    $temp=explode(",",$str);
    foreach ($temp as $item) {
        echo '<span class="pokemon-icon pokemon-icon-'.$item.'"></span>';
    }
}


/* 翻译专用 */
function analysis($value=''){
    $arr = explode('.',str_replace(array(","),'.',$value));
    $rules = [];
    foreach ($arr as $key => $item) {
        if($item == ""){ array_splice($arr,$key); }
        else{
            $int = (strpos($item,'(') !==false)?2:1;
            $text = substr($value,strpos($value, $item),strlen($item)+$int);
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

            if(strpos($text,'0 ') !==false){
                $pattern = '/\d+0/';
                $new = preg_replace($pattern,"[0-9]*",$text);
                $rules[$key] = $new;
                continue;
            }

        }
    }
    $html = "<div class='box'>";
    foreach ($rules as $key => $item) {

        $tran = DB::table('translator')->where("key", $item)->first();
        
        if($tran){
            $html .= '<h5 data-id="'.$tran->id.'">'.$tran->id.'<button type="button" class="btn btn-primary btn-xs">提交</button></h5><ul class="list-group"><li class="list-group-item key" data-value="'.$arr[$key].'">'.$arr[$key].'</li><li class="list-group-item"><input type="text" placeholder="规则" class="form-control" value="'.$tran->rule.'"></li><li class="list-group-item"><input type="text" placeholder="正则" class="form-control" value="'.$tran->php.'"></li><li class="list-group-item"><input type="text" placeholder="翻译" class="form-control" value="'.$tran->text.'"></li></ul>';
        }else{
            /*$dd = DB::table('translator')->insert([
                'key' => $arr[$key],
            ]);
            print_r($dd);*/
            $html .= '<h5 data-id="">new<button type="button" class="btn btn-primary btn-xs">提交</button></h5><ul class="list-group"><li class="list-group-item" data-value="'.$rules[$key].'">'.$rules[$key].'</li><li class="list-group-item"><input type="text" placeholder="规则" class="form-control" value=""></li><li class="list-group-item"><input type="text" placeholder="正则" class="form-control" value=""><li class="list-group-item"><input type="text" placeholder="翻译" class="form-control" value=""></li></ul>';
        }
    }
    $html.="</div>";
    //检查是否存在模板，没有则创建
    //向数据库查询翻译文本
    return $html;
}

function inject_check($get) {
    $checkurl=preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|or|and|-|<|>|&|%|limit|where|oR|aNd/i', $get);//要匹配的字符
    if($checkurl){
        $get = "";
    }
    return $get;
}


function checkName($str){
    if(strpos($str,"-")>-1){
        $str = str_replace("-"," ",$str);
    }
    $arr = explode(' ', $str);
    $html = "";
    foreach ($arr as $key => $value) {
        if($value == "Ultra"){
            $html .= "究极";
        }else if($value == "Alolan"){
            $html .= "阿罗拉";
        }
        else{
            if(strlen($value) > 3){
                $name = DB::table("pm_pokemon")->where("name", $value)->first();
                if($name){
                    $html .= $name->name_cn;
                }else{
                    $html .= $value." ";
                }
            }else{
                if($value == "GX"){
                    $html .= "-";
                }
                $html .= $value;
            }
        }   
    }
    echo $html;
}

function test(){
    /*
    $list = DB::select("select id,energy from pm_description where energy is not null");
    //dump($list);
    foreach ($list as $item) {
        
        if(strpos($item->energy,',')===false){
            DB::table('pm_description')->where('id', $item->id)->update(['ene1' => $item->energy]);
        }else{
            $arr = explode(",",$item->energy);
            DB::table('pm_description')->where('id', $item->id)->update(['ene1' => $arr[0], 'ene2' => $arr[1]]);
        }
    }*/
}

function  hello(){

/*
    $content = "If you have Azelf in play, your opponent’s Pokémon in play have no Resistance.";
    $rule = "If % is your Active Pokémon and is damaged by an opponent's attack (even if % is Knocked Out), "; 
    $php = "If (.*?) is your Active Pokémon and is damaged by an opponent's attack (even if (.*?) is Knocked Out), ";
    $text = "当该宝可梦为己方出战宝可梦并且受到对方宝可梦的技能伤害时，";
//从弃牌区选择最多4张{Lightning}能量卡放置到该宝可梦身上。
//该宝可梦陷入混乱状态。
//从卡组搜索最多3张宝可梦道具卡，一只宝可梦，。
//移除己方后场所有宝可梦身上的3个伤害指示物。
//追加该宝可梦身上的{Water}能量卡数量×10点伤害。         
//该卡需要凑齐另一部分的「尼多兰♀」才能从手牌放置到后场上。当该宝可梦被击败时，对方抽2张奖品卡。
己方回合开始时， if Elekid is anywhere under Electivire, you may move a <span class="energy-symbol Lightning" title="Lightning">Lightning</span> Energy attached to 1 of your Pokémon to Electivire. 该宝可梦陷入异常状态时无法使用该特殊能力。
The attack cost of your Nidoran ♀, Nidorina, Nidoran ♂, Nidorino, and Nidoking's attack is <span class="energy-symbol Colorless" title="Colorless">Colorless</span> less.
If you have the same number of or less Benched Pokémon than your opponent, 
As long as the Defending Pokémon's remaining HP is 60 or less, 当受到该技能攻击的对方宝可梦的剩余HP不超过60点时，
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
                        //dump($newTemp);
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
                    if($newTemp != ""){
                        $newTemp = str_replace($str,$newTemp,$content);
                    }else{
                        $newTemp = str_replace($str,$text,$content);
                    }
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