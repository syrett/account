<?php
/**
 * Created by PhpStorm.
 * User: pdwjun
 * Date: 2015/3/11
 * Time: 11:39
 */

/*
 * 数字前补0
 */
function AddZero($num, $length){
    return substr(strval($num + $length), 1);
}