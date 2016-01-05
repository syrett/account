<?php

class ProjectBController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ProjectB;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProjectB'])) {
            $model->attributes = $_POST['ProjectB'];
            if ($model->save()) {
                //创建成功，需要生成，在建工程1604子科目
                Subjects::matchSubject($model->name, '1604');
                Yii::app()->user->setFlash('success', "添加成功!");
                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //ID是stock的id，不是项目ID；需要根据subject，获取科目，再获取项目id
        $stock = Stock::model()->findByPk($id);
        if($stock){
            $subject = Subjects::model()->findByAttributes(['sbj_number'=>$stock->entry_subject]);
            $projectB = ProjectB::model()->findByAttributes(['name'=>$subject->sbj_name]);
            if($projectB){
                $id = $projectB->id;
            }else{
                throw new CHttpException(400, "长期待摊科目名称已经手动修改，无法找到对应项目名称");
            }
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProjectB'])) {
            $model->attributes = $_POST['ProjectB'];
            $model->save();
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        //不管科目表，是否有二级科目，都不删除
        //检查stock里面，是否有相关科目的物品，有就不能删
        $model = $this->loadModel($id);
        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $model->name], 'sbj_number like "1604%"');
        if ($sbj)
            $stock = Stock::model()->findByAttributes([], "entry_subject like '$sbj->sbj_number%'");
        if (!$stock)
            $model->delete();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->redirect(['admin']);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new ProjectB('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProjectB']))
            $model->attributes = $_GET['ProjectB'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProjectB the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ProjectB::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProjectB $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'project-b-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * 在建工程完工，转固定资产
     */
    public function actionTransform($id, $action, $did, $sbj, $name, $type)
    {
        $sbj = substr($sbj,1);
        $model = $this->loadModel($id);
        $osbj = Subjects::model()->findByAttributes(['sbj_name' => $model->name], 'sbj_number like "1604%"');
        if ($osbj !== null)
            $stocks = Stock::model()->findAllByAttributes(['entry_subject' => $osbj->sbj_number]);
        $amount = 0;
        if ($stocks != null) {
            foreach ($stocks as $item) {
                $amount += $item->getWorth();
            }
        }
        //新固定资产
        $stock = new Stock();
        $stock->hs_no = $stock->initHSno('1601');
        $stock->order_no = 'BU'.substr(Transition::model()->getCondomDate(),0,6). addZero($model->id);
        $stock->name = $name;
        $stock->model = $type;
        $stock->entry_subject = $sbj;
        $stock->department_id = $did;
        $stock->in_date = date('Ymd', strtotime('+1 month',strtotime(Transition::model()->getCondomDate())));
        $stock->in_price = $amount;
        $option = Options::model()->findByAttributes(['entry_subject'=>$sbj]);
        if($option!=null){
            $stock->value_month = $option->year*12; //折旧年限
            $stock->value_rate = $option->value;    //残值率
        }
        $stock->date_a = $stock->in_date;

        //生成转固产生的凭证
        $prefix = substr($stock->in_date,0,6);
        $tran1 = new Transition();
        $tran2 = new Transition();
        $tran1->entry_transaction = 1;
        $tran2->entry_transaction = 2;
        $data = [
            'data_type' => 'building',
            'data_id' => $id,
            'entry_num_prefix' => $prefix,
            'entry_memo' => '在建工程转固_'. $model->name,
            'entry_date' => convertDate($prefix.'01', 'Y-m-d 00:00:00'),
            'entry_num' => Transition::model()->tranSuffix($prefix),
            'entry_creater' => Yii::app()->user->id,
            'entry_editor' => Yii::app()->user->id,
            'entry_amount' => $amount,
        ];
        $tran1->attributes = $data;
        $tran2->attributes = $data;
        $tran1->entry_subject = $sbj;
        $tran2->entry_subject = $osbj->sbj_number;

        $model->status = $action=='active'?2:1;
        $stock->save();
        $model->save();
        $tran1->save();
        $tran2->save();

    }
}
