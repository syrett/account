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
                'actions' => array('admin', 'delete'),
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
}
