<?php

class ReportController extends CController
{
  /**
   * 资产负债表
   */
  public function actionBalance()
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
        $model = new Balance();
        $model->is_closed=1;
        $model->date = $date;
        $data = $model->genBalanceData();
    }else{
        $data = '';
        $date = '';
    }

    /*
    if(isset($_REQUEST['is_closed'])&&$_REQUEST['is_closed']==1){
      $model->is_closed=$_REQUEST['is_closed'];
    }else{
      $model->is_closed=0;
      }*/

    $this->render("balance",array("data"=>$data,
                                  "date"=>$date,
                                  "company"=>"公司名字"));
  }


  /**
   * 利润及利润分配表
   */
  public function actionProfit()
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
        $model = new Profit();
        $model->date = $date;
        $data = $model->genProfitData();
    }else{
        $data = '';
        $date = '';
    }

    $this->render("profit",array("data"=>$data,
                                 "date"=>$date,
                                 "company"=>"公司名字"));
  }



  /**
   * 科目余额表
   */
  public function actionSubjects($year, $fm, $tm) //fm:fromMonth; tm: toMonth
  {
    $model = new SubjectBalance();
    $data = $model->genData("201401", "201403");
    $this->render("subjects",array("dataProvider"=>$data,
                                   "fromMonth"=>$year.$fm,
                                   "toMonth"=>$year.$tm,
                                 "company"=>"公司名字"));
  }

  /**
   * 客户表
   */
  public function actionClient()
  {
    if(isset($_GET['date'])){
      $date=$_GET['date'];
    }else{
      $date=date("Ym");
    }
    $date="201402";
    $model = new Set();
    $data = $model->client($date);
    $this->render("profit",array("data"=>$data,
                                 "date"=>$date,
                                 "company"=>"公司名字"));
  }



}