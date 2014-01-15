<?php

function beTranPrefix($year, $month)
{
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