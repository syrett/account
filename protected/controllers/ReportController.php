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
    }else{
      $date=date("Ymd");
    }
    $model = new Balance();
    $model->date = $date;
    $model->is_closed=1;
    /*
    if(isset($_REQUEST['is_closed'])&&$_REQUEST['is_closed']==1){
      $model->is_closed=$_REQUEST['is_closed'];
    }else{
      $model->is_closed=0;
      }*/

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
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
    }else{
      $date=date("Ym");
    }
    $model = new Profit();
    $model->date = $date;
    $data = $model->genProfitData();
    $this->render("profit",array("data"=>$data,
                                 "date"=>$date,
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