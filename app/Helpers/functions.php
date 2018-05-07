<?php

use Illuminate\Support\Facades\DB;
use App\Libs\ImageDuel;

function energy($value){
    $arr = explode(",",strtolower($value));
    $energyList = array(
        "","grass","fire","water","lightning","psychic","fighting","darkness","metal","colorless","fairy","dragon"
    );
    if(count($arr)>0){
        foreach($arr as $energy){
            if (is_numeric($energy)) {
                echo '<i class="energy icon-'.$energyList[$energy].'"></i>';
            }
            else{ echo '<i class="energy icon-'.$energy.'"></i>'; }
        }
    }
}

function contentEnergy($str){
    $str = strtolower($str);
    preg_match_all("/{(.*?)}/",$str ,$temp);
    if($temp[0]){
        $temp = $temp[0];
        foreach ($temp as $item) {
            $text = str_replace('{','<i class="energy icon-',$item);
            $text = str_replace('}', '"></i>', $text);
            $str = str_replace($item, $text, $str);
        }
    }
    echo($str);
}

function statLoad($str){
    $temp = "";
    $str = strtolower(trim($str));
    if(strlen($str) > 1){
        if(strpos($str,",")){
            $temp = str_replace(',','"></i><i class="energy icon-',$str);
            $temp = '<i class="energy icon-'.str_replace(' ','"></i> ',$temp);
        }
        else{
            $temp = '<i class="energy icon-'.str_replace(' ','"></i> ',$str);
        }
    }
    else{
        $preg = intval($str);
        for($i=0;$i<$preg;$i++){
            $temp = $temp.'<i class="energy icon-colorless"></i>';
        }
    }
    echo $temp;
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
function  hello(){
    
    $content = 'If Regice <em>ex</em> is in play, flip a coin. 如果出现正面： the Defending Pokémon is now Confused.';
    $rule = "If % is in play, ";
    $php = "If (.*?) is in play, ";
    $text = "当「*」在场上存在时，";
    if(strpos($rule,'%')===false){
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en REGEXP\"".$rule."\" and status is null");
            }
            else{
                $list = DB::select("SELECT * FROM pm_power_content WHERE content_en  like \"%".$rule."%\"");
            }
    $newTemp = "";
    //foreach ($list as $item) {
        //dump($item);
                //$content = $item->content;
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
                
    //}
}