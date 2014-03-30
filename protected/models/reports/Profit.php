<?php
//损益表
class Profit extends CModel
{

  public $date; //报表年月日 20140301

  public function attributeNames()
  {
    array();
  }
  

  public function genProfitData(){
    $array = Yii::app()->params['profitReport'];
    $sum_array = Yii::app()->params['profitReport_sum'];
    return self::genData($array, $sum_array);
  }


  public function genData($array, $sum_array){
    $data=array();
    foreach($array as $i=>$value){
      if (isset($value["subjects"])) {

        $arr = self::getItem($value["subjects"]);

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
          $data[$key] = array("sum_month"=>0,"sum_year"=>0);
        }
      if (!isset($data[$id])){
        $start = 0;
        $end = 0;
      }else{
        $start = $data[$id]["sum_month"];
        $end = $data[$id]["sum_year"];
      }
      switch ($item["function"]) {
          case "minus":
            $data[$key]["sum_month"] -= $start;
            $data[$key]["sum_year"] -= $end;
            return $data;
        default:
            $data[$key]["sum_month"] += $start;
            $data[$key]["sum_year"] += $end;
            return $data;
        }
    }
    
  }
   
  function getItem($subjects){
    $year = getYear($this->date);
    $month = getMon($this->date);

    $sum_year = 0;//一年期数额
    $sum_month = 0;//当月期数额
    foreach($subjects as $k=>$sbj_id){
      $sum_year += Post::model()->getDebitCredit($sbj_id, $this->date, 0);
      $sum_month += Post::model()->getDebitCredit($sbj_id, $this->date);
    }
    return array("sum_year"=>$sum_year,
          "sum_month"=>$sum_month);

  }

}




