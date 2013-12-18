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
                'actions' => array('index', 'view', 'delete'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'getTranSuffix', 'Appendix', 'ListFirst', 'reorganise', 'ajaxListFirst',),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin',),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $items = $this->getItemsToUpdate();

        if (isset($_POST['Transition'])) {
            $valid = $this->saveTransitions($items);
            if ($valid) {
                $model = new Transition('search');
                $model->unsetAttributes(); // clear any default values
                $_GET['Transition'] = array('entry_num_prefix' => $_POST['entry_num_prefix'], 'entry_num' => intval($_POST['entry_num']));
                $model->attributes = $_GET['Transition'];

                $this->render('admin', array(
                    'model' => $model,
                ));
            } else
                $this->render('create', array(
                    'model' => $items,
                ));
        } // 显示视图收集表格输入
//              $this->redirect(array('view','id'=>$model->id));
        else {
            $model = array();
            for ($i = 0; $i < 5; $i++)
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
        $items = $this->getItemsToUpdate($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Transition'])) {
            $id = $this->saveTransitions($items);
            $this->redirect(Yii::app()->createAbsoluteUrl('transition/update&id='. $id));
        }
        $this->render('update', array(
            'model' => $items,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
        $items = $this->getItemsToUpdate($id);
        foreach($items as $item)
            $this->loadModel($item['id'])->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
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
     * return json {"type":1;"html":"<select....."}
     */
    public function appendix($subject, $number)
    {
        $html = "";
        $arr = array('type' => 0);
            switch ($subject) {
                case 1122 : // 应付账款，列出供应商
                    $arr['type'] = 1;
                    $data = Vendor::model()->findAll();
                    foreach ($data as $item) {
                        $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                    }
                    break;
                case 2202 : // 应收账款，列出客户列表
                    $arr['type'] = 2;
                    $data = Client::model()->findAll();
                    foreach ($data as $item) {
                        $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                    }
                    break;
                default :
                    $list = $this->getSubjectID(4);
                    if (in_array($subject, $list)) { //全部 4:收入 类科目  列出项目project
                        $arr['type'] = 3;
                        $data = Project::model()->findAll();
                        foreach ($data as $item) {
                            $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                        }
                        break;
                    }
                    $list = $this->getSubjectID(5);
                    if (in_array($subject, $list)) { //全部 5:费用 类科目   列出员工employee
                        $arr['type'] = 4;
                        $data = Employee::model()->findAll();
                        foreach ($data as $item) {
                            $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                        }
                        break;
                    }

            }

            if ($html != "")
                $arr += array('html' => '<select id="Transition_' . $number . '_entry_appendix_id" name="Transition[' . $number . '][entry_appendix_id]">' . $html . '</select>');
            else
                $arr += array('html' => '');
            return json_encode($arr);
    }

    /*
     *  return corresponding appendix
    */
    public function actionAppendix()
    {
        echo $this->appendix($_POST["subject"],$_POST["number"]);
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
            $arr += array($row['sbj_number'] => $row['sbj_number'] . $row['sbj_name']);
        };
        return $arr;
    }

    /*
     * ajax return 科目
     */
    public function actionAjaxListFirst()
    {
        $arr = $this->actionListFirst();
        $result = array();
        foreach($arr as $number=>$item){
            array_push($result, array($number,$item));
        }
        echo json_encode($result);
    }

    /*
     * get every row in the form
     * http://www.yiiframework.com/doc/guide/1.1/en/form.table
     */
    public function getItemsToUpdate($id = "")
    {
        $count = 0;
        $sum = 0;
        // Create an empty list of records
        $items = array();
        if (isset($_POST['Transition']) && is_array($_POST['Transition'])) {
            foreach ($_POST['Transition'] as $item) {
                if(isset($item['entry_memo']) && trim($item['entry_memo'])!="")
                {
                    $items[] = new Transition('create');
                    $sum++;
                }
            }
        }
        if ($id) {
            $data = Yii::app()->db->createCommand()
                ->select('entry_num_prefix, entry_num')
                ->from('transition as a')
                ->where('id="' . $id . '"')
                ->queryRow();
            // load models which is the same entry_num_prefix+entry_num
            $data = Yii::app()->db->createCommand()
                ->select('id')
                ->from('transition as a')
                ->where('entry_num_prefix="' . $data['entry_num_prefix'] . '" and entry_num="' . $data['entry_num'] . '"')
                ->queryAll();
            foreach ($data as $key=>$item) {
                $items[$key] = $this->loadModel($item['id']);
                $count++;
            }

        }
        return $items;
    }

    /*
     * save transition
     */
    public function saveTransitions($items)
    {
        $valid = true;
        $old = array(0=>"");
        foreach ($items as $i => $item) {
            if (isset($_POST['Transition'][$i])) {
                $_POST['Transition'][$i]['entry_reviewer'] = intval($_POST['entry_reviewer']);
                $_POST['Transition'][$i]['entry_num'] = intval($_POST['entry_num']);
                $_POST['Transition'][$i]['entry_editor'] = intval($_POST['entry_editor']);
                $_POST['Transition'][$i]['entry_num_prefix'] = $_POST['entry_num_prefix'];
                $_POST['Transition'][$i]['entry_date'] = intval($_POST['entry_date']);
//                $_POST['Transition'][$i]['entry_transaction'] = intval($_POST['Transition'][$i]['entry_transaction']);
                $_POST['Transition'][$i]['entry_subject'] = intval($_POST['Transition'][$i]['entry_subject']);
                $entry_appendix_id = isset($_POST['Transition'][$i]['entry_appendix_id']) ? $_POST['Transition'][$i]['entry_appendix_id'] : 0;
                $_POST['Transition'][$i]['entry_appendix_id'] = intval($entry_appendix_id);
                $_POST['Transition'][$i]['entry_amount'] = intval($_POST['Transition'][$i]['entry_amount']);
                $item->attributes = $_POST['Transition'][$i];
                if(isset($_POST['Transition'][$i]['id']))
                    array_push($old , $_POST['Transition'][$i]['id']);
                $valid = $valid && $item->validate();
            }
        }
        foreach($items as $i => $item){ //在页面提交的ID列表中没有数据库中的ID， 则删除此凭证下的ID
            if(in_array($item->id, $old))
            {
                if ($valid) // all items are valid
                    if (isset($_POST['Transition'][$i]) && trim($_POST['Transition'][$i]['entry_memo']) != "")
                        $item->save();
                $valid = $item->id;
            }
            else
                $item->delete();
        }
        return $valid;

    }

    /*
     * 判断凭证属于的那个科目，并根据ID返回公司名字或员工名字
     * 当应收账款被选择时，显示客户列表，必须选择一个客户；     1:  1122 => client
     * 当应付账款被选择时，显示供应商列表，必须选择一个供应商；  2:   2202 => vendor
     * 当费用类科目被选择时，显示员工列表，必须选择一个员工；    3:    第5类 => employee
     * 当收入类科目被选择时，显示项目列表必须选择一个项目。      4:    第4类 => project
     * $param   sbj_number  科目表编号
     * $param   id          ID
     * return @table name
     */
    public function subGetName($entry_appendix_type, $id)
    {
        $result = "";
        if ($entry_appendix_type && $id) {
            switch ($entry_appendix_type) {
                case 1 : // 应付账款，列出供应商
                    $ob = Client::model()->findByPk($id);
                    $result = $ob['company'];
                    break;
                case 2 : // 应收账款，列出客户列表
                    $ob = Transition::model()->findByPk($id);
                    $result = $ob['company'];
                    break;
                case 3 :
                    $ob = Project::model()->findByPk($id);
                    $result = $ob['name'];
                    break;
                case 4 :
                    $list = $this->getSubjectID(5);
                    $ob = Employee::model()->findByPk($id);
                    $result = $ob['name'];
                    break;
                default :
                    break;
            }
        }
        return $result;
    }

    /*
     * 选择科目里，附加信息中对应表的数组
     * @param enty_appendix_type
     * @param entry_appendix_id
     */
    public function appendixList ($type){
        $arr = array();
        switch($type){
            case 1 :
                $data = Vendor::model()->findAll();
                foreach($data as $item){
                    $arr += array($item['id']=>$item['company']);
                }
                break;
            case 2 :
                $data = Client::model()->findAll();
                foreach($data as $item){
                    $arr += array($item['id']=>$item['company']);
                }
                break;
            case 3 :
                $data = Project::model()->findAll();
                foreach($data as $item){
                    $arr += array($item['id']=>$item['name']);
                }
                break;
            case 4 :
                $data = Employee::model()->findAll();
                foreach($data as $item){
                    $arr += array($item['id']=>$item['name']);
                }
                break;
            default :
                break;
        }
        return $arr;
    }
}
