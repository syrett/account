<?php

class StockController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'assets'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id,$action='')
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),'action'=>$action
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Stock;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stock']))
		{
			$model->attributes=$_POST['Stock'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$action='')
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stock']))
		{
			$model->attributes=$_POST['Stock'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id,'action'=>$action));
		}

		$this->render('update',array(
			'model'=>$model,'action'=>$action
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($action='')
	{
        $this->actionAdmin($action);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($action='')
	{
		$model=new Stock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stock']))
			$model->attributes=$_GET['Stock'];

		$this->render('admin',array(
			'model'=>$model,'action'=>$action
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stock the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Stock $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /*
     * excel导出模板，测试
     */
    public function actionExcel(){
        Yii::import('ext.phpexcel.PHPExcel');
        $products = Product::model()->listOrder();
        $stocks = Stock::model()->getStockArray();
        $stockName = '"';
        if(!empty($stocks)){
            foreach ($stocks as $key => $stock) {
                if($stockName!='"')
                $stockName .= ",$key";
                else
                    $stockName .= "$key";
            }
            $stockName .= '"';
        }
        $objExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->getCell('A1')->setValue('单号');
        $objActSheet->getCell('B1')->setValue('日期');
        $objActSheet->getCell('C1')->setValue('名称');
        $objActSheet->getCell('D1')->setValue('物品');
        $objActSheet->getCell('E1')->setValue('数量');
        $objActSheet->getCell('F1')->setValue('物品');
        $objActSheet->getCell('G1')->setValue('数量');
        $objActSheet->getCell('H1')->setValue('物品');
        $objActSheet->getCell('I1')->setValue('数量');
        $objActSheet->getCell('J1')->setValue('物品');
        $objActSheet->getCell('K1')->setValue('数量');
        $objActSheet->getCell('L1')->setValue('物品');
        $objActSheet->getCell('M1')->setValue('数量');
        $objActSheet->getCell('N1')->setValue('物品');
        $objActSheet->getCell('O1')->setValue('数量');
        $objActSheet->getCell('P1')->setValue('物品');
        $objActSheet->getCell('Q1')->setValue('数量');
        $objActSheet->getCell('R1')->setValue('物品');
        $objActSheet->getCell('S1')->setValue('数量');
        $objActSheet->getCell('T1')->setValue('物品');
        $objActSheet->getCell('U1')->setValue('数量(添加更多物品列，请复制“物品，数量”两列');
        if($products!=null&&!empty($products)){
//                $objActSheet->protectCells("A$row:C$row");
            $objActSheet->getStyle("D:AZ")->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objActSheet->getProtection()->setSheet(true);
            foreach ($products as $key => $item) {
                $row = $key + 2;
                $objActSheet->getCell("A$row")->setValue($item['order_no']);
                $objActSheet->getCell("B$row")->setValue($item['entry_date']);
                $objActSheet->getCell("C$row")->setValue($item['entry_name']);
                $arr = range('D','U',2);
                foreach($arr as $item){
                    $objValidation = $objActSheet->getCell("$item$row")->getDataValidation(); //这一句为要设置数据有效性的单元格
                    $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                        -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                        -> setAllowBlank(false)
                        -> setShowInputMessage(true)
                        -> setShowErrorMessage(true)
                        -> setShowDropDown(true)
                        -> setErrorTitle('输入的值有误')
                        -> setError('您输入的值不在物品列表内，请重新选择')
                        -> setPromptTitle('物品名称')
                        -> setFormula1($stockName); //'"列表项1,列表项2,列表项3"'

                }
            }
            foreach(range('A','B') as $column){
                $objActSheet->getColumnDimension($column)->setAutoSize(true);
            }

        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="excel.xls"');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }


    public function actionDepreciation($date){
        $this->saveDepreciation(1601, $date);   //固定资产等;
        $this->saveDepreciation(1701, $date);
        $this->saveDepreciation(1801, $date);
    }

    /*
     * 计提折旧
     */
    public function saveDepreciation($sbj, $date){
        $cdb = new CDbCriteria();
        $type = "";
        switch($sbj){
            case '1601': $type = '固定资产';$sbj_2 = '1602';$sbj_name = '折旧费';$x_name = '残值率';break;
            case '1701': $type = '无形资产';$sbj_2 = '1701';$sbj_name = '摊销费';$x_name = '摊销率';break;
            case '1801': $type = '长期待摊费用';$sbj_2 = '1801';$sbj_name = '摊销费';$x_name = '摊销率';break;
        }
        $list = Subjects::model()->list_sub($sbj);
        $amount = 0;
        foreach ($list as $key => $item) {
            $sbj = $item['sbj_number'];
            $cdb->condition = "entry_subject like '$sbj%'"; //固定资产等
            $stocks = Stock::model()->findAllByAttributes([], $cdb);
            $option = Options::model()->findByAttributes([], "entry_subject like '$sbj%'");
            foreach ($stocks as $item) {
//                if (!$item->overPeriod()) {
                $price = $item->getWorth();
                $price = $price * (100 - $option->value) / 100 / ($option->year * 12);
                $amount += $price;
                if (isset($list[$key]['entry_amount']))
                    $list[$key]['entry_amount'] += $price;
                else
                    $list[$key]['entry_amount'] = $price;
                if (!isset($list[$key]['sbj_2_name']))
                    $list[$key]['sbj_2_name'] = Subjects::model()->getName($item->entry_subject);
//                }
            }
        }
        if ($amount > 0) {
            $tran = new Transition();
            $tran->entry_num_prefix = $date;
            $tran->entry_num = $tran->tranSuffix($date);
            $tran->entry_date = date('Y-m-d 00:00:00', strtotime($date . '01'));
            $memo = "计提折旧-$date-$type";
            //删除当月已经生成的计提折旧凭证

            //假如本月之前有过过账操作，生成了计提折旧的凭证，现在的计提金额如果和以前一样则没有变化，如果有变化说明更改过年限或残值率
            $old = Transition::model()->findByAttributes(['entry_memo'=>$memo, 'entry_name' => $memo, 'entry_transaction' => 1]);
            if($old!=null && $old->entry_amount != sprintf("%.2f", $amount))
                Transition::model()->deleteAllByAttributes(['entry_memo' => $memo, 'entry_name' => $memo]);
            if($old==null || ($old->entry_amount != sprintf("%.2f", $amount))) {
                $tran->entry_name = $memo;
                $tran->data_type = "assets";
                $tran->entry_memo = $memo;
                $tran->entry_transaction = 1;
                $tran->entry_subject = Subjects::model()->matchSubject($sbj_name, ['6602']);
                $tran->entry_amount = $amount; //折旧率从账套参数获得
                $tran->entry_creater = Yii::app()->user->id;
                $tran->entry_editor = Yii::app()->user->id;
                $tran->save();
                foreach ($list as $key => $item) {
                    if (isset($item['sbj_2_name'])) {
                        $tran2 = new Transition();
                        $tran2->attributes = $tran->attributes;
                        $tran2->attributes = $item;
                        $tran2->entry_transaction = 2;
                        if ($sbj != '1801')
                            $tran2->entry_subject = Subjects::model()->matchSubject($item['sbj_2_name'], [$sbj_2]);
                        else
                            $tran2->entry_subject = '1801'; //长期待摊费用不需要子科目
                        $tran2->save();
                    }
                }
                //结账的时候再保存净值，因为当月多次过账的时候，需要使用数据：上月净值，
            }
        }
    }
}
