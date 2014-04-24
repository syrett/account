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
  public function actionSubjects() //fm:fromMonth; tm: toMonth
  {
      if(isset($_REQUEST['year'])&&$_REQUEST['year']!='')
      {
          $year = $_REQUEST['year'];
          $fm = $_REQUEST['fm'];
          $tm = $_REQUEST['tm'];
          if($fm > $tm)
          {
              $temp = $fm;
              $fm = $tm;
              $tm = $temp;
          }
      }
      else
      {
          $year = '';
          $fm = '';
          $tm = '';
      }


    $model = new SubjectBalance();
    $data = $model->genData($year.$fm, $year.$tm);
    $this->render("subjects",array("dataProvider"=>$data,
                                   "fromMonth"=>$year.'年'.$fm.'月',
                                   "toMonth"=>$year.'年'.$tm.'月',
                                 "company"=>"公司名字"));
  }


  /**
   * 科目明细表
   */
  public function actionDetail() //fm:fromMonth; tm: toMonth
  {
      if(isset($_REQUEST['year'])&&$_REQUEST['year']!='')
      {
          $year = $_REQUEST['year'];
          $fm = $_REQUEST['fm'];
          $tm = $_REQUEST['tm'];
          if($fm > $tm)
          {
              $temp = $fm;
              $fm = $tm;
              $tm = $temp;
          }
          $subject_id = $_REQUEST['subject_id'];
      }
      else
      {
          $year = '';
          $fm = '';
          $tm = '';
          $subject_id = '';
      }
    echo $year;
    echo $fm;
    echo $tm;
    echo $subject_id;
    $model = new Detail();
    if($subject_id!='')
        $data = $model->genData($subject_id, $year, $fm, $tm);
      else
          $data = array();
    $this->render("detail",array("dataProvider"=>$data,
                                   "fromMonth"=>$year.'年'.$fm.'月',
                                   "toMonth"=>$year.'年'.$tm.'月'));
    
  }

  /**
   * 客户表
   */
  public function actionClient() //date:201403
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
    $model = new Set();
    $data = $model->client($date);
    $this->render("client",array("data"=>$data,
                                 "date"=>$date));
    }else{
      $data = array();
        $date = '';
    }

    $this->render("client",array("data"=>$data,
                                 "date"=>$date));

  }

  /**
   * 客户表
   */
  public function actionVendor() //date:201403
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
    $model = new Set();
    $data = $model->vendor($date);
    $this->render("vendor",array("data"=>$data,
                                 "date"=>$date));
    }else{
      $data = array();
        $date = '';
    }

    $this->render("vendor",array("data"=>$data,
                                 "date"=>$date));



  }



}