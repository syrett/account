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

        $this->render("balance", array(
            "data" => $data,
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
        $this->render("subjects", array(
            "dataProvider" => $data,
            "fm" => $fm,
            "fromMonth" => $year . '-' . $fm,
            "toMonth" => $year . '-' . $tm,
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
        $data_array = [];
        if ($subject_id != '') {
            $sbj = Subjects::model()->findByAttributes(['sbj_number' => $subject_id]);
            $subject_name = $sbj->sbj_name;
            if ($sbj->has_sub == 1) {
                $list = $sbj->list_sub();
                foreach ($list as $item) {
                    $data_array[] = $model->genData($item['sbj_number'], $year, $fm, $tm);
                }
            } else
                $data = $model->genData($subject_id, $year, $fm, $tm);
        } else {
            $data = array();
        }

        $company = Condom::model()->getName();
        $this->render("detail", array("dataProviderArray" => count($data_array) == 0 ? [$data] : $data_array,
            "subject_name" => $subject_name,
            "company" => $company,
            "fromMonth" => $year . '-' . $fm,
            "toMonth" => $year . '-' . $tm));

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
        if (!empty($clients)) {
            foreach ($clients as $client) {
                $data[$client->company] = ['before' => 0, 'unreceived' => 0, 'received' => 0, 'left' => 0];
                $sbj = Subjects::model()->findByAttributes(['sbj_name' => $client->company], 'sbj_number like "1122%"');
                if ($sbj)
                    $data[$client->company] = Subjects::model()->getReport($sbj->sbj_number, convertDate($date . '01', 'Y-m-01 00:00:00'));
                $sbj = Subjects::model()->findByAttributes(['sbj_name' => $client->company], 'sbj_number like "2203%"');
                if ($sbj) {
                    $data2 = Subjects::model()->getReport($sbj->sbj_number, convertDate($date . '01', 'Y-m-01 00:00:00'));
                    if (!empty($data2) && !empty($data[$client->company])) {
                        foreach ($data2 as $key => $item) {
                            $data[$client->company][$key] = $data[$client->company][$key] + $item;
                        }
                    } else
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
        if (!empty($vendors)) {
            foreach ($vendors as $vendor) {
                $data[$vendor->company] = ['before' => 0, 'unreceived' => 0, 'received' => 0, 'left' => 0];
                $sbj = Subjects::model()->findByAttributes(['sbj_name' => $vendor->company], 'sbj_number like "2202%"');
                if ($sbj)
                    $data[$vendor->company] = Subjects::model()->getReport($sbj->sbj_number, convertDate($date . '01', 'Y-m-01 00:00:00'));
                $sbj = Subjects::model()->findByAttributes(['sbj_name' => $vendor->company], 'sbj_number like "1123%"');
                if ($sbj) {
                    $data2 = Subjects::model()->getReport($sbj->sbj_number, convertDate($date . '01', 'Y-m-01 00:00:00'));
                    if (!empty($data2) && !empty($data[$vendor->company])) {
                        foreach ($data2 as $key => $item) {
                            $data[$vendor->company][$key] = $data[$vendor->company][$key] + $item;
                        }
                    } else
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

    /*
     * 增值税纳税申报表
     */
    public function actionTax1()
    {

        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '' && $_POST['type'] != '') {
            $date = $_REQUEST['date'];
        } else {
            $date = date('Ymt', strtotime("-1 months"));
        }
        //小规模纳税人和一般纳税人的申报表不一样
        $condom = Condom::getCondom();
        if ($condom->taxpayer_t == 1) {    //一般纳税人
            $data = Product::getTax1_a();
            $this->render("tax1a", ['data' => $data, 'date' => $date]);

        } elseif ($condom->taxpayer_t == 2) {
            $data = Product::getTax1_1();
            $this->render("tax1", ['data' => $data, 'date' => $date]);

        }
    }

    /*
     * 企业所得税纳税申报表
     */
    public function actionTax4()
    {
        if (isset($_REQUEST['date']) && $_REQUEST['date'] != '' && $_POST['type'] != '') {
            $date = $_REQUEST['date'];
        } else {
            $date = date('Ymt', strtotime("-1 months"));
        }
        $type = 'A';
        $option = Options::model()->findByAttributes(['entry_subject' => '6801']);
        if ($option != null)
            $type = $option->year != '' && $option->year != 0 ? 'B' : $type;

        if ($type == 'A')
            $data = Product::getTax4_a($type);
        else
            $data = Product::getTax4_b($type);
        $this->render("tax4", array("data" => $data,
            "date" => $date,
            "type" => $type,
            "zone" => isset($_REQUEST['type'])?$_REQUEST['type']:'month'));
    }

    public function actionCreateExcel()
    {
        Yii::import('ext.phpexcel.PHPExcel');

        $filename = urldecode(urlencode($_REQUEST['name']));
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