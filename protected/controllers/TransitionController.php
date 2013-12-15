<?php

class TransitionController extends Controller
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
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'getTranSuffix', 'Appendix', 'ListFirst', 'reorganise', 'ajaxListFirst'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
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

    /*
     * get every row in the form
     * http://www.yiiframework.com/doc/guide/1.1/en/form.table
     */
    public function getItemsToUpdate($id="")
    {
        // Create an empty list of records
        $items = array();

        if($id)
        {$data = Yii::app()->db->createCommand()
            ->select('entry_num_prefix, entry_num')
            ->from('transition as a')
            ->where('id="' . $id . '"')
            ->queryRow();
        // load models which is the same entry_num_prefix+entry_num
        $data = Yii::app()->db->createCommand()
            ->select('id')
            ->from('transition as a')
            ->where('entry_num_prefix="'. $data['entry_num_prefix']. '" and entry_num="'. $data['entry_num']. '"')
            ->queryAll();
            foreach($data as $item){
                $items[] =  $this->loadModel($id);
            }
        }
        // Iterate over each item from the submitted form
        elseif (isset($_POST['Transition']) && is_array($_POST['Transition'])) {
            foreach ($_POST['Transition'] as $item) {
                // If item id is available, read the record from database
//                if ( array_key_exists('id', $item) ){
//                    $items[] = Transition::model()->findByPk($item['id']);
//                }
                // Otherwise create a new record
//                else {
                $items[] = new Transition();
//                }
            }
        }
        return $items;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $items = $this->getItemsToUpdate();

        if (isset($_POST['Transition'])) {
            $valid = true;
            foreach ($items as $i => $item) {
                if (isset($_POST['Transition'][$i])) {
                    $_POST['Transition'][$i]['entry_reviewer'] = intval($_POST['entry_reviewer']);
                    $_POST['Transition'][$i]['entry_num'] = intval($_POST['entry_num']);
                    $_POST['Transition'][$i]['entry_editor'] = intval($_POST['entry_editor']);
                    $_POST['Transition'][$i]['entry_num_prefix'] = $_POST['entry_num_prefix'];
                    $_POST['Transition'][$i]['entry_date'] = intval($_POST['entry_date']);
                    $_POST['Transition'][$i]['entry_transaction'] = intval($_POST['Transition'][$i]['entry_transaction']);
                    $_POST['Transition'][$i]['entry_subject'] = intval($_POST['Transition'][$i]['entry_subject']);
                    $entry_appendix_id = isset($_POST['Transition'][$i]['entry_appendix_id'])?$_POST['Transition'][$i]['entry_appendix_id']:0;
                    $_POST['Transition'][$i]['entry_appendix_id'] = intval($entry_appendix_id);
                    $_POST['Transition'][$i]['entry_amount'] = intval($_POST['Transition'][$i]['entry_amount']);
                    $item->attributes = $_POST['Transition'][$i];
                    $valid = $valid && $item->validate();
                }
                if ($valid) // all items are valid
                    if (isset($_POST['Transition'][$i]) && trim($_POST['Transition'][$i]['entry_memo']) != "")
                        $item->save();
            }
            if ($valid){
//                $this->redirect("index.php?r=transition/admin&entry_num=9");
                $model = new Transition('search');
                $model->unsetAttributes(); // clear any default values
                $_GET['Transition'] = array('entry_num_prefix'=>$_POST['entry_num_prefix'],'entry_num'=>intval($_POST['entry_num']));
                $model->attributes = $_GET['Transition'];

                $this->render('admin', array(
                    'model' => $model,
                ));
            }
            else
                $this->render('failed', array(
                    'model' => $items,
                ));
        } // 显示视图收集表格输入
//              $this->redirect(array('view','id'=>$model->id));
        else
        {
            $model = array();
            $model[] = new Transition;
            $this->render('create', array(
                'model' => $model,
        ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
//        $model = $this->loadModel($id);
        $model = $this->getItemsToUpdate($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Transition'])) {
            $model->attributes = $_POST['Transition'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Transition');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Transition('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Transition']))
            $model->attributes = $_GET['Transition'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionReorganise()
    {
        if (!isset($_POST['entry_num_prefix'])) {
            $prefix = date('Y') . date('m');
        };
        $del_condition = 'entry_num_prefix=:prefix and entry_deleted=:bool';
        Transition::model()->deleteAll($del_condition, array(':prefix' => $prefix, ':bool' => 1));

        $sql = "select id from transition where entry_num_prefix=:prefix order by entry_num ASC"; //从小到大排序
        $data = Transition::model()->findAllBySql($sql, array(':prefix' => $prefix));

        $i = 1;
        $last = 0;
        foreach ($data as $row) {
          if ($i == 1)
            $last = $row['entry_num'];
          
            $pk = $row['id'];
            Transition::model()->updateByPk($pk, array('entry_num' => $i));
          
          if ($last == $row['entry_num'])
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
        $model = Transition::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Transition $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transition-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * return transition number entry_num
     */
    public function tranNumber($result = "")
    {
        if ($result == "")
            $result = date("Ym", time());
        $result .= $this->tranSuffix($result);
        return $result;
    }

    /*
     * return transition number entry_num suffix
     */
    public function tranSuffix($prefix = "")
    {
        if ($prefix == "")
            $prefix = date("Ym", time());
        $data = Yii::app()->db->createCommand()
            ->select('max(a.entry_num) b')
            ->from('transition as a')
            ->where('entry_num_prefix="' . $prefix . '"')
            ->queryRow();
        if ($data['b'] == '')
            $data['b'] = 0;
        $num = $data['b'] + 1;
        $num = $this->AddZero($num); //数字补0
        return $num;
    }

    /*
     * ajax return transition number entry_num suffix
     */
    public function actionGetTranSuffix()
    {
        if (Yii::app()->request->isPostRequest) {
            if (!isset($_POST['entry_prefix']) || $_POST['entry_prefix'] == "")
                $prefix = date("Ym", time());
            else
                $prefix = $_POST['entry_prefix'];
            echo $this->tranSuffix($prefix);
        } else
            echo 0;
    }

    /*
     *  getVendorlist
     */
    public function getUserlist()
    {
        $data = User::model()->findAll();
        return $data;
    }

    /*
     *  getVendorlist
     */
    public function getVendorlist()
    {
        $data = Vendor::model()->findAll();
        return $data;
    }

    /*
     *  getClientlist
     */
    public function getClientlist()
    {
        $data = Client::model()->findAll();
        return $data;
    }

    /*
     *  getSubjectID get id list by group
     *  1：资产 2：负债 3：权益 4：收入 5：费用
     */
    public function getSubjectID($group)
    {
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from('subjects as a')
            ->where('sbj_cat = ' . $group)
            ->queryAll();
        $arr = array();
        foreach ($data as $item) {
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
        $number = $_POST["number"];
        $html = "";
        if (Yii::app()->request->isPostRequest) {
            switch ($subject) {
                case 1122 : // 应付账款，列出供应商
                    $data = $this->getVendorlist();
                    foreach ($data as $item) {
                        $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                    }
                    break;
                case 2202 : // 应收账款，列出客户列表
                    $data = $this->getClientlist();
                    foreach ($data as $item) {
                        $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                    }
                    break;
                default :
                    $list = $this->getSubjectID(4);
                    if (in_array($subject, $list)) { //全部 4:收入 类科目  列出项目project
                        $data = Project::model()->findAll();
                        foreach ($data as $item) {
                            $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                        }
                        break;
                    }
                    $list = $this->getSubjectID(5);
                    if (in_array($subject, $list)) { //全部 5:费用 类科目   列出员工employee
                        $data = Employee::model()->findAll();
                        foreach ($data as $item) {
                            $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                        }
                        break;
                    }

            }
            if ($html != "")
                echo '<select id="Transition_'. $number. '_entry_appendix_id" name="Transition['. $number. '][entry_appendix_id]">' . $html . '</select>';
            else
                echo '';
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * 列出一级科目
     * return array(array([sbj_number]=>[sbj_name]).....)
     */
    public function actionListFirst()
    {
        //todo
        $sql = "select * from subjects where sbj_number < 10000"; // 一级科目的为1001～9999
        $First = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($First as $row) {
            array_push($arr, array($row['sbj_number'], $row['sbj_number'] . $row['sbj_name']));
        };
        return $arr;
    }

    /*
     * ajax return 科目
     */
    public function actionAjaxListFirst()
    {
        echo json_encode($this->actionListFirst());
    }

}
