<?php

class ReportController extends Controller
{

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        $rules = parent::accessRules();
        if ($rules[0]['actions'] == ['manage'])
            $rules[0]['actions'] = ['index'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['admin']);
        return $rules;
    }

    /**
     * 报表索引页
     */
    public function actionAdmin()
    {
        $this->render("admin", array());
    }

    /**
     * 资产负债表
     */
    public function actionBalance()
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '') {
            $date = $_REQUEST['date'];
        } else
            $date = date("Ymt", strtotime("-1 months"));
        $model = new Balance();
        $model->is_closed = 1;
        $model->date = $date;
        $data = $model->genBalanceData();

        /*
        if(isset($_REQUEST['is_closed'])&&$_REQUEST['is_closed']==1){
          $model->is_closed=$_REQUEST['is_closed'];
        }else{
          $model->is_closed=0;
          }*/
        $company = Condom::model()->getName();

        $this->render("balance", array("data" => $data,
            "date" => $date,
            "company" => $company));
    }


    /**
     * 利润及利润分配表
     */
    public function actionProfit()
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '') {
            $date = $_REQUEST['date'];
        } else
            $date = date("Ymt", strtotime("-1 months"));
        $model = new Profit();
        $model->date = $date;
        $data = $model->genProfitData();
//      $this->actionCreateExcel();

        $company = Condom::model()->getName();
        $this->render("profit", array("data" => $data,
            "date" => $date,
            "company" => $company));
    }

    /**
     * 科目余额表
     */
    public function actionSubjects() //fm:fromMonth; tm: toMonth
    {
        if (isset($_REQUEST['year']) && $_REQUEST['year'] != '') {
            $year = $_REQUEST['year'];
            $fm = $_REQUEST['fm'];
            $tm = $_REQUEST['tm'];
            if ($fm > $tm) {
                $temp = $fm;
                $fm = $tm;
                $tm = $temp;
            }
        } else {
            $year = date('Y', time());
            $fm = '01';
            $tm = date('m', strtotime("-1 months"));
            $tm = $tm == 12 ? '01' : $tm;
        }


        $model = new SubjectBalance();
        $data = $model->genData($year . $fm, $year . $tm);

        $company = Condom::model()->getName();
        $this->render("subjects", array("dataProvider" => $data,
            "fm" => $fm,
            "fromMonth" => $year . '年' . $fm . '月',
            "toMonth" => $year . '年' . $tm . '月',
            "company" => $company));
    }


    /**
     * 科目明细表
     */
    public function actionDetail() //fm:fromMonth; tm: toMonth
    {
        if (isset($_REQUEST['year']) && $_REQUEST['year'] != '') {
            $year = $_REQUEST['year'];
            $fm = $_REQUEST['fm'];
            $tm = $_REQUEST['tm'];
            if ($fm > $tm) {
                $temp = $fm;
                $fm = $tm;
                $tm = $temp;
            }
            $subject_id = $_REQUEST['subject_id'];
        } else {
            $year = date('Y', time());
            $fm = '01';
            $tm = date('m', strtotime("-1 months"));
            $tm = $tm == 12 ? '01' : $tm;
            $subject_id = '1001';
        }
        $model = new Detail();
        $subject_name = "";
        if ($subject_id != '') {
            $subject_name = Subjects::getName($subject_id);
            $data = $model->genData($subject_id, $year, $fm, $tm);
        } else {
            $data = array();
        }

        $company = Condom::model()->getName();
        $this->render("detail", array("dataProvider" => $data,
            "subject_name" => $subject_name,
            "company" => $company,
            "fromMonth" => $year . '年' . $fm . '月',
            "toMonth" => $year . '年' . $tm . '月'));

    }

    /**
     * 现金流量表
     */
    public function actionMoney() //fm:fromMonth; tm: toMonth
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '' && $_POST['type'] != '') {
            $type = $_POST['type'];
            $date = $_REQUEST['date'];
        } else {
            $type = 1;
            $date = date('Ymt', strtotime("-1 months"));
        }
        $model = new Money();
        $model->is_closed = 1;
        $model->date = $date;
        $data = $model->genMoneyData('', $type);

        $this->render("money", array("data" => $data,
            "date" => $date));
    }

    /**
     * 客户表
     */
    public function actionClient() //date:201403
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '')
            $date = $_REQUEST['date'];
        else
            $date = date('Ym', strtotime("-1 months"));

        $data = [];
        $clients = Client::model()->findAll();
        if(!empty($clients)){
            foreach ($clients as $client) {
                $data[$client->company] = ['before'=>0,'unreceived'=>0,'received'=>0,'left'=>0];
                $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$client->company], 'sbj_number like "1122%"');
                if($sbj)
                    $data[$client->company] = Subjects::model()->getReport($sbj->sbj_number,convertDate($date.'01', 'Y-m-01 00:00:00'));
                $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$client->company], 'sbj_number like "2203%"');
                if($sbj){
                    $data2 = Subjects::model()->getReport($sbj->sbj_number,convertDate($date.'01', 'Y-m-01 00:00:00'));
                    if(!empty($data2) && !empty($data[$client->company])){
                        foreach ($data2 as $key => $item) {
                            $data[$client->company][$key] = $data[$client->company][$key] + $item;
                        }
                    }else
                        $data[$client->company] = $data2;
                }
            }
        }

        $company = Condom::model()->getName();
        $this->render("client", array("data" => $data,
            "date" => $date,
            "company" => $company));

    }

    /**
     * 供应商表
     */
    public function actionVendor() //date:201403
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '')
            $date = $_REQUEST['date'];
        else
            $date = date('Ym', strtotime("-1 months"));

        $data = [];
        $vendors = Vendor::model()->findAll();
        if(!empty($vendors)){
            foreach ($vendors as $vendor) {
                $data[$vendor->company] = ['before'=>0,'unreceived'=>0,'received'=>0,'left'=>0];
                $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$vendor->company], 'sbj_number like "2202%"');
                if($sbj)
                    $data[$vendor->company] = Subjects::model()->getReport($sbj->sbj_number,convertDate($date.'01', 'Y-m-01 00:00:00'));
                $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$vendor->company], 'sbj_number like "1123%"');
                if($sbj){
                    $data2 = Subjects::model()->getReport($sbj->sbj_number,convertDate($date.'01', 'Y-m-01 00:00:00'));
                    if(!empty($data2) && !empty($data[$vendor->company])){
                        foreach ($data2 as $key => $item) {
                            $data[$vendor->company][$key] = $data[$vendor->company][$key] + $item;
                        }
                    }else
                        $data[$vendor->company] = $data2;
                }
            }
        }

        $company = Condom::model()->getName();
        $this->render("vendor", array("data" => $data,
            "date" => $date,
            "company" => $company));


    }


    /**
     * 项目表
     */
    public function actionProject() //date:201403
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '' && isset($_REQUEST['type']) && $_REQUEST['type'] != '') {
            $date = $_REQUEST['date'];
            $type = $_REQUEST['type'];
            if ($_REQUEST['type'] == 1) {
                $subject_id = 6001; //主营业收入
            } else {
                $subject_id = 6401; //主营业收入
            }
            $model = new ProjectRe();
            $subject_name = Subjects::getName($subject_id);
            $data = $model->project($date, $subject_id);
        } else {
            $data = array();
            $date = '';
            $type = 1;
            $subject_name = "";
        }

        $company = Condom::model()->getName();
        $this->render("project", array("data" => $data,
            "type" => $type,
            "subject_name" => $subject_name,
            "date" => $date,
            "company" => $company));


    }

    /**
     * 部门表
     */
    public function actionDepartment() //date:201403
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '' && isset($_REQUEST['sbj_id']) && $_REQUEST['sbj_id'] != '') {
            $date = $_REQUEST['date'];
            $subject_id = $_REQUEST['sbj_id'];
        } else {
            $date = date('Ym', strtotime('-1 months'));
            $subject_id = "6602";
        }
        $model = new DepartRe();
        $data = $model->genData($date, $subject_id);

        $company = Condom::model()->getName();
        $list = array(6601 => "销售费用", 6602 => "管理费用", 6603 => "财务费用");
        $this->render("depart", array("data" => $data["data"],
            "subjects" => $data["subjects"],
            "subject_id" => $subject_id,
            "list" => $list,
            "date" => $date,
            "company" => $company));


    }

    public function actionCreateExcel()
    {
        Yii::import('ext.phpexcel.PHPExcel');

        $filename = urlencode($_REQUEST['name']);
        header('Content-type: application/vnd.ms-excel, charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        //echo "<table><tr><td>1</td><td>2</td></tr><tr><td>1</td><td>2</td></tr></table>";
        //        echo 'test';
        $style = '<style type="text/css">
            table{
                border: 1px solid black;
            }
            td{
                border: 1px solid black;
            }
            th{
                border: 1px solid black;

            }

            </style>';
        echo $style . $_POST['data'];
        //        $objExcel->save('php://output');

    }


}