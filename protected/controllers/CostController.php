<?php

class CostController extends Controller
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
                'actions'=>array('index','create','update','save','delete'),
                'users'=>array('@'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
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
		$model=new Cost;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cost']))
		{
			$model->attributes=$_POST['Cost'];
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
            $sheetData = $cat->saveAll('stock', $id);
            if (!empty($sheetData))
                foreach ($sheetData as $item) {
                    if ($item['status'] == 0) {
                        Yii::app()->user->setFlash('error', "保存失败!");
                        $model = $this->loadModel($id);
                        $sheetData[0]['status'] = 0;
                        $sheetData[0]['data'] = Transition::getSheetData($item['data'],'stock');
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
                $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'stock');
                if($tran!=null)
                    $sheetData[0]['data']['entry_reviewed'] = $tran->entry_reviewed;
                $this->redirect(array('update','id'=>$model->id));
            }
        }else {
            $model = $this->loadModel($id);
            //收费版需要加载跟此数据相关的，关键字为parent
            $sheetData[0]['data'] = Transition::getSheetData($model->attributes,'stock');
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
        $model = $this->loadModel($id);
		//删除凭证
        Transition::model()->deleteAllByAttributes(['data_type'=>'stock', 'data_id'=>$id]);
        //修改stock
        Stock::model()->updateAll(['cost_date'=>'', 'status'=>1],"name = '$model->entry_name' and model = '$model->model' and ".'cost_date like "'. substr($model->entry_date,0,4). '%"');
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Cost('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Cost']))
            $model->attributes=$_GET['Cost'];

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
	 * @return Cost the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cost::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cost $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cost-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
