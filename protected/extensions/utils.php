<?php

function beTranPrefix($year, $month)
{
  if($year==null || $month==null)
    return date('Y').date('m');
  else
    return date("Ym", mktime(0,0,0,$month,01,$year));
}