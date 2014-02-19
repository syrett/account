<?php

class ReportController extends CController
{
  /**
   * 资产负债表
   */
  public function actionBalance()
  {
    $date = "201303";
    $model = new Balance();
    $model->date = $date;
    $data = $model->genData();
    $this->render("balance",array("data"=>$data,
                                  "date"=>$date,
                                  "company"=>"公司名字"));
  }


  /**
   * 利润及利润分配表
   */
  public function actionProfit()
  {
    $date = "201303";
    $model = new Balance();
    $model->date = $date;
    $data = $model->genData();
    $this->render("profit",array("data"=>$data,
                                 "date"=>$date,
                                 "company"=>"公司名字"));
  }
}