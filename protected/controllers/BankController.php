<?php

class BankController extends Controller
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
				'actions'=>array('index','create','delall','update','type','option','createemployee','createsubject','save'),
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
			$sheetData = $cat->saveAll('bank', $id);
			if (!empty($sheetData))
				foreach ($sheetData as $item) {
					if ($item['status'] == 0) {
						Yii::app()->user->setFlash('error', "保存失败!");
                        $model = $this->loadModel($id);
                        $sheetData[0]['status'] = 0;
                        $sheetData[0]['data'] = Transition::getSheetData($item['data']);
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
                $sheetData[0]['data'] = Transition::getSheetData($model->attributes);
                $sheetData[0]['data']['entry_reviewed'] = $tran->entry_reviewed;
            }
		}else {
			$model = $this->loadModel($id);
			//收费版需要加载跟此数据相关的，关键字为parent
			$sheetData[0]['data'] = Transition::getSheetData($model->attributes);
            if($model->status_id==1)
            {
                $tran = Transition::model()->find(['condition' => 'data_id=:data_id', 'params' => [':data_id' => $id]]);
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
		$this->loadModel($id)->delete();

		$trans = Transition::model()->findAll(['condition'=>'data_id=:data_id','params'=>[':data_id'=>$id]]);
		foreach($trans as $item){
			$item->delete();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

    /*
     * delete all
     */
    public function actionDelall(){
        if (Yii::app()->request->isPostRequest)
        {
            $criteria= new CDbCriteria;
            $criteria->addInCondition('id', $_POST['selectdel']);
            $cri = new CDbCriteria;
            $cri->addInCondition('data_id', $_POST['selectdel']);
            Bank::model()->deleteAll($criteria);
            Transition::model()->deleteAll($cri);


            if(isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
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
		$model=new Bank('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bank']))
			$model->attributes=$_GET['Bank'];

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
	 * @return Bank the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bank::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bank $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bank-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /*
     * ajax
     */
    public function actionType()
    {
        if (Yii::app()->request->isAjaxRequest)
            echo json_encode(Bank::chooseType($_POST['type']));
        else
            throw new CHttpException(403,'不允许提交');
    }

    /*
     * 返回的选项
     * $_POST['pid'] int 父id
     * $_POST['id']  int 当前选择id
     */
    public function actionOption()
    {
        if (Yii::app()->request->isAjaxRequest) {
            echo json_encode(Bank::chooseOption($_POST['type'], $_POST['option'], $_POST['data']));
        } else
            throw new CHttpException(403,'不允许提交');
    }

}
