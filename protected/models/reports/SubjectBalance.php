<?php
//科目余额表
class SubjectBalance extends CModel
{

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subject_id' => '科目编码',
			'sbj_name' => '科目名称',
			'sbj_cat' => '科目类别',
			'start_debit' => '期初借方',
			'start_credit' => '期初贷方',
			'sum_debit' => '本期发生借方',
			'sum_credit' => '本期发生贷方',
			'end_debit' => '期末借方',
			'end_credit' => '期末贷方',

		);
	}

  public function attributeNames()
  {
  }
  
  public function genData($fromDate, $toDate)
  {
    $year = getYear($fromDate);
    $fromMonth = getMon($fromDate);
    $toMonth = getMon($toDate);
    $sum = self::getSum($year,$fromMonth,$toMonth); //发生额
    $start = self::getStart($year, $fromMonth); //期初
    $end = self::getEnd($year, $toMonth); //期末
    $data = array();
    
    if (count($sum)==0){
      $sum=$start;
    }
    foreach ($sum as $sbj_id=>$arr){
      $sbj_name = Subjects::getName($sbj_id);
      $sbj_cat = Subjects::model()->getCat($sbj_id);
      $start_balance = isset($start[$sbj_id]) ? $start[$sbj_id]["balance"] : 0;
      $sep_balance = self::sep_balance($sbj_cat, $start_balance);
      $start_debit = $sep_balance["debit"];
      $start_credit = $sep_balance["credit"];

      $end_balance = balance($start_balance, $arr["debit"], $arr["credit"], $sbj_cat);
      $sep_balance = self::sep_balance($sbj_cat, $end_balance);
      $end_debit = $sep_balance["debit"];
      $end_credit = $sep_balance["credit"];
      //      $end_debit=$start_debit + $arr["debit"];
      //      $end_credit=$start_credit + $arr["credit"];
      if($start_debit!=0 || $start_credit!=0 || $arr["debit"]!=0 || $arr["credit"]!=0 || $end_debit!=0 || $end_credit!=0){
        
        array_push($data, array("subject_id"=>$sbj_id,
                                "subject_cat"=>$sbj_cat,
                              "subject_name"=>$sbj_name,
                              "start_debit"=>$start_debit,
                              "start_credit"=>$start_credit,
                              "sum_debit"=>$arr["debit"],
                              "sum_credit"=>$arr["credit"],
                                "end_debit"=>$end_debit,
                              "end_credit"=>$end_credit));
      }
    };

    $catData = self::cat_subjects($data);
    /*    echo "<pre>";
    var_dump($catData);
    echo "</pre>";
    */
    return $catData;
  }


  /*
   * 根据类别和余额，来重新计算借方与贷方
   */
  private function sep_balance($sbj_cat, $balance){
      switch($sbj_cat)
    {
    case 1: //资产类
    case 5: //费用类
      if ($balance>0) {
          $arr = array("debit"=>$balance,
                       "credit"=>0);
        }else{
        $arr=  array("debit"=>0,
                     "credit"=>abs($balance));
      }
      return $arr;
      break;
    case 2: //负债类
    case 3: //权益类
    case 4: //收入类
      if ($balance>0) {
        $arr = array("debit"=>0,
                     "credit"=>$balance);
        }else{
        $arr=  array("debit"=>abs($balance),
                     "credit"=>0);
      }
      return $arr;
      break;
    default:
      return 0;
      break;
    }
  }
    
  private function cat_subjects($data) {
    $catData = array();
    foreach($data as $item){
      $sbj_cat = $item["subject_cat"];
      if(!isset($catData[$sbj_cat])){
        $catData[$sbj_cat]["items"] = array();
        $catData[$sbj_cat]["start_debit"] =0;
        $catData[$sbj_cat]["start_credit"] = 0;
        $catData[$sbj_cat]["sum_debit"] = 0;
        $catData[$sbj_cat]["sum_credit"] = 0;
        $catData[$sbj_cat]["end_debit"] = 0;
        $catData[$sbj_cat]["end_credit"] = 0;

      }

      $catData[$sbj_cat]["items"][] =  $item;

      $catData[$sbj_cat]["start_debit"] += $item["start_debit"];
      $catData[$sbj_cat]["start_credit"] += $item["start_credit"];
      $catData[$sbj_cat]["sum_debit"] += $item["sum_debit"];
      $catData[$sbj_cat]["sum_credit"] += $item["sum_credit"];
      $catData[$sbj_cat]["end_debit"] += $item["end_debit"];
      $catData[$sbj_cat]["end_credit"] += $item["end_credit"];

    }

	$catData2 = array();
    for($i=1;$i<6;$i++){
      if (isset($catData[$i])) {
        $catData2[$i]=$catData[$i];
      }
    }
    return $catData2;
//`    return $catData;

  }

  /*
   * 得到某年从某月到某月的post发生额,不跨年
   */
  private function getSum($year, $startMonth, $endMonth){
    $active_data = self::listPost($year, $startMonth, $endMonth);
    $data = array();
    foreach( $active_data as $row){
      $sbj_id = $row["subject_id"];
      if(isset($data[$sbj_id])){
        $data[$sbj_id]["debit"] += $row["debit"];
        $data[$sbj_id]["credit"] += $row["credit"];
      }else{
        $data[$sbj_id]["debit"] = $row["debit"];
        $data[$sbj_id]["credit"] = $row["credit"];
      }

    }
    return $data;
    
  }

  /*
   * 得到某年从某月到某月的post信息,不跨年
   */
  private function listPost($year, $startMonth, $endMonth){
    $criteria=new CDbCriteria;
    $criteria->compare('year', $year);
    $criteria->addBetweenCondition('month', $startMonth, $endMonth);
    $active_data = Post::model()->findAll($criteria);
    return $active_data;
    
  }

  /*
   * 得到期初的信息
   */
  private function getStart($year, $startMonth){
    $lastDate=date("Ym",strtotime("last month",mktime(0,0,0,$startMonth,01,$year)));
    $year = substr($lastDate,0,4);
    $month = substr($lastDate,4,2);
    $active_data = self::listPost($year, $month, $month);
    $data = array();
    foreach( $active_data as $row){
      $sbj_id = $row["subject_id"];
      $data[$sbj_id]["balance"] = $row["balance"];
      $data[$sbj_id]["debit"] = $row["debit"];
      $data[$sbj_id]["credit"] = $row["credit"];
    }
    return $data;
    
  }

  /*
   * 得到期末的信息
   */
  private function getEnd($year, $endMonth){
    $active_data = self::listPost($year, $endMonth, $endMonth);
    $data = array();
    foreach( $active_data as $row){
      $sbj_id = $row["subject_id"];
      $data[$sbj_id]["debit"] = $row["debit"];
      $data[$sbj_id]["credit"] = $row["credit"];
    }
    return $data;
    
  }

}

