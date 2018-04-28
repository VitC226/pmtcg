<?php

function energy($value=''){
    return "<i class='energy energy-".$value."'>".$value."</i>";
}

/* 翻译专用 */
function analysis($value=''){
    $arr = explode('.',str_replace(array(","),'.',$value));
    foreach ($arr as $key => $item) {
        if($item == ""){ array_splice($arr,$key); }
        else{ $arr[$key] = substr($value,strpos($value, $item),strlen($item)+1); }
    }

    //检查是否存在模板

    //向数据库查询翻译文本

    dump($arr);
}