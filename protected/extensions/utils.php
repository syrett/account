<?php

function beTranPrefix($year, $month)
{
    if ($year == null || $month == null)
        return date('Y') . date('m');
    else
        return date("Ym", mktime(0, 0, 0, $month, 01, $year));
}

function getYear($date)
{
    return substr($date, 0, 4);
}

function getMon($date)
{
    return substr($date, 4, 2);
}

function getYearMon($date)
{
    return substr($date, 0, 6);
}

function getDay($date)
{
    return substr($date, 6, 2);
}

function accessReview($tranID)
{
    $user = Yii::app()->user->id;
    $access = Transition::model()->findByAttributes(array('id' => $tranID, 'entry_editor' => $user));
    if (empty($access))
        return true;
    else
        return false;
}

function accessSettle($tranID)
{
    $list = Yii::app()->db
        ->createCommand("select * from transition where id=:tranID and (entry_posting=1 or entry_closing=1)")->bindParam(":tranID", $tranID)->queryAll();
    if (!empty($list))
        return false;
    else
        return true;
}

function balance($last_balance, $debit, $credit, $sbj_cat)
{
    $balance = 0;
    switch ($sbj_cat) {
        case 1: //资产类
            $balance = $last_balance + $debit - $credit;
            break;
        case 2: //负债类
            $balance = $last_balance + $credit - $debit;
            break;
        case 3: //权益类
            $balance = $last_balance + $credit - $debit;
            break;
        case 4: //收入类
            $balance = $credit - $debit;
            break;
        case 5: //费用类
            $balance = $debit - $credit;
            break;
        default:
            $balance = 0;
            break;
    }
    return number_format($balance, 2, '.', '');
}

function balance2($last_balance, $debit, $credit, $sbj_cat,$settlement=1)
{
    switch ($sbj_cat) {
        case 5: //费用类
            $balance = $last_balance + $debit - ($settlement==0?$credit:0);
            break;
        case 1: //资产类
            $balance = $last_balance + $debit - $credit;
            break;
        case 4: //收入类
            $balance = $last_balance + $credit - ($settlement==0?$debit:0);
            break;
        case 2: //负债类
            $balance = $last_balance + $credit - $debit;
            break;
        case 3: //权益类
            $balance = $last_balance + $credit - $debit;
            break;
        default:
            $balance = 0;
            break;
    }
    return number_format($balance, 2, '.', '');
}

function menuIsActive($arrs, $str, $id)
{
    if ($str == 'options4') {
        if (isset($_REQUEST['operation']) && in_array($_REQUEST['operation'], $arrs)) {
            return true;
        } else {
            return $id == 'subjects' ? true : false;
        }
        return false;
    }
}

function UpAmount($num)
{
    /**
     *数字金额转换成中文大写金额的函数
     *String Int $num 要转换的小写数字或小写字符串
     *return 大写字母
     *小数位为两位
     **/
    $c1 = "零壹贰叁肆伍陆柒捌玖";
    $c2 = "分角元拾佰仟万拾佰仟亿";
    $num = round($num, 2);
    $num = $num * 100;
    if (strlen($num) > 10) {
        return "数据太长，没有这么大的钱吧，检查下";
    }
    $i = 0;
    $c = "";
    while (1) {
        if ($i == 0) {
            $n = substr($num, strlen($num) - 1, 1);
        } else {
            $n = $num % 10;
        }
        $p1 = substr($c1, 3 * $n, 3);
        $p2 = substr($c2, 3 * $i, 3);
        if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
            $c = $p1 . $p2 . $c;
        } else {
            $c = $p1 . $c;
        }
        $i = $i + 1;
        $num = $num / 10;
        $num = (int)$num;
        if ($num == 0) {
            break;
        }
    }
    $j = 0;
    $slen = strlen($c);
    while ($j < $slen) {
        $m = substr($c, $j, 6);
        if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
            $left = substr($c, 0, $j);
            $right = substr($c, $j + 3);
            $c = $left . $right;
            $j = $j - 3;
            $slen = $slen - 3;
        }
        $j = $j + 3;
    }

    if (substr($c, strlen($c) - 3, 3) == '零') {
        $c = substr($c, 0, strlen($c) - 3);
    }
    if (empty($c)) {
        return "零元整";
    } else {
        return $c . "整";
    }

}

function checkAmount($amount)
{
    $reg = "/-?[1-9]?\d*\.?\d?\d?|-?0\.\d?\d?/";
    preg_match($reg, $amount, $arr);
    $result = $arr[0];
    //不知道为什么，这样会报错
//  if( $arr[0] == $amount)
    if ($result == $amount)
        return true;
    else
        return false;
}

/*
 * 将日期转换为yyyymd的格式
 */
function convertDate($date, $format='')
{
    $date = $date!= ''?(string)$date:date('Ymd');
    $date = str_replace('\/','',trim($date));
    $date = str_replace('\\','',$date);
    $date = str_replace('-','',$date);
    $date = str_replace('.','',$date);
    if($format=='')
        $format = 'Ymd';
    $length = strlen($date);
    if ($length < 5)   //2015
        return $date.'0101';
    elseif($length == 6)
        $date .= '01';
    try{
        $d = new DateTime($date);
    }catch (Exception $s){
        return $date;
    }
    return $d->format($format);
}

function addZero($num, $count = 4)
{
    //默认为4位数，
    $base = pow(10, $count);
    if (strlen($num) >= $count)
        return $num;
    else
        return substr(strval($num + $base), 1, $count);
}

function round2($val){
    return sprintf("%.2f", $val);
}

function removeLang($str){
    $reg = '/&?lang=[^&]*/';
    return preg_replace($reg, '', $str);
}

function getPrevMonth($date, $format = 'Y-m-d'){
    $date = convertDate($date, 'Y-m-d');
    return date($format, strtotime('-1 month', strtotime($date)));
}
function getNextMonth($date, $format = 'Y-m-d'){
    $date = convertDate($date, 'Y-m-d');
    return date($format, strtotime('+1 month', strtotime($date)));
}