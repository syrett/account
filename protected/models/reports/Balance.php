<?php

class Balance extends CModel
{
  public function attributeNames()
  {
    array();
  }
  
  public function genData(){
    $array = Yii::app()->params['balanceReport'];
    $sum_array = Yii::app()->params['balanceReport_sum'];

    $data=array();
    foreach($array as $i=>$value){
      if (isset($value["subjects"])) {
        $arr = self::getItem(2014,3,$value["subjects"]);
        $arr["name"] = $value["name"];
        
        $data[$value["id"]]=$arr;
        
        $data = self::calculate($value, $data);

      };
    };
    
    foreach($sum_array as $i=>$value){
        $arr["name"] = $value["name"];
        
        $data = self::calculate($value, $data);

    };

      return $data;

  }

  function calculate($item, $data){
    $id = $item["id"];

    if(!isset($item["to"])) {
      return $data;
    }else{
      $key = $item["to"];
      if (!isset($data[$key])){
          $data[$key] = array("start"=>0,"end"=>0);
        }
      if (!isset($data[$id])){
        $start = 0;
        $end = 0;
      }else{
        $start = $data[$id]["start"];
        $end = $data[$id]["end"];
      }
      switch ($item["function"]) {
          case "minus":
            $data[$key]["start"] -= $start;
            $data[$key]["end"] -= $end;
            return $data;
        default:
            $data[$key]["start"] += $start;
            $data[$key]["end"] += $end;
            return $data;
        }
    }
    
  }
   
  function getItem($year, $month, $subjects){
    $post = new Post();
    $post->subject_id=$subjects;
    $post->year=$year-1;
    $post->month=12;
    $start=$post->getBalanceNum();


    $post->subject_id=$subjects;
    $post->year=$year;
    $post->month=range(1,$month);
    $balance=$post->getBalanceNum();
    $end=$start+$balance;
    
    return array("start"=>$start,
          "end"=>$end);

  }
}

