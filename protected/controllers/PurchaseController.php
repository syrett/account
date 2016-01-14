<?php

class PurchaseController extends Controller
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
        $rules = parent::accessRules();
        if ($rules[0]['actions'] == ['manage'])
            $rules[0]['actions'] = [''];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['index']);
        return $rules;
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Purchase;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Purchase']))
		{
			$model->attributes=$_POST['Purchase'];
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
	public function actionUpdate($id)
	{
        if (Yii::app()->request->isPostRequest) {
            $cat = Yii::app()->createController('Transition');
            $cat = $cat[0];
            $sheetData = $cat->saveAll('purchase', $id);
            if (!empty($sheetData))
                foreach ($sheetData as $item) {
                    if ($item['status'] == 0) {
                        Yii::app()->user->setFlash('error', "保存失败!");
                        $model = $this->loadModel($id);
                        $sheetData[0]['status'] = 0;
                        $sheetData[0]['data'] = Transition::getSheetData($item['data'],'purchase');
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
                $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'purchase');
                if($tran!=null)
                    $sheetData[0]['data']['entry_reviewed'] = $tran->entry_reviewed;
            }
        }else {
            $model = $this->loadModel($id);
            //收费版需要加载跟此数据相关的，关键字为parent
            $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'purchase');
            if($model->status_id==1)
            {
                $tran = Transition::model()->find(['condition' => 'data_id=:data_id and data_type=:data_type', 'params' => [':data_id' => $id, ':data_type' => 'purchase']]);
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
    public function actionDelete($id, $type=1)
	{
        $relation = Purchase::model()->getRelation('purchase', $id);
        if($relation==null) {
            $model = $this->loadModel($id);
            $order_no = $model->order_no;

            //凭证是否可以删除
            $trans = Transition::model()->findAll(['condition'=>'data_type = "purchase" and data_id=:data_id','params'=>[':data_id'=>$id]]);
            $delete = true;
            foreach($trans as $item){
                $delete = $item['entry_reviewed']==1?false:$delete;
            }
            if(!$delete){		//如果不能删除就直接返回
                $result['status'] = 'failed';
                $result['message'] = '生成的凭证已审核或已过账，无法删除';
                echo json_encode($result);
                return true;
            }
            foreach($trans as $item){
                $item->delete();
            }
            //删除stock
            Stock::model()->deleteAllByAttributes(['order_no'=>$order_no]);
            $model->delete();
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
        if(!isset($_GET['ajax']) && $type==1)
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    /*
     * delete all
     */
    public function actionDelall(){
        if (Yii::app()->request->isPostRequest)
        {
            $in = [];
            foreach($_POST['selectdel'] as $item){
                $relation = Purchase::model()->getRelation('purchase', $item);
                if(empty($relation))
                    $in[] = $item;
            }
            $criteria= new CDbCriteria;
            $criteria->addInCondition('id', $in);
            $models = Pruchase::model()->findAll($criteria);
            if(!empty($models))
                foreach ($models as $key => $item) {
                    if($this->actionDelete($item->id, 2))
                        unset($in[$key]);
                }

            if(count($in) == count($_POST['selectdel']))
                $status = 'success';
            elseif(empty($in))
                $status = 'failed';
            else
                $status = 'few';

            if(isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('status' => $status));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'不合法的请求，请稍后重试');
    }

    /**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Purchase('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Purchase']))
            $model->attributes=$_GET['Purchase'];

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
	 * @return Purchase the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Purchase::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Purchase $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchase-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
