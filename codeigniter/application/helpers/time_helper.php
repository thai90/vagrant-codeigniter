<?php
function convertTime($timeStamp){
    $now = new DateTime();
    $checkDate = new DateTime($timeStamp);
    $diff = $now->diff($checkDate);

    if($diff->d >0){
        return $diff->d.'日ぐらい前';
    }

    if($diff->h > 0){
        return $diff->h."時ぐらい前";
    }

    if($diff->i > 0){
        return $diff->i."分ぐらい前";
    }

    return $diff->s."秒ぐらい前";
}

function convertTimeArr ($arrayItem, $timeIndexName){
    for($i = 0; $i < sizeof($arrayItem); $i++){
        $arrayItem[$i][$timeIndexName] = convertTime($arrayItem[$i][$timeIndexName]);
    }
    return $arrayItem;
}
?>