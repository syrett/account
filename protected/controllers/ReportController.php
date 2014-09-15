<?php

class ReportController extends CController
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }
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
                                   "fm" => $fm,
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
    $model = new Detail();
    $subject_name = "";
    if($subject_id!=''){
      $subject_name = Subjects::getName($subject_id);
      $data = $model->genData($subject_id, $year, $fm, $tm);
    }
    else{
        $data = array();
    }

    $this->render("detail",array("dataProvider"=>$data,
                                 "subject_name"=>$subject_name,
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

    }else{
      $data = array();
        $date = '';
    }

    $this->render("client",array("data"=>$data,
                                 "date"=>$date));

  }

  /**
   * 供应商表
   */
  public function actionVendor() //date:201403
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''){
      $date=$_REQUEST['date'];
    $model = new Set();
    $data = $model->vendor($date);

    }else{
      $data = array();
        $date = '';
    }

    $this->render("vendor",array("data"=>$data,
                                 "date"=>$date));



  }


  /**
   * 项目表
   */
  public function actionProject() //date:201403
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!='' && isset($_REQUEST['type'])&&$_REQUEST['type']!='' ){
      $date=$_REQUEST['date'];
      $type = $_REQUEST['type'];
      if ($_REQUEST['type'] == 1) {
        $subject_id = 6001; //主营业收入
      }else{
        $subject_id = 6401; //主营业收入
      }
      $model = new ProjectRe();
      $subject_name = Subjects::getName($subject_id);
      $data = $model->project($date, $subject_id);
    }else{
      $data = array();
      $date = '';
      $type = 1;
      $subject_name = "";
    }

    $this->render("project",array("data"=>$data,
                                  "type"=>$type,
                                 "subject_name" => $subject_name,
                                 "date"=>$date));



  }

 /**
   * 部门表
   */
  public function actionDepartment() //date:201403
  {
    if(isset($_REQUEST['date'])&&$_REQUEST['date']!=''&&isset($_REQUEST['sbj_id'])&&$_REQUEST['sbj_id']!=''){
      $date=$_REQUEST['date'];
      $model = new DepartRe();
      $subject_id = $_REQUEST['sbj_id'];
      $data = $model->genData($date, $subject_id);
    }else{
      $data = array("data"=>array(),
                    "subjects"=>array());
      $date = '';
      $subject_id = "";
    }
    
    $list = array(6601=>"销售费用", 6602=>"管理费用", 6603=>"财务费用");
    $this->render("depart",array("data"=>$data["data"],
                                  "subjects"=>$data["subjects"],
                                 "subject_id" => $subject_id,
                                 "list"=>$list,
                                 "date"=>$date));



  }


}