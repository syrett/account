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

    /*
     * 导入的期初数据可以修改删除
     */
    public function actionBalance($type){

        $model = new Stock('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Stock']))
            $model->attributes = $_GET['Stock'];
        $dataProvider = $model->search3($type);
        $dataProvider->pagination = array(
            'pageSize' => 30
        );
        $this->render('balance', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
            'type' => $type
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
     * excel导出库存模板
     */
    public function actionExcel1(){
        Yii::import('ext.phpexcel.PHPExcel');
        $products = Product::model()->listOrder();
        $stocks = Stock::model()->getStockArray('1405');    //采购的商品才显示，固定资产类的名称不显示
        $stockName = '"';
        $filename = '结转成本销售单';
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
        header("Content-Disposition:attachment;filename='$filename.xls'");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    public function actionExcel(){
        Yii::import('ext.phpexcel.PHPExcel');
        $stocks = Stock::model()->getStockArray2(['1403','1405']);    //采购的商品才显示，固定资产类的名称不显示
        $filename = '结转成本盘点库存';
        $objExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->getCell('A1')->setValue('日期('.date('Ym').')');
        $objActSheet->getCell('B1')->setValue('名称');
        $objActSheet->getCell('C1')->setValue('型号');
        $objActSheet->getCell('D1')->setValue('库存盘点数量');
        if($stocks!=null&&!empty($stocks)){
            foreach ($stocks as $key => $item) {
                $row = $key + 2;
                $objActSheet->getCell("B$row")->setValue($item['name']);
                $objActSheet->getCell("C$row")->setValue($item['model']);
            }
        }

        $objActSheet->getColumnDimension('A')->setWidth(14);
        foreach(range('B','D') as $column){
            $objActSheet->getColumnDimension($column)->setWidth(15);
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename='$filename.xls'");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    public function actionExcel1601(){
        Yii::import('ext.phpexcel.PHPExcel');
        $subject_array = Subjects::model()->listSubjects('1601');
        $subject_array += Subjects::model()->listSubjects('1701');
        $subject_array += Subjects::model()->listSubjects('1801');
        $filename = '固定资产期初余额';
        $subjectName = '"';
        if(!empty($subject_array)){
            foreach ($subject_array as $key => $stock) {
                if($subjectName!='"')
                    $subjectName .= ",$stock";
                else
                    $subjectName .= "$stock";
            }
            $subjectName .= '"';
        }
        //部门
        $depart = Department::model()->findAll();
        $departName = '"';
        if(!empty($depart)){
            foreach ($depart as $item) {
                if($departName != '"')
                    $departName .= ",$item->name";
                else
                    $departName .= "$item->name";
            }
            $departName .= '"';
        }
        //要把数字去掉，否则无法生成excel,
        $subjectName = preg_replace('/\d/', '', $subjectName);
        $objExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->getCell('A1')->setValue('编号');
        $objActSheet->getCell('B1')->setValue('名称');
        $objActSheet->getCell('C1')->setValue('型号');
        $objActSheet->getCell('D1')->setValue('数量');
        $objActSheet->getCell('E1')->setValue('单位原值');
        $objActSheet->getCell('F1')->setValue('已计提折旧金额');
        $objActSheet->getCell('G1')->setValue('剩余折旧摊销月份');
        $objActSheet->getCell('H1')->setValue('残值率%');
        $objActSheet->getCell('I1')->setValue('分类');
        $objActSheet->getCell('J1')->setValue('部门');
        $i = 1;
        while($i<=50){
            if($subjectName!='""'){
                $objValidation = $objActSheet->getCell("I$i")->getDataValidation(); //这一句为要设置数据有效性的单元格
                $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    -> setAllowBlank(false)
                    -> setShowInputMessage(true)
                    -> setShowErrorMessage(true)
                    -> setShowDropDown(true)
                    -> setErrorTitle('输入的值有误')
                    -> setError('您输入的值不在物品列表内，请重新选择')
                    -> setPromptTitle('物品名称')
                    -> setFormula1($subjectName); //'"列表项1,列表项2,列表项3"'
            }
            if($departName!='""'){
                $objValidation = $objActSheet->getCell("J$i")->getDataValidation(); //这一句为要设置数据有效性的单元格
                $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                    -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                    -> setAllowBlank(false)
                    -> setShowInputMessage(true)
                    -> setShowErrorMessage(true)
                    -> setShowDropDown(true)
                    -> setErrorTitle('输入的值有误')
                    -> setError('您输入的值不在物品列表内，请重新选择')
                    -> setPromptTitle('部门名称')
                    -> setFormula1($departName); //'"列表项1,列表项2,列表项3"'
            }
            $i++;

        }
        //设置自动宽度，中文不起作用
        $objActSheet->getColumnDimension('F')->setWidth(17);
        $objActSheet->getColumnDimension('G')->setWidth(20);
        $objActSheet->getColumnDimension('I')->setWidth(24);
        $objActSheet->getColumnDimension('J')->setWidth(17);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename='$filename.xls'");
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
    }

    public function actionExcel1405(){
        Yii::import('ext.phpexcel.PHPExcel');
        $subject_array = Subjects::model()->listSubjects('1405');
        $subject_array += Subjects::model()->listSubjects('1403');
        $filename = '库存商品期初余额';
        $subjectName = '"';
        if(!empty($subject_array)){
            foreach ($subject_array as $key => $stock) {
                if($subjectName!='"')
                    $subjectName .= ",$stock";
                else
                    $subjectName .= "$stock";
            }
            $subjectName .= '"';
        }
        //要把数字去掉，否则无法生成excel,
        $subjectName = preg_replace('/\d/', '', $subjectName);
        $objExcel = new PHPExcel();
        $objWriter = new PHPExcel_Writer_Excel5($objExcel);
        $objExcel->setActiveSheetIndex(0);
        $objActSheet = $objExcel->getActiveSheet();
        $objActSheet->getCell('A1')->setValue('编号');
        $objActSheet->getCell('B1')->setValue('名称');
        $objActSheet->getCell('C1')->setValue('型号');
        $objActSheet->getCell('D1')->setValue('数量');
        $objActSheet->getCell('E1')->setValue('单位原值');
        $objActSheet->getCell('F1')->setValue('分类');
        $i = 1;
        while($i<=50){
            $objValidation = $objActSheet->getCell("F$i")->getDataValidation(); //这一句为要设置数据有效性的单元格
            $objValidation -> setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                -> setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                -> setAllowBlank(false)
                -> setShowInputMessage(true)
                -> setShowErrorMessage(true)
                -> setShowDropDown(true)
                -> setErrorTitle('输入的值有误')
                -> setError('您输入的值不在物品列表内，请重新选择')
                -> setPromptTitle('物品名称')
                -> setFormula1($subjectName); //'"列表项1,列表项2,列表项3"'
            $i++;

        }
        //设置自动宽度，中文不起作用
        $objActSheet->getColumnDimension('F')->setWidth(24);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename='$filename.xls'");
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
            foreach ($stocks as $item) {
//                if (!$item->overPeriod()) {
                $price = $item->getWorth();
                $price = $price * (100 - $item->value_rate) / 100 / $item->value_month;
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
                $tran->entry_amount = $amount;
                $tran->entry_creater = Yii::app()->user->id;
                $tran->entry_editor = Yii::app()->user->id;
                $tran->entry_reviewed = 1;
                $tran->entry_reviewer = 1;
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

    /*
     * 库存商品期初余额
     */
    public function actionBalance_1405(){

        $stocks = Stock::model()->find(['condition'=>'order_no is null and (entry_subject like "1403%" or entry_subject like "1405%")']);
        if($stocks)
            $this->redirect(['balance','type'=>1405]);
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $arr = Stock::getSheetData('库存商品', $item);
                    if($arr['count'] != 0)
                        $sheetData[] = $arr;
                }

            } elseif($_FILES['attachment']['name']==''){
                $lists = $_POST['Stock'];
                //先判断每类科目金额是否和总账期初余额相等

                $subject_array = Subjects::model()->listSubjects('1403');
                $subject_array += Subjects::model()->listSubjects('1405');
                foreach ($subject_array as $item => $subject) {
                    //筛选分类和$item相同科目的行，然后计算金额是否与总账相等
                    $rows = array_filter($lists, function ($v) use ($item) {
                        return $v['entry_subject'] == $item;
                    });
                    $amount = 0;
                    foreach ($rows as $row) {
                        $amount += $row['in_price'] * $row['count'];
                    }
                    //计算科目期初余额
                    $balance = Subjects::get_balance($item);
                    if($balance != $amount){
                        Yii::app()->user->setFlash('error', Subjects::getSbjPath($item).' 金额与总账期初余额不相等');
                        foreach ($lists as $row) {
                            $sheetData[] = Stock::getSheetData('库存商品', $row);
                        }
                        break;
                    }
                }
                if(!isset($sheetData))
                    foreach ($lists as $item) {
                        $stock = new Stock();
                        $stock->attributes = $item;
                        if(!$stock->saveMultiple($item['count']))
                            $sheetData[] = ['count'=>$item['count'], $stock];
                    }
                if(empty($sheetData)){
                    Yii::app()->user->setFlash('success', "添加成功!");
                    $this->redirect(['balance','type'=>1405]);
                }
            }
        }

        if (empty($sheetData)){
            $sheetData[] = Stock::getSheetData('库存商品','');
        }
        $this->render('balance_1405',['sheetData' => $sheetData]);
    }

    /*
     * 固定资产期初余额
     */
    public function actionBalance_1601(){
        //检查是否导入过固定资产的期初，已经导入过就直接跳转到查看页面
        $stocks = Stock::model()->find(['condition'=>'order_no is null and (entry_subject like "1601%" or entry_subject like "1701%" or entry_subject like "1801%")']);
        if($stocks)
            $this->redirect(['balance','type'=>1601]);
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $arr = Stock::getSheetData('固定资产', $item);
                    if($arr['count'] != 0)
                        $sheetData[] = $arr;
                }
            } elseif($_FILES['attachment']['name']==''){
                $lists = $_POST['Stock'];
                //先判断每类科目金额是否和总账期初余额相等

                $subject_array = Subjects::model()->listSubjects('1601');
                $subject_array += Subjects::model()->listSubjects('1701');
                $subject_array += Subjects::model()->listSubjects('1801');
                foreach ($subject_array as $item => $subject) {
                    //筛选分类和$item相同科目的行，然后计算金额是否与总账相等
                    $rows = array_filter($lists,function($v) use ($item){
                        return $v['entry_subject']==$item;
                    });
                    $amount = 0;
                    foreach ($rows as $row) {
                        $amount += $row['worth']*$row['count'];
                    }
                    //计算科目期初余额
                    $balance = Subjects::get_balance($item);
                    if($balance != $amount){
                        Yii::app()->user->setFlash('error', Subjects::getSbjPath($item).' 金额与总账期初余额不相等');
                        foreach ($lists as $row) {
                            $sheetData[] = Stock::getSheetData('固定资产', $row);
                        }
                        break;
                    }
                }
                if(!isset($sheetData))
                    foreach ($lists as $item) {
                        $stock = new Stock();
                        $stock->attributes = $item;
                        if(!$stock->saveMultiple($item['count']))
                            $sheetData[] = ['count'=>$item['count'], $stock];
                    }
                if(empty($sheetData)){
                    Yii::app()->user->setFlash('success', "添加成功!");
                    $this->redirect(['balance','type'=>1601]);
                }

            }
        }

        if (empty($sheetData)){
            $sheetData[] = Stock::getSheetData('固定资产','');
        }
        $this->render('balance_1601',['sheetData' => $sheetData]);
    }

    public function actionTruncate(){

        if(isset(Yii::app()->request->isAjaxRequest)) {

            $post = Transition::model()->findByAttributes(['entry_posting'=>1]);
            if($post)
                $result = ['status'=>'failed','msg'=>'有商品已经成本结转或出库，或已经过账，无法清空'];
            else{
                $type = $_POST['type'];
                if($type=='1601'){
                    $condition = 'order_no is null and (entry_subject like "1601%" or entry_subject like "1701%" or entry_subject like "1801%") ';
                }elseif($type=='1405'){
                    $condition = 'order_no is null and (entry_subject like "1403%" or entry_subject like "1405%")';
                }
                //已经成本结转或出库或已经过账，无法清空
                $cost = Stock::model()->findByAttributes([],$condition. " and (cost_date != '' or status != 1)");
                if(!$cost){
                    Stock::model()->deleteAllByAttributes(['status'=>1, 'cost_date'=>''],$condition);
                    $result = ['status'=>'success','msg'=>'成功清空期初余额'];
                }
                else
                    $result = ['status'=>'failed','msg'=>'有商品已经成本结转或出库，或已经过账，无法清空'];
            }
            echo json_encode($result);
        }
    }
}
