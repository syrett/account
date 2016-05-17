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
        $session = Yii::app()->session;
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
        $session[__METHOD__.'_year'] = $year;
        $session[__METHOD__.'_fm'] = $fm;
        $session[__METHOD__.'_tm'] = $tm;


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
//        $type = 'A';
//        $option = Options::model()->findByAttributes(['entry_subject' => '6801']);
//        if ($option != null)
//            $type = $option->year != '' && $option->year != 0 ? 'B' : $type;
//
        //企业所得税征税类型
        $condom = Condom::getCondom();
        $type = $condom->income_t == 0?'A':'B';

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

    /**
     * 导出excel
     */
    public function actionExportExcel()
    {
        $session = Yii::app()->session;
        $mStr = 'ReportController::actionSubjects';
        if (isset($session[$mStr.'_year'])){
            $year = $session[$mStr.'_year'];
            $fm = $session[$mStr.'_fm'];
            $tm = $session[$mStr.'_tm'];
        } else {
            $year = date('Y', time());
            $fm = '01';
            $tm = date('m', strtotime("-1 months"));
            $tm = $tm == 12 ? '01' : $tm;
        }

        $model = new SubjectBalance();
        $data = $model->genData($year . $fm, $year . $tm);

        $fm = intval($fm);
        if ($fm < 10) {
            $fm = '0'.$fm;
        }
        $tm = intval($tm);
        if ($tm < 10) {
            $tm = '0'.$tm;
        }

        $xlsName = '科目余额表_'.$year.$fm.'-'.$year.$tm;

        Yii::import('ext.phpexcel.PHPExcel');
        $oe = new PHPExcel();
        $ow = new PHPExcel_Writer_Excel5($oe);

        $os = $oe->getActiveSheet();


        $os->setTitle('科目余额表');
        $os->getDefaultStyle()->getFont()->setName('微软雅黑');
        $os->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $os->getDefaultStyle()->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $os->getDefaultStyle()->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


        $os->getColumnDimension('A')->setWidth(16);
        $os->getColumnDimension('B')->setWidth(24);
        $os->getColumnDimension('C')->setWidth(14);
        $os->getColumnDimension('D')->setWidth(14);
        $os->getColumnDimension('E')->setWidth(14);
        $os->getColumnDimension('F')->setWidth(14);
        $os->getColumnDimension('G')->setWidth(14);
        $os->getColumnDimension('H')->setWidth(14);

        $os->getStyle('A1')->getAlignment()->setShrinkToFit(true);
        $os->getStyle('A1')->getAlignment()->setWrapText(true);

        $os->getStyle('A1')->getFont()->setSize(10);
        $os->getStyle('A1')->getFont()->getColor()->setARGB('FF00A0FF');
        $os->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $os->setCellValue('A1', "生成时刻：\n" . date('Y-m-d H:i'));

        $os->getStyle('C1:H1')->getFont()->setSize(14);
        $os->mergeCells('C1:H1');
        $os->setCellValue('C1', '科目余额表    ('.$year.'-'.$fm.' 至 '.$year.'-'.$tm.')');

        $os->getStyle('A3:H3')->getFont()->setSize(13);
        $os->getStyle('A3:H3')->getFill()->setFillType(PHPExcel_style_Fill::FILL_SOLID);
        $os->getStyle('A3:H3')->getFill()->getStartColor()->setARGB('FFFFA030');

        $os->setCellValue('A3', "科目编码");
        $os->setCellValue('B3', "科目名称");
        $os->setCellValue('C3', "期初借方");
        $os->setCellValue('D3', "期初贷方");
        $os->setCellValue('E3', "本期发生借方");
        $os->setCellValue('F3', "本期发生贷方");
        $os->setCellValue('G3', "期末借方");
        $os->setCellValue('H3', "期末贷方");

        $os->freezepane('A4');

        $ri = 4;

        foreach ($data as $sbjCat => $sbjCat_info) {
            switch ($sbjCat) {
                case "1":
                    $sbjCat_name = Yii::t('report', "资产小计");
                    break;
                case "2":
                    $sbjCat_name = Yii::t('report', "负债小计");
                    break;
                case "3":
                    $sbjCat_name = Yii::t('report', "权益小计");
                    break;
                case "4":
                    $sbjCat_name = Yii::t('report', "收入小计");
                    break;
                case "5":
                    $sbjCat_name = Yii::t('report', "费用小计");
                    break;

            };
            $items = $sbjCat_info["items"];

            foreach ($items as $info) {
                $os->setCellValueExplicit('A' . $ri, $info["subject_id"], PHPExcel_Cell_DataType::TYPE_STRING);
                $os->setCellValueExplicit('B' . $ri, $info["subject_name"], PHPExcel_Cell_DataType::TYPE_STRING);
                $os->setCellValue('C' . $ri, $info["start_debit"]);
                $os->setCellValue('D' . $ri, $info["start_credit"]);
                $os->setCellValue('E' . $ri, $info["sum_debit"]);
                $os->setCellValue('F' . $ri, $info["sum_credit"]);
                $os->setCellValue('G' . $ri, $info["end_debit"]);
                $os->setCellValue('H' . $ri, $info["end_credit"]);
                $ri ++;
            };

            $os->getStyle('A'.$ri.':H'.$ri)->getFill()->setFillType(PHPExcel_style_Fill::FILL_SOLID);
            $os->getStyle('A'.$ri.':H'.$ri)->getFill()->getStartColor()->setARGB('FFC0E0FF');
            $os->mergeCells('A'.$ri.':B'.$ri);
            $os->getStyle('A'.$ri)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $os->setCellValueExplicit('A' . $ri, $sbjCat_name, PHPExcel_Cell_DataType::TYPE_STRING);
            $os->setCellValue('C' . $ri, $sbjCat_info["start_debit"]);
            $os->setCellValue('D' . $ri, $sbjCat_info["start_credit"]);
            $os->setCellValue('E' . $ri, $sbjCat_info["sum_debit"]);
            $os->setCellValue('F' . $ri, $sbjCat_info["sum_credit"]);
            $os->setCellValue('G' . $ri, $sbjCat_info["end_debit"]);
            $os->setCellValue('H' . $ri, $sbjCat_info["end_credit"]);
            $ri ++;
            $ri++;
        }

        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream');
        header('Content-Type: application/download');
        header('Content-Disposition:inline;filename='
            . urldecode(urlencode($xlsName))
            . '.xls');
        header('Content-Transfer-Encoding: binary');
        header('Expires:Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: myst-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');
        $ow->save('php://output');

    }

}