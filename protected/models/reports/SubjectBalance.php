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
    $sum = self::getSum(2014,1,2); //发生额
    $start = self::getStart(2014,1); //期初
    $end = self::getEnd(2014,2); //期末
    $data = array();
    foreach ($sum as $sbj_id=>$arr){
      $sbj_name = Subjects::getName($sbj_id);
      $start_debit = isset($start[$sbj_id]) ? $start[$sbj_id]["debit"] : 0;
      $start_credit = isset($start[$sbj_id]) ? $start[$sbj_id]["credit"] : 0;
      array_push($data, array("subject_id"=>$sbj_id,
                              "subject_name"=>$sbj_name,
                              "start_debit"=>$start_debit,
                              "start_credit"=>$start_credit,
                              "sum_debit"=>$arr["debit"],
                              "sum_credit"=>$arr["credit"],
                              "end_debit"=>$start_debit + $arr["debit"],
                              "end_credit"=>$start_credit + $arr["credit"]));
    };

    $catData = self::cat_subjects($data);
    /*    echo "<pre>";
    var_dump($catData);
    echo "</pre>";
    */
    return $catData;
  }


    
  private function cat_subjects($data) {
    $catData = array();
    foreach($data as $item){
      $sbj_cat = Subjects::model()->getCat($item["subject_id"]);
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
      //      $catData[$sbj_cat]["items"] = array_push($catData[$sbj_cat]["items"], $item);
            //      $catData[$sbj_cat]["items"] = array_push(array(), $item);
      $catData[$sbj_cat]["start_debit"] += $item["start_debit"];
      $catData[$sbj_cat]["start_credit"] += $item["start_credit"];
      $catData[$sbj_cat]["sum_debit"] += $item["sum_debit"];
      $catData[$sbj_cat]["sum_credit"] += $item["sum_credit"];
      $catData[$sbj_cat]["end_debit"] += $item["end_debit"];
      $catData[$sbj_cat]["end_credit"] += $item["end_credit"];

    }

    return $catData;

  }

  /*
  private function liyouyou($data){
    $catData = array();
    foreach($data as $item){
      $sbj_cat = Subjects::model()->getCat($item["subject_id"]);
      if(!isset($catData[$sbj_cat])){
        $catData[$sbj_cat]["items"] = array();
        $catData[$sbj_cat]["start_debit"] =0;
        $catData[$sbj_cat]["start_credit"] = 0;
        $catData[$sbj_cat]["sum_debit"] = 0;
        $catData[$sbj_cat]["sum_credit"] = 0;
        $catData[$sbj_cat]["end_debit"] = 0;
        $catData[$sbj_cat]["end_credit"] = 0;

      }
      echo "1";
      var_dump($catData[$sbj_cat]["items"]);
      //      $catData[$sbj_cat]["items"] = array_push($catData[$sbj_cat]["items"], $item);
      $catData[$sbj_cat]["items"] = array_push(array(), $item);
      $catData[$sbj_cat]["start_debit"] += $item["start_debit"];
      $catData[$sbj_cat]["start_credit"] += $item["start_credit"];
      $catData[$sbj_cat]["sum_debit"] += $item["sum_debit"];
      $catData[$sbj_cat]["sum_credit"] += $item["sum_credit"];
      $catData[$sbj_cat]["end_debit"] += $item["end_debit"];
      $catData[$sbj_cat]["end_credit"] += $item["end_credit"];

    }

    return $catData;
  }
  
  */

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

