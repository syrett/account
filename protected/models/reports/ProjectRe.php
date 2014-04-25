<?php
//客户报表，供应商报表，项目与部门核算表
class ProjectRe extends CModel
{

  public function attributeNames()
  {
    array();
  }

  public function project($date, $subject_id){
    $year=getYear($date);
    $month=getMon($date);
    $month_arr = self::getMonth(4, $year, $month, $subject_id);
    $year_arr = self::getYear(4, $year, $subject_id);
    $balance_arr = self::getBalance(4, $year, $month, $subject_id);
    $projects = Project::model()->list_projects();
    $arr = array();
    foreach($projects as $k=>$proj){
      $id = $proj["id"];
      $data = array("id"=>$id,
                    "company"=>$proj["name"]);
      $data["month_debit"] = isset($month_arr[$id])?$month_arr[$id]["debit"]:0;
      $data["month_credit"] = isset($month_arr[$id])?$month_arr[$id]["credit"]:0;
      $data["year_debit"] = isset($year_arr[$id])?$year_arr[$id]["debit"]:0;
      $data["year_credit"] = isset($year_arr[$id])?$year_arr[$id]["credit"]:0;
      $data["balance"] = isset($balance_arr[$id])?$balance_arr[$id]["balance"]:0;
      $arr[] = $data;
    }
    return $arr;
  }

  private function getMonth($entry_appendix_type, $year, $month, $subject_id) //得到本期
  {
    $transition = new Transition;
    $transition->entry_appendix_type=$entry_appendix_type;
    $sql = "SELECT entry_transaction, entry_amount,entry_appendix_id,entry_subject FROM TRANSITION WHERE entry_appendix_type=:eat AND year(entry_date)=:year AND month(entry_date)=:month";
    $data = Transition::model()->findAllBySql($sql, array(':eat'=>$entry_appendix_type,
                                                          ':year'=>$year,
                                                          ':month'=>$month));
    $arr=array();
    $income=0; //借
    $expense=0; //贷

    foreach($data as $k=>$v) {
      $sbj = substr($v['entry_subject'], 0, 4);
      if ($sbj == $subject_id){
        
        $id=$v['entry_appendix_id'];
        if(!isset($arr[$id])){
          $item=array('debit'=>0,
                      'credit'=>0); //(借，贷)
        }else{
          $item=$arr[$id];
        }
        if ($v['entry_transaction']=="1") { //1为借
          $item["debit"]=$item["debit"]+$v['entry_amount'];
        }
        elseif($v['entry_transaction']=="2") { //2为贷
          $item["credit"]=$item["credit"]+$v['entry_amount'];
        }
        $arr[$id]=$item;
      }
    }
    return $arr;
  }

  private function getYear($entry_appendix_type, $year, $subject_id) //得到本年
  {
    $transition = new Transition;
    $transition->entry_appendix_type=$entry_appendix_type;
    $sql = "SELECT entry_transaction, entry_amount, entry_appendix_id, entry_subject FROM TRANSITION WHERE entry_appendix_type=:eat AND year(entry_date)=:year";
    $data = Transition::model()->findAllBySql($sql, array(':eat'=>$entry_appendix_type,
                                                          ':year'=>$year));
    $arr=array();
    $income=0; //借
    $expense=0; //贷
    foreach($data as $k=>$v) {
      $sbj = substr($v['entry_subject'], 0, 4);
      if ($sbj == $subject_id){
        $id=$v['entry_appendix_id'];
        if(!isset($arr[$id])){
          $item=array('debit'=>0,
                      'credit'=>0); //(借，贷)
        }else{
          $item=$arr[$id];
        }
        if ($v['entry_transaction']=="1") { //1为借
          $item["debit"]=$item["debit"]+$v['entry_amount'];
        }
        elseif($v['entry_transaction']=="2") { //2为贷
          $item["credit"]=$item["credit"]+$v['entry_amount'];
        }
        $arr[$id]=$item;
      }
    }
    return $arr;
  }

  private function getBalance($entry_appendix_type, $year, $month, $subject_id) //得到余额
  {
    $transition = new Transition;
    $transition->entry_appendix_type=$entry_appendix_type;
    $sql = "SELECT entry_transaction, entry_amount,entry_appendix_id, entry_subject FROM TRANSITION WHERE entry_appendix_type=:eat AND year(entry_date)<=:year AND month(entry_date)<=:month";
    $data = Transition::model()->findAllBySql($sql, array(':eat'=>$entry_appendix_type,
                                                          ':year'=>$year,
                                                          ':month'=>$month));
    $arr=array();
    $income=0; //借
    $expense=0; //贷
    foreach($data as $k=>$v) {
      $sbj = substr($v['entry_subject'], 0, 4);
      if ($sbj == $subject_id){
        $id=$v['entry_appendix_id'];
        if(!isset($arr[$id])){
          $item=array('balance'=>0);
        }else{
          $item=$arr[$id];
        }
        if ($v['entry_transaction']=="1") { //1为借
          $item["balance"] += $v['entry_amount'];
        }
        elseif($v['entry_transaction']=="2") { //2为贷
          $item["balance"] -= $v['entry_amount'];
        }
        $arr[$id]=$item;
      }
    }
    return $arr;
  }


}


