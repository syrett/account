<?php
//明细表
class Detail extends CModel
{

  var $sbj_cat;
  var $balance=0;
  var $sum_debit=0;
  var $sum_credit=0;
  public function attributeNames()
  {
  }

  //fm:from month, tm:to month
  public function genData($sbj_id, $year, $fm, $tm) 
  {
    $this->sbj_cat = Subjects::model()->getCat($sbj_id);
    $post = new Post();
    $arr = $post->getLastBalance($year, $fm);
    $this->balance = isset($arr["balance"])?$arr["balance"]:0;
    $data["start_balance"] = $this->balance; //期初余额
    $info = self::getTransition($sbj_id, $year, $fm, $tm);
    $data["end_balance"] = $this->balance; //期末余额
    $data["info"] = $info;
    $data["sum_debit"] = $this->sum_debit;
    $data["sum_credit"] = $this->sum_credit;
    return $data;
    
  }

  private function getTransition($sbj_id, $year, $fm, $tm){
    $sql = "SELECT entry_num_prefix, entry_num, entry_transaction, entry_amount,entry_memo, entry_date FROM transition WHERE entry_subject=:subject_id AND year(entry_date) =:year AND month(entry_date) >= :fm AND Month(entry_date)<=:tm ORDER BY entry_num_prefix asc";
    $transition = Transition::model()->findAllBySql($sql, array(':subject_id'=>$sbj_id,
                                                                'year'=>$year,
                                                                ':fm'=>$fm,
                                                                ':tm'=>$tm));
    $data = array();
    foreach($transition as $row) {
      $num = Transition::model()->addZero($row["entry_num"]);
      $transition_num = $row["entry_num_prefix"].$num;
      $arr = array("entry_num"=>$transition_num,
                   "entry_memo"=>$row["entry_memo"],
                   "entry_date"=>$row["entry_date"]);

      switch ($row["entry_transaction"]) {
      case 1:
        $arr["debit"] = $row["entry_amount"];
        $arr["balance"] = balance2($this->balance, $row["entry_amount"], 0, $this->sbj_cat);
        $this->sum_debit += $row["entry_amount"];
        break;
      case 2:
        $arr["credit"] = $row["entry_amount"];
        $arr["balance"] = balance2($this->balance, 0, $row["entry_amount"], $this->sbj_cat);
        $this->sum_credit += $row["entry_amount"];
        break;
      }
      $this->balance = $arr["balance"];

      $data[] = $arr;
    }
    return $data;
  }

}
