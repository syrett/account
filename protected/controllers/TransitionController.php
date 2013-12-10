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
				'actions'=>array('create','update','getTranSuffix','Appendix', 'ListFirst'),
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

    public function actionReview()
    {
      //todo
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

    /*
     *  getVendorlist
     */
    public function getUserlist(){
        $data = User::model()->findAll();
        return $data;
    }

    /*
     *  getVendorlist
     */
    public function getVendorlist(){
        $data = Vendor::model()->findAll();
        return $data;
    }

    /*
     *  getClientlist
     */
    public function getClientlist(){
        $data = Client::model()->findAll();
        return $data;
    }

    /*
     *  getSubjectID get id list by group
     *  1：资产 2：负债 3：权益 4：收入 5：费用
     */
    public function getSubjectID($group){
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from('subjects as a')
            ->where('sbj_cat = '. $group)
            ->queryAll();
        $arr = array();
        foreach($data as $item){
            array_push($arr, $item['sbj_number']);
        }
        return $arr;
    }

    /*
     *  return corresponding appendix
    */
    public function actionAppendix()
    {
        $subject = $_POST["Name"];
        $html = "";
        if(Yii::app()->request->isPostRequest)
        {
            switch($subject){
                case 1122 :     // 应付账款，列出供应商
                    $data = $this->getVendorlist();
                    foreach($data as $item){
                        $html .= "<option value=".$item['id'] .">". $item['company']."</options>";
                    }
                    break;
                case 2202 :     // 应收账款，列出客户列表
                    $data = $this->getClientlist();
                    foreach($data as $item){
                        $html .= "<option value=".$item['id'] .">". $item['company']."</options>";
                    }
                    break;
                default :
                    $list = $this->getSubjectID(4);
                    if(in_array($subject, $list)){  //全部 4:收入 类科目  列出项目project
                        $data = Project::model()->findAll();
                        foreach($data as $item){
                            $html .= "<option value=".$item['id'] .">". $item['name']."</options>";
                        }
                        break;
                    }
                    $list = $this->getSubjectID(5);
                    if(in_array($subject, $list)){  //全部 5:费用 类科目   列出员工employee
                        $data = Employee::model()->findAll();
                        foreach($data as $item){
                            $html .= "<option value=".$item['id'] .">". $item['name']."</options>";
                        }
                        break;
                    }

            }
            if($html!="")
                echo '<select>'.$html.'</select>';
            else
                echo '';
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    /**
     * 列出一级科目
     */
    public function actionListFirst()
    {
        //todo
        $sql = "select * from subjects where sbj_number < 10000"; // 一级科目的为1001～9999
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach($First as $row) {
            $arr += array( $row['sbj_number']=> $row['sbj_number'].$row['sbj_name']);
        };
        return $arr;
    }
}
