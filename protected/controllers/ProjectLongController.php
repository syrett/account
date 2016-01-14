<?php

class ProjectLongController extends Controller
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

    public function accessRules()
    {
        $rules = parent::accessRules();
        if ($rules[0]['actions'] == ['manage'])
            $rules[0]['actions'] = [];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], []);
        return $rules;
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
        $model = new ProjectLong;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProjectLong'])) {
            $model->attributes = $_POST['ProjectLong'];
            if ($model->save()) {
                //创建成功，需要生成，长期待摊1801子科目
                Subjects::matchSubject($model->name, '1801');
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
            $projectL = ProjectLong::model()->findByAttributes(['name'=>$subject->sbj_name]);
            if($projectL){
                $id = $projectL->id;
            }else{
                throw new CHttpException(400, "长期待摊科目名称已经手动修改，无法找到对应项目名称");
            }
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProjectLong'])) {
            $model->attributes = $_POST['ProjectLong'];
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
        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $model->name], 'sbj_number like "1801%"');
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
        $model = new ProjectLong('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProjectLong']))
            $model->attributes = $_GET['ProjectLong'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProjectLong the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ProjectLong::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProjectLong $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'project-long-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * 设置 长期待摊的 起始摊销日期，这2个科目，不以交易日期为准，以项目为准
     */
    public function actionActive($id, $action)
    {
        //$id是stock的id,需要找到project id
        $stock_temp = Stock::model()->findByPk($id);
        $model = ProjectLong::model()->findByAttributes(['name'=>Subjects::getName($stock_temp->entry_subject)]);
        $stocks = null;
//        $model = $this->loadModel($id);
        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $model->name], 'sbj_number like "1801%"');
        if ($sbj !== null)
            $stocks = Stock::model()->findAllByAttributes(['entry_subject' => $sbj->sbj_number]);
        if ($stocks != null) {
            $date = Transition::getCondomDate();
            $date = date('Ymd', strtotime('+1 month', strtotime($date)));
            foreach ($stocks as $stock) {
                if ($action == "active") {
                    $stock->date_a = $date;
                    $stock->save();
//                    $result[] = ['status' => 'success', 'msg' => '设置摊销日期为' . convertDate($date, 'Y年m月')];

                } else {  //  取消摊销

                    if ($stock->getWorth() == $stock->in_price) {
                        $stock->date_a = '';
                        $stock->save();
//                        $result[] = ['status' => 'success', 'msg' => '取消摊销成功'];
                    }
//                        $result[] = ['status' => 'failed', 'msg' => '该项目已经开始摊销，无法取消'];

                }
            }
            $model->status = $action=='active'?2:1;
            $model->save();
        }

//        echo json_encode($result);
    }
}
