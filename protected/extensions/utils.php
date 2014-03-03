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
    return substr($date, 4, 2);
}
function getYearMon($date){
    return substr($date, 0, 6);
}
function getDay($date){
    return substr($date, 6, 2);
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

function balance($last_balance, $debit, $credit, $sbj_cat)
{
  switch($sbj_cat)
    {
    case 1: //资产类
      return $last_balance + $debit - $credit;
      break;
    case 2: //负债类
      return $last_balance + $credit - $debit;
      break;
    case 3: //权益类
      return $last_balance + $credit - $debit;
      break;
    case 4: //收入类
      return $credit - $debit;
      break;
    case 5: //费用类
      return $debit - $credit;
      break;
    default:
      return 0;
      break;
    }
}
function menuIsActive($arrs, $str, $id){
    if($str == 'options4' ){
        if(isset($_REQUEST['operation'])&&in_array($_REQUEST['operation'], $arrs)){
        return true;
    }
    else
    {
        return $id=='subjects'?true:false;
    }
        return false;


}