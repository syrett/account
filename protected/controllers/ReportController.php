<?php

class ReportController extends CController
{
  /**
   * 资产负债表
   */
  public function actionBalance()
  {
    $model = new Balance();
    $data = $model->genData();
    $this->render("balance",array("data"=>$data));
  }


  /**
   * 利润及利润分配表
   */
  public function actionProfit()
  {
    $model = new Balance();
    $data = $model->genData();
    $this->render("profit",array("data"=>$data));
  }
}