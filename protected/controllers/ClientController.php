<?php

class ClientController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/main', meaning
	 * using one-column layout. See 'protected/views/layouts/main.php'.
	 */
	public $layout='//layouts/main';

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
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Client;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
			$model->attributes=$_POST['Client'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Client']))
		{
            $oldName = $model->company;
			$model->attributes=$_POST['Client'];
			if($model->save()){
                //更新科目表
                Subjects::model()->updateName($oldName,$model->company);
                $this->redirect(array('admin'));
            }
		}

        $dataProvider=$model->search();
		$this->render('update',array(
			'model'=>$model,
            'dataProvider' => $dataProvider,
		));

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//        $cat = Yii::app()->createController('Subjects');
//        $cat = $cat[0];
//        $model = $this->loadModel($id);
//        $sbjs = Subjects::model()->findAllByAttributes(['sbj_name'=>$model->company], 'length(sbj_number) > 4');
//        foreach($sbjs as $item){
//            $cat->actionDelete($item->id);
//        }
//        //再次查看，以确认是否删除
//        $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$model->company], 'length(sbj_number) > 4');
        $model = $this->loadModel($id);
        $sbj = Subjects::model()->findByAttributes(['sbj_name'=>$model->company]);
        //如果科目表有以该客户名称为名的科目，则不能删除，
        if($sbj==null)
		    $this->loadModel($id)->delete();
        else
            echo '该客户不能删除';

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Client');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Client('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Client']))
			$model->attributes=$_GET['Client'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Client the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Client::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Client $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='client-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    /*
     * 新建供应商
     */
    public function actionCreateclient()
    {
        if (Yii::app()->request->isAjaxRequest ) {
            $model = new Client();
            $data['company'] = $_POST['name'];
            $a = $model->model()->findByAttributes($data);
            if ($a != null)
                echo $a->id;
            else {
                $model = new Client;
                $model->attributes = $data;
                if ($model->save())
                    echo $model->id;
                else
                    echo 0;
            }
        }
    }

    /*
     * 获取供应商列表
     */
    public function actionGetclient(){
        if (Yii::app()->request->isAjaxRequest ) {
            $models = Client::model()->findAll();
            foreach($models as $model){
                $result[$model->id] = $model->company;
            }
            echo json_encode($result);
        }
    }
}
