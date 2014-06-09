<?php
//部门表
class DepartRe extends CModel
{
  public function attributeNames()
  {
    array();
  }

  public function genData($date, $subject_id) {
    $year=getYear($date);
    $month=getMon($date);
    $arr = self::getData($year, $month, $subject_id);
    return $arr;
  }

  private function getData($year, $month, $subject_id) {
    $transition = new Transition;
    $sql = "SELECT entry_transaction, entry_amount,entry_appendix_id,entry_subject FROM transition WHERE entry_appendix_type=3 AND year(entry_date)=:year AND month(entry_date)=:month";
    $data = Transition::model()->findAllBySql($sql, array(':year'=>$year,
                                                          ':month'=>$month));

    $depart_arr = Department::model()->list_departments();
    $arr = array();
    $subjects = array(); //哪些子科目
    foreach($data as $k=>$v) {
      $sbj_id = $v['entry_subject'];
      $sbj = substr($sbj_id, 0, 4);
      if ($sbj == $subject_id){
        $depart_id = Employee::model()->getDepart($v['entry_appendix_id']);
        $depart = isset($arr[$depart_id])?$arr[$depart_id]:array();
        $balance = isset($depart[$sbj_id])?$depart[$sbj_id]:0;
        if ($v['entry_transaction']=="1") { //1为借
          $balance = $balance + $v['entry_amount'];
        }
        elseif($v['entry_transaction']=="2") { //2为贷
          $balance = $balance - $v['entry_amount'];
        };

        $depart_name = Department::model()->getName($depart_id);
        $depart[$sbj_id] = $balance;
        $depart["name"] = $depart_name;
        $arr[$depart_id] = $depart;
        if(!isset($subjects[$sbj_id])){
          $sbj_name = Subjects::model()->getName($sbj_id);
          $subjects[$sbj_id] = $sbj_name;
        }
      }
    }

    if (sizeof($subjects) == 0) {
      $sbj_name = Subjects::model()->getName($subject_id);
      $subjects[$subject_id] = $sbj_name;
    } 

    foreach($depart_arr as $k=>$d) {
      $d_id = $d["id"];
      $d_name = $d["name"];

      if (!isset($arr[$d_id])) {
          foreach($subjects as $sbj_id=>$sbj_name) {
            $depart = isset($arr[$d_id])?$arr[$d_id]:array();
            $depart[$sbj_id] = 0;
            $depart["name"] = $d_name;
            $arr[$d_id] = $depart;
          }
      }
    }

    return array("subjects"=>$subjects,
                 "data"=>$arr);
    
  }
}
?>


