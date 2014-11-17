<?php
//资产负债表
class Balance extends CModel
{

  public $date; //报表年月日 20140301
  public $is_closed=0; //是否查询已经或未结账的
  public function attributeNames()
  {
    array();
  }
  

  public function genProfitData(){
    $array = Yii::app()->params['profitReport'];
    $sum_array = Yii::app()->params['profitReport_sum'];
    return self::genData($array, $sum_array);
  }

  public function genBalanceData(){
    $array = Yii::app()->params['balanceReport'];
    $sum_array = Yii::app()->params['balanceReport_sum'];
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
   
  function getItem($subjects){
    $year = getYear($this->date);
    $month = getMon($this->date);
    $day = getDay($this->date);
    if($day==''){
      $day=31;
    }
    $lastDate=date("Ym",strtotime("last month",mktime(0,0,0,$month,01,$year))); //上个月
    $start_year = 0;//年初数
    $start = 0;//上月余额
    $end = 0;//到某日的余额
    foreach($subjects as $k=>$sbj_id){
      $start_year += Post::model()->getLastBalanceNum($sbj_id, ($year-1)."12");
	  $balance = Post::model()->getLastBalanceNum($sbj_id, $lastDate);
      $sbj_cat = Subjects::model()->getCat($sbj_id);
      $arr = self::getEndNum($sbj_id, $year, $month, $day);
      $end += balance($balance, $arr['debit'], $arr['credit'], $sbj_cat);
    }
    
	return array("start"=>$start_year,
          "end"=>$end);

  }

  //因为要算到日，所以直接从transition表里读取。
  function getEndNum($sbj_id,$year, $month, $day){
    $sql = "SELECT entry_transaction, entry_amount FROM transition WHERE year(entry_date)=:year AND month(entry_date)=:month AND day(entry_date)<:day AND entry_subject REGEXP '^".$sbj_id."'  ";
    if ($this->is_closed == 1){
      //      $sql = "SELECT entry_transaction, entry_amount FROM transition WHERE entry_closing=1 AND year(entry_date)=:year AND month(entry_date)=:month AND day(entry_date)<:day";
      $sql = $sql . " AND entry_closing=1";
    }
    $data = Transition::model()->findAllBySql($sql, array(':year'=>$year,
                                                          ':month'=>$month,
                                                          ':day'=>$day+1));

    
    $debit=0;
    $credit=0;
    foreach($data as $k=>$v){
      if ($v['entry_transaction']=="1") { //1为借
        $debit += floatval($v['entry_amount']);
      }
      elseif($v['entry_transaction']=="2") { //2为贷
        $credit += floatval($v['entry_amount']);
      }
    }
    return array('debit'=>$debit,'credit'=>$credit);
  }

}

