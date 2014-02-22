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
    $post = new Post();
    $post->subject_id=$subjects;
    $post->year=$year-1;
    $post->month=12;
    $start=$post->getBalanceNum();

    $balance = self::getEndNum($subjects);

    $end=$start+$balance;
    
    return array("start"=>$start,
          "end"=>$end);

  }

  //因为要算到日，所以直接从transition表里读取。
  function getEndNum($subjects){
    $year = getYear($this->date);
    $month = getMon($this->date);
    $day = getDay($this->date);
    if($day==''){
      $day=31;
    }
    if ($this->is_closed == 1){
      $sql = "SELECT entry_transaction, entry_amount FROM TRANSITION WHERE entry_closing=1 AND year(entry_date)=:year AND month(entry_date)=:month AND day(entry_date)<:day";
    }else{
      $sql = "SELECT entry_transaction, entry_amount FROM TRANSITION WHERE year(entry_date)=:year AND month(entry_date)=:month AND day(entry_date)<:day";
    }

    $data = Transition::model()->findAllBySql($sql, array(':year'=>$year,
                                                  ':month'=>$month,
                                                          ':day'=>$day+1));

    $tmp_balance=0;
    foreach($data as $k=>$v){
      if ($v['entry_transaction']=="1") { //1为借,借加
        $tmp_balance=$tmp_balance + floatval($v['entry_amount']);
      }
      elseif($v['entry_transaction']=="2") { //2为贷,贷减
        $tmp_balance=$tmp_balance - floatval($v['entry_amount']);
      }
    }
    return $tmp_balance; //本月初到某日的发生额
  }

}

