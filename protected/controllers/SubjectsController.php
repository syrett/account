<?php

class SubjectsController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/main', meaning
     * using one-column layout. See 'protected/views/layouts/main.php'.
     */
    public $layout = '//layouts/main';

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
            $rules[0]['actions'] = ['admin', 'update', 'delete', 'view', 'create'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['getuserfor','createsubject', 'AjaxGetSubjects', 'matchSubject', 'AjaxCreateBankSub']);
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Subjects the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Subjects::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Subjects;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Subjects'])) {
            $old_sbj_number = $_POST['Subjects']['sbj_number'];
//            $sbj_type = $_POST['sbj_type'];
            $sbj_type = 2;
            $new_sbj = Subjects::model()->init_new_sbj_number($old_sbj_number, $sbj_type);
            $pmodel = Subjects::model()->findByAttributes(['sbj_number' => $old_sbj_number]);

            $_POST['Subjects']['sbj_number'] = $new_sbj[0];
            $_POST['Subjects']['sbj_cat'] = $pmodel->sbj_cat;
            $_POST['Subjects']['start_balance'] = $pmodel->start_balance;
            $model->attributes = $_POST['Subjects'];
            if ($model->save()) {
                $pmodel->start_balance = 0;
                $pmodel->save();
                //如果是新的子科目，将post中科目表id修改为新id
//                $sbj_id = trim($_POST['Subjects']['sbj_number']);
                $sbj_id = $new_sbj[0];
                if (strlen($sbj_id) > 4 && $sbj_type == 2)  ////1为同级科目，2为子科目
                {
                    Post::model()->tranPost($sbj_id);
                    Transition::model()->updateSubject($old_sbj_number, $sbj_id);
                    Subjects::model()->hasSub($sbj_id);
                }
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Subjects'])) {
            $model->attributes = $_POST['Subjects'];

            $model->save();

            Yii::app()->user->setFlash('success', "操作成功!");
            $this->render('update', array(
                'model' => $model,
            ));

        } else {

            $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id, $sbj_number = '')
    {
        if ($id != '')
            $sbj = $this->loadModel($id);
        else
            $sbj = Subjects::model()->findByAttributes(['sbj_number' => $sbj_number]);
        //一级科目不能删除
        if (!$sbj) {
            echo "科目已经删除";
            return true;
        } elseif (strlen($sbj->sbj_number) <= 4) {
            echo "一级科目无法删除";
            return true;
        }
        //有子科目，无法删除
        if ($sbj->has_sub == 1)
            echo "有子科目不能删除！";
        else {//有凭证
            if (Subjects::model()->hasTransition($sbj->sbj_number)) {
                //有兄弟科目
                if (Subjects::model()->hasBrother($sbj->sbj_number)) {
                    echo "此科目不能删除！";
                    //不能删
                } else {
                    $trans = Transition::model()->findByAttributes(['entry_subject' => $sbj->sbj_number]);
                    if ($trans) {
                        echo "该科目下有凭证，无法删除";
                        return true;
                    }
                    Bank::model()->updateSubject($sbj->sbj_number);
                    Post::model()->updateSubject($sbj->sbj_number);
                    Transition::model()->updateSubject($sbj->sbj_number, substr($sbj->sbj_number, 0, -2));
                    Subjects::model()->noSub($sbj->sbj_number);
                    Subjects::model()->tranBalance($sbj->sbj_number);
                    $sbj->delete();
                    echo "删除成功！";
                }
            } else {  //无凭证
                try {
                    Bank::model()->updateSubject($sbj->sbj_number);
                    //有兄弟科目，可直接删除
                    if (Subjects::model()->hasBrother($sbj->sbj_number))
                        $sbj->delete();
                    else {   //无兄弟科目
                        Post::model()->updateSubject($sbj->sbj_number);
                        //设置父科目 无子科目
                        Subjects::model()->noSub($sbj->sbj_number);
                        Subjects::model()->tranBalance($sbj->sbj_number);
                        $sbj->delete();
                    }
                    echo "删除成功！";
                } catch (CDbException $e) {
                    echo "删除失败！";
                }
            }

        }


        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Subjects');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }


    //余额设置

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Subjects('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Subjects']))
            $model->attributes = $_GET['Subjects'];

        $dataProvider = $model->search();
        $dataProvider->pagination = array(
            'pageSize' => 30
        );
        $this->render('admin', array(
            'dataProvider' => $dataProvider,
            'model' => $model,
        ));
    }

    public function actionBalance()
    {
        $data = Subjects::model()->list_can_set_balnce_sbj();

        $err_msg = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //有一次过账，就不能改期初余额
            $post = Transition::model()->findByAttributes(['entry_posting' => 1]);
            if ($post) {
                Yii::app()->user->setFlash('error', "账套已经过账，无法修改期初余额!");
            } else {
                $p_data = array();
                foreach ($_POST as $k => $v) {
                    if (is_numeric($k) && is_numeric($v)) {
                        $p_data[$k] = $v;
                    }
                }
                $model = new Subjects();
                $str = $model->check_start_balance($p_data);
                if ($str=='') {
                    Subjects::model()->set_start_balance($p_data);
                    $this->redirect("?r=subjects/balance");
                } else {
                    Yii::app()->user->setFlash('error', "资产与负债权益的和不等!<br >$str");
                }

            }

        }

        $this->render('balance', array(
            'data' => $data,
        ));
    }

    /**
     * Performs the AJAX validation.
     * @param Subjects $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'subjects-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * ajax 获取科目表
     */
    public function actionAjaxGetSubjects()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $import_type = isset($_REQUEST['import_type']) ? $_REQUEST['import_type'] : "";
            if ($import_type == "") {
                $sbj = Transition::model()->listSubjectsGrouped();
            } else {
                $sbj = Transition::model()->listSubjectsGrouped('all');
            }

            //json数据前台会自动按number重新转换顺序，目前无更好解决办法
            $arr = [];
            foreach ($sbj as $cat => $items) {
                $subjcts = [];
                foreach ($items as $key => $item) {
                    $subjcts['_' . $key] = $item;
                }
                $arr[$cat] = $subjcts;
            }
            echo json_encode($arr);
        } else
            throw new CHttpException(403, "无效的请求");
    }

    /*
     * ajax  创建银行科目
     *
     */
    public function actionAjaxCreateBankSub()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bank_name = isset($_REQUEST['bank_name']) ? trim($_REQUEST['bank_name']) : '';
            $arr = [];
            if ($bank_name != '') {
                $sbj = Subjects::model()->findByAttributes(['sbj_name' => $bank_name, 'sbj_cat'=>1]);
                if ($sbj === null) {
                    //
                    $subject_yinhang = 1002;
                    $sbj_type = 2;

                    $model = new Subjects;

                    $new_sbj = Subjects::model()->init_new_sbj_number($subject_yinhang, $sbj_type);
                    $pmodel = Subjects::model()->findByAttributes(['sbj_number' => $subject_yinhang]);

                    $val['sbj_number'] = $new_sbj[0];
                    $val['sbj_cat'] = $pmodel->sbj_cat;
                    $val['start_balance'] = $pmodel->start_balance;
                    $val['sbj_name'] = $bank_name;
                    $val['sbj_name_en'] = '';

                    $model->attributes = $val;
                    if ($model->save()) {
                        $pmodel->start_balance = 0;
                        $pmodel->save();
                        $sbj_id = $new_sbj[0];
                        if (strlen($sbj_id) > 4 && $sbj_type == 2) {
                            Post::model()->tranPost($sbj_id);
                            Transition::model()->updateSubject($subject_yinhang, $sbj_id);
                            Subjects::model()->hasSub($sbj_id);
                        }
                    }
                    $arr['is_succ'] = true;
                    $arr['sbj_name'] = $bank_name;
                    $arr['sbj_number'] = $new_sbj[0];

                } else {
                    //已经存在  不处理 前端js
                    $arr['is_succ'] = false;
                }

            } else {
                //空 不处理 前端js
                $arr['is_succ'] = false;
            }

            echo json_encode($arr);
        } else {
            throw new CHttpException(403, "无效的请求");
        }
    }

    /*
     * 新建科目
     */
    public function actionCreatesubject()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $name = $_POST['name'];
            $sbj = $_POST['subject'];
            $id = Subjects::model()->createSubject($name, $sbj);
            if ($id)
                echo $id;
            else
                echo 0;
        }
    }

    /*
     * 商品采购，获取采购用途
     */
    public function actionGetusefor()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $name = $_REQUEST['name'];
            //因为只涉及库存商品，所以只是1405下的子科目
            $stock = Stock::model()->findByAttributes(['name' => $name], "entry_subject like '1405%'");
            if ($stock) {
                $arr = [1601, 1403, $stock->entry_subject, 6602, 6601, 6401, 1701];    //其他科目正常，库存商品1405只显示一条
            } else
                $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
            $subjectArray = Transition::getSubjectArray($arr);
            $subjectArray += ProjectB::model()->getProject();
            $subjectArray += ProjectLong::model()->getProject();
//                $subjectArray['_'. $stock->entry_subject] = Subjects::getSbjPath($stock->entry_subject);
            $result = json_encode($subjectArray);
            echo $result;

        } else
            throw new CHttpException(403, "无效的请求");
    }

    /*
     * 匹配subject
     */
    public function actionMatchsubject()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $sbj = Subjects::matchSubject($_POST['name'], [$_POST['subject']]);
            echo $sbj;
        } else
            throw new CHttpException(403, "无效的请求");
    }
}
