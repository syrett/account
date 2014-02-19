<?php

function beTranPrefix($year, $month)
{
  if($year==null || $month==null)
    return date('Y').date('m');
  else
    return date("Ym", mktime(0,0,0,$month,01,$year));
}
function getYear($date){
    return substr($date, 0, 4);
}
function getMon($date){
    return substr($date, 4, 6);
}
function getYearMon($date){
    return substr($date, 0, 6);
}
function getDay($date){
    return substr($date, 6, 8);
}
function accessReview($tranID){
    $user = Yii::app()->user->id;
    $access = Transition::model()->findByAttributes(array('id'=>$tranID,'entry_editor'=>$user));
    if(empty($access))
        return true;
    else
        return false;
}
function accessSettle($tranID){
    $list= Yii::app()->db
        ->createCommand("select * from transition where id=$tranID and (entry_posting=1 or entry_closing=1)")->queryAll();
    if(!empty($list))
        return false;
    else
        return true;
}