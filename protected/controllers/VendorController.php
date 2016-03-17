<?php

class VendorController extends Controller
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
        $rules = parent::accessRules();
        if ($rules[0]['actions'] == ['manage'])
            $rules[0]['actions'] = ['index', 'admin', 'update', 'create', 'view', 'delete'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['createvendor', 'getvendor']);
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
		$model=new Vendor;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vendor']))
		{
			$model->attributes=$_POST['Vendor'];
			if($model->save())
				$this->redirect(array('admin'));
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

		if(isset($_POST['Vendor']))
		{
            $oldName = $model->company;
			$model->attributes=$_POST['Vendor'];
			if($model->save()){
                //更新科目表
                Subjects::model()->updateName($oldName,$model->company);
                $this->redirect(array('admin'));

            }
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
            echo '该供应商不能删除';

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Vendor');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vendor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vendor']))
			$model->attributes=$_GET['Vendor'];

        $dataProvider = $model->search();
		$this->render('admin',array(
			'model'=>$model,
            'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vendor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vendor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vendor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vendor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /*
     * 新建供应商
     */
    public function actionCreatevendor()
    {
        if (Yii::app()->request->isAjaxRequest ) {
            $model = new Vendor();
            $data['company'] = $_POST['name'];
            $a = $model->model()->findByAttributes($data);
            if ($a != null)
                echo $a->id;
            else {
                $model = new Vendor;
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
    public function actionGetvendor(){
        if (Yii::app()->request->isAjaxRequest ) {
            $models = Vendor::model()->findAll();
            foreach($models as $model){
                $result[$model->id] = $model->company;
            }
            echo json_encode($result);
        }
    }

	/*
     * 账龄控制器
     */
	public function actionAge()
	{
		$vendors = Vendor::model()->findAll();
		foreach ($vendors as $vendor) {
			//检查应付、预付、其他应付
			$sbjs = Subjects::model()->findAllByAttributes(['sbj_name' => $vendor->company, 'has_sub' => 0], 'sbj_number regexp "^1123" or sbj_number regexp "^2202" or sbj_number regexp "^2241"');
			if (count($sbjs) > 0) {   //最多应该只有3个科目
				$where = '';
				foreach ($sbjs as $sbj) {
					$where .= $where == '' ? "(entry_subject='$sbj->sbj_number'" : " or entry_subject='$sbj->sbj_number'";
				}
				$where .= ')';
				$orderby = ' order by entry_date';
				//借方
				$credits = Transition::model()->findAllByAttributes([], $where . ' and ((entry_transaction = 1 and entry_amount > 0) or (entry_transaction = 2 and entry_amount < 0))' . $orderby);
				//贷方
				$debits = Transition::model()->findAllByAttributes([], $where . ' and ((entry_transaction = 2 and entry_amount > 0) or (entry_transaction = 1 and entry_amount < 0))' . $orderby);
				$debit_amount = 0;
				foreach ($debits as $debit) {
					$debit_amount += abs($debit->entry_amount);
				}
				$credit_amount = 0;
				foreach ($credits as $credit) {
					$credit_amount += abs($credit->entry_amount);
				}
//                $balance = $debit_amount - $credit_amount;
				if ($debit_amount > $credit_amount) {   //借方大于0，公司需要值钱给供应商
					foreach ($debits as $debit) {
						if ($credit_amount < $debit->entry_amount) {    //有钱未付清，把时间算出
							$vendor->ageZone[$vendor::getZone($debit->entry_date)] += $credit_amount <= 0 ? $debit->entry_amount : ($debit->entry_amount - $credit_amount);
							$vendor->ageZone['全部'] += $credit_amount <= 0 ? $debit->entry_amount : ($debit->entry_amount - $credit_amount);
						}
						$credit_amount -= $debit->entry_amount;
					}
				}

			}
		}
		$this->render('age', array(
			'dataProvider' => $vendors,
		));
	}
}
