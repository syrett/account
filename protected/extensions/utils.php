<?php

function beTranPrefix($year, $month)
{
  return date("Ym", mktime(0,0,0,$month,01,$year));
}