<?php

class ProductController extends Controller
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
                'actions'=>array('index','update','save','delete','stock'),
                'users'=>array('@'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        if (Yii::app()->request->isPostRequest) {
            $cat = Yii::app()->createController('Transition');
            $cat = $cat[0];
            $sheetData = $cat->saveAll('product', $id);
            if (!empty($sheetData))
                foreach ($sheetData as $item) {
                    if ($item['status'] == 0) {
                        Yii::app()->user->setFlash('error', "保存失败!");
                        $model = $this->loadModel($id);
                        $sheetData[0]['status'] = 0;
                        $sheetData[0]['data'] = Transition::getSheetData($item['data'],'product');
                    }
                    if ($item['status'] == 2) {
                        Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                        $model = $this->loadModel($id);
                    }
                }
            else
            {
                Yii::app()->user->setFlash('success', "保存成功!");
                $model = $this->loadModel($id);
                $tran = Transition::model()->find(['condition' => 'data_id=:data_id', 'params' => [':data_id' => $id]]);
                $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'product');
                if($tran!=null)
                    $sheetData[0]['data']['entry_reviewed'] = $tran->entry_reviewed;
                $this->redirect(array('update','id'=>$model->id));
            }
        }else {
            $model = $this->loadModel($id);
            //收费版需要加载跟此数据相关的，关键字为parent
            $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'product');
            if($model->status_id==1)
            {
                $tran = Transition::model()->find(['condition' => 'data_id=:data_id', 'params' => [':data_id' => $id]]);
                if($tran!=null)
                    $sheetData[0]['data']['entry_reviewed'] = $tran->entry_reviewed;
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'sheetData'=>$sheetData
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
        $relation = Product::model()->getRelation('product', $id);
        if($relation==null) {
            $model = $this->loadModel($id);
            $order_no = $model->order_no;
            $model->delete();

            $trans = Transition::model()->findAll(['condition'=>'data_type = "product" and data_id=:data_id','params'=>[':data_id'=>$id]]);
            foreach($trans as $item){
                $item->delete();
            }
            //删除预订单里和此项目有关联的金额
            $porders = Preparation::model()->findAllByAttributes([], "real_order like '%$order_no%'");
            if(!empty($porders)){
                foreach ($porders as $item) {
                    $real_order = json_decode($item['real_order'], true);
                    $item['amount_used'] -= $real_order[$order_no];
                    unset($real_order[$order_no]);
                    $item['real_order'] = json_encode($real_order);
                    $item->save();
                }
            }
        }else{
            $result['status'] = 'failed';
            $result['message'] = '其他数据与此交易有关联，无法删除';
            echo json_encode($result);
        }
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Product('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Product']))
            $model->attributes=$_GET['Product'];

        $dataProvider= $model->search();
        $dataProvider->pagination=array(
            'pageSize' => 20
        );
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
            'model'=>$model,
        ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Product the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Product $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /*
     * 成本结转
     */
    public function actionStock($id=''){
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                array_shift($list);
                foreach($list as $item){
                    $arr = Transition::getSheetData($item,'cost');
                    if(!empty($arr))
                        $sheetData[] = $arr;
                }
            } elseif($_FILES['attachment']['name']=='' && isset($_POST['lists'])){
                //保存按钮
                $cat = Yii::app()->createController('Transition');
                $cat = $cat[0];
                $arr = $cat->saveAll('stock', $id);
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'],'cost');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('product/stock'));
                }
            }
        }

        if (empty($sheetData)){
//            $sheetData[] = Transition::getSheetData([],'cost');
            $sheetData = [];
        }

        $model[] = new Transition();
        return $this->render('stock', ['type' => 'cost', 'sheetData' => $sheetData, 'info' => $info]);
    }
}
