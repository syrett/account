<?php

class ReportController extends CController
{
  /**
   * 资产负债表
   */
  public function actionBalance()
  {
    if(isset($_GET['date'])){
      $date=$_GET['date'];
    }else{
      $date=date("Ymd");
    }
    $model = new Balance();
    $model->date = $date;
    if(isset($_GET['is_closed'])){
      $model->is_closed=$_GET['is_closed'];
    }else{
      $model->is_closed=0;
    }

    $data = $model->genBalanceData();
    $this->render("balance",array("data"=>$data,
                                  "date"=>$date,
                                  "company"=>"公司名字"));
  }


  /**
   * 利润及利润分配表
   */
  public function actionProfit()
  {
    if(isset($_GET['date'])){
      $date=$_GET['date'];
    }else{
      $date=date("Ym");
    }
    $model = new Balance();
    $model->date = $date;
    $data = $model->genProfitData();
    $this->render("profit",array("data"=>$data,
                                 "date"=>$date,
                                 "company"=>"公司名字"));
  }
}