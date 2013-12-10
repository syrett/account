<?php

class TransitionController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
                  'actions'=>array('create','update','getTranSuffix', 'reorganise',),
				'users'=>array('@'),
			),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
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
      

		$model=new Transition;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transition']))
		{

          $post_arr = $_POST['Transition'];
          
          if($post_arr['entry_editor'] == $post_arr['entry_reviewer'])
            {
              $model->addError('editor_reviewer', "审核者不能是自己");
              
            }else
            {
			$model->attributes=$_POST['Transition'];
			if($model->save())
              $this->redirect(array('view','id'=>$model->id));
            }
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transition']))
		{
			$model->attributes=$_POST['Transition'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
	public function actionIndex()
	{
      $dataProvider=new CActiveDataProvider('Transition');
      $this->render('index',array(
                                  'dataProvider'=>$dataProvider,
                                  ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Transition('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transition']))
			$model->attributes=$_GET['Transition'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionReorganise()
    {
      if(!isset($_POST['entry_num_prefix'])){
        $prefix=date('Y').date('m');
      };
      $del_condition='entry_num_prefix=:prefix and entry_deleted=:bool';
      Transition::model()->deleteAll($del_condition,array(':prefix'=>$prefix,':bool'=>1));

      $sql="select id from transition where entry_num_prefix=:prefix";
      $data=Transition::model()->findAllBySql($sql,array(':prefix'=>$prefix));
      
      $arr=array();
      $i=1;
      foreach($data as $row){
        $pk=$row['id'];
        Transition::model()->updateByPk($pk,array('entry_num'=>$i));
        $i++;
      }
      $this->redirect("index.php?r=transition/index");
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Transition the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Transition::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Transition $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='transition-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /*
     * return transition number entry_num
     */
    public function tranNumber($result=""){
        if($result=="")
            $result = date("Ym",time());
        $result .= $this->tranSuffix($result);
        return $result;
    }
    /*
     * return transition number entry_num suffix
     */
    public function tranSuffix($prefix=""){
        if($prefix=="")
            $prefix = date("Ym",time());
        $data = Yii::app()->db->createCommand()
            ->select('max(a.entry_num) b')
            ->from('transition as a')
            ->where('entry_num_prefix="'. $prefix. '"')
            ->queryRow();
        if($data['b']=='')
            $data['b'] = 0;
        $num = $data['b'] + 1;
        $num = substr(strval($num+10000),1,4);  //数字补0
        return $num;
    }

    /*
     * ajax return transition number entry_num suffix
     */
    public function actionGetTranSuffix(){
        if(Yii::app()->request->isPostRequest){
            if(!isset($_POST['entry_prefix'])||$_POST['entry_prefix']=="")
                $prefix = date("Ym",time());
            else
                $prefix = $_POST['entry_prefix'];
            echo $this->tranSuffix($prefix);
        }
        else
            echo 0;
    }
}
