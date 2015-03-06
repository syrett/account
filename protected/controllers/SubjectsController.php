<?php

class SubjectsController extends Controller
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
                  //                  'actions'=>array('create','update', 'listfirst', 'listsub','balance'),
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
      var_dump($this->loadModel($id));
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
		$model=new Subjects;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Subjects']))
		{
            $sbj_number = $_POST['Subjects']['sbj_number'];
            $sbj_type = $_POST['sbj_type'];
            $sbj_number = Subjects::model()->init_new_sbj_number($sbj_number,$sbj_type);
            $_POST['Subjects']['sbj_number'] = $sbj_number;
            $model->attributes=$_POST['Subjects'];
			if($model->save())
            {
                //如果是新的子科目，将post中科目表id修改为新id
//                $sbj_id = trim($_POST['Subjects']['sbj_number']);
                $sbj_id = $sbj_number;
                if(strlen($sbj_id)>4&&$sbj_type==2)  ////1为同级科目，2为子科目
                {
                    Post::model()->tranPost($sbj_id);
                    Subjects::model()->hasSub($sbj_id);
                }


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

		if(isset($_POST['Subjects']))
		{
          $model->attributes=$_POST['Subjects'];

          $model->save();
          
          $this->redirect(array('view','id'=>$model->id));

		}else{

          $this->render('update',array(
                                       'model'=>$model,
                                     ));
        }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
//		$this->loadModel($id)->delete();
//
//		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//		if(!isset($_GET['ajax']))
//			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Subjects');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
//
//    /**
//     * 列出一级科目
//     */
//    public function actionListFirst()
//    {
//      $sql = "select * from subjects where sbj_number < 10000"; // 一级科目的为1001～9999
//      $First = Subjects::model()->findAllBySql($sql);
//      $arr = array();
//      foreach($First as $row) {
//                  array_push($arr, $row['sbj_number'], $row['sbj_name']);
//      };
//      return $arr;
//    }
//
//    /*
//     * 列出二级,三级科目
//     */
//    public function actionListSub($sbj_number=1001)
//    {
//      //todo
//      //      $sbj_number = $_POST['sbj_number'];
//      $sql = "select * from Subjects where sbj_number > :min and sbj_number < :max";
//      $min = (int)(((string)$sbj_number)."00");
//      $max = (int)(((string)$sbj_number)."99");
//      $data = Subjects::model()->findAllBySql($sql, array(':min'=>$min,
//                                                          ':max'=>$max));
//      foreach($data as $row) {
//        $arr[$row['sbj_number']] = array($row['sbj_name'], $row['has_sub']);
//        //        array_push($arr, $row['sbj_number'], $row['sbj_name']);
//      };
//      $this->render('list', array(
//                                  'list'=>$arr,
//                                  ));
//    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Subjects('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subjects']))
			$model->attributes=$_GET['Subjects'];

        $dataProvider= $model->search();
        $dataProvider->pagination=array(
                                        'pageSize' => 30
                                        );
		$this->render('admin',array(
                                    'dataProvider'=>$dataProvider,        
                                    'model'=>$model,
		));
	}


    //余额设置
    public function actionBalance() {

      $data = Subjects::model()->list_can_set_balnce_sbj();      
      
      $err_msg='';
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      	$p_data = array();
	foreach($_POST as $k=>$v) {
	    if (is_numeric($k)&&is_numeric($v)){
	    	$p_data[$k]=$v;
		}
	}
	$model = new Subjects();
        $bool=$model->check_start_balance($p_data);
        if ($bool) {
          Subjects::model()->set_start_balance($p_data);
          $this->redirect("?r=subjects/balance");
        }else{
            $err_msg="资产与负债权益的和不等";
        }
        
      }

      $this->render('balance',array(
                                    'data'=>$data,        
                                    'error'=>$err_msg,
                                    ));      
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Subjects the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Subjects::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Subjects $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subjects-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
