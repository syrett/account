<?php
class TransitionController extends Controller
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
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin',),
                'users' => array('@'),
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
//        Yii::app()->db->createCommand('set names "utf8";')->query();

        if (isset($_POST['Transition'])) {
//            $items = $this->getItemsToUpdate();
            $session = Yii::app()->session;

            $user_id = Yii::app()->user->id;
            $sessionKey = $user_id . '_is_sending';


            if (isset($session[$sessionKey])) {
                $first_submit_time = $session[$sessionKey];
                $current_time = time();
                if ($current_time - $first_submit_time < 10) {
                    $session[$sessionKey] = $current_time;
                    throw new CHttpException(400, "10秒内不能重复提交");
                } else {
                    unset($session[$sessionKey]);//超过限制时间，释放session";
                }
            }


            //第一次点击确认按钮时执行
            if (!isset($session[$sessionKey])) {
                $session[$sessionKey] = time();
            }
            $model = $this->saveTransitions();
            if ($model && $model[0]->validate()) {
                $model = new Transition('search');
                $model->unsetAttributes(); // clear any default values
                $_GET['Transition'] = array('entry_num_prefix' => $_POST['entry_num_prefix'], 'entry_num' => intval($_POST['entry_num']));
                $model->attributes = $_GET['Transition'];

//                $this->redirect($this->createUrl('transition/admin'));
//                $this->redirect($this->createUrl('site/sucess'));

                header('refresh:2;url=index.php');
                Yii::app()->user->setFlash('success', "添加成功!");
                $this->render('/site/success');
            } else {
                for ($i = 0; $i < 5; $i++)
                    $model[] = new Transition;
                $this->render('create', array(
                    'model' => $model,
                ));
            }
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
        if (isset($_POST['Transition'])) {
            $items = $this->saveTransitions();
            $this->redirect('index.php?r=transition/admin');
        } else {
            $items = $this->getItemsToUpdate($id);
        }
        if (empty($items)) {
            $this->render('badre');
        } else
            $this->render('update', array(
                'model' => $items,
            ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = $_REQUEST[0]['id'];
            $action = $_REQUEST[0]['action'];
            $items = $this->getItemsToUpdate($id);
            foreach ($items as $item) {
                if ($action == 0)
                    $item->entry_deleted = 1;
                else
                    $item->entry_deleted = 0;
                $item->save();
            }

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
        $this->redirect($this->createUrl('transition/admin'));
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

    /**
     * 采购交易.
     */
    public function actionPurchase()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $sheetData[] = Transition::getSheetData($item, 'purchase');
                }
            } elseif($_FILES['attachment']['name']==''){
                //保存按钮
                $arr = $this->saveAll('purchase');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'], 'purchase');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('purchase'));
                }
            }
        }

        if (empty($sheetData)){
            $sheetData[] = Transition::getSheetData([], 'purchase');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'purchase', 'sheetData' => $sheetData, 'info' => $info]);
    }

    /**
     * 产品销售.
     */
    public function actionSale()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $sheetData[] = Transition::getSheetData($item, 'product');
                }
            } elseif($_FILES['attachment']['name']==''){
                //保存按钮
                $arr = $this->saveAll('product');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'], 'product');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('product'));
                }
            }
        }

        if (empty($sheetData)){
            $sheetData[] = Transition::getSheetData([], 'product');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'product', 'sheetData' => $sheetData, 'info' => $info]);
    }

    /**
     * 员工工资
     */
    public function actionSalary()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $employee = Employee::model()->findByAttributes(['name'=>$item['B']]);
                    if($employee)
                    $sheetData[] = Transition::getSheetData($item, 'salary');
                }
            }
            elseif(isset($_POST['type']) && $_POST['type'] =='load') {    //加载上月工资
                $employees = Employee::model()->findAll('status=1');
                foreach($employees as $item){
                    $cri = new CDbCriteria(['order'=>'entry_date desc']);
                    $salary = Salary::model()->findByAttributes(['employee_id'=>$item->id], $cri);
                    $sheetData[] = Transition::getSheetData($salary?$salary->attributes:['employee_id'=>$item->id], 'salary');
                }
            }elseif($_FILES['attachment']['name']==''){
                //保存工资数据，生成并保存凭证
                $arr = $this->saveAll('salary');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'], 'salary');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('salary'));
                }
            }
        }

        if (empty($sheetData)){
//            $objPHPExcel = PHPExcel_IOFactory::load(Yii::app()->basePath.'\..\download\test2.xlsx');
//            $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            //去除第一行
//            array_shift($list);
//            foreach($list as $item){
//                $sheetData[] = Transition::getSheetData($item, 'salary');
//            }
            $sheetData[] = Transition::getSheetData([], 'salary');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'salary', 'sheetData' => $sheetData, 'info' => $info]);
    }

    /**
     * 员工报销
     */
    public function actionReimburse()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $employee = Employee::model()->findByAttributes(['name'=>$item['A']]);
                    if($employee)
                    $sheetData[] = Transition::getSheetData($item, 'reimburse');
                }
            } elseif($_FILES['attachment']['name']==''){
                //保存按钮
                $arr = $this->saveAll('reimburse');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'], 'reimburse');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('reimburse'));
                }
            }
        }

        if (empty($sheetData)){
            $objPHPExcel = PHPExcel_IOFactory::load(Yii::app()->basePath.'\..\download\test.xlsx');
            $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            //去除第一行
            array_shift($list);
            foreach($list as $item){
                $sheetData[] = Transition::getSheetData($item, 'reimburse');
            }
//            $sheetData[] = Transition::getSheetData([], 'reimburse');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'reimburse', 'sheetData' => $sheetData, 'info' => $info]);
    }

    /**
     * 银行.
     */
    public function actionBank()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $sheetData[] = Transition::getSheetData($item,'bank');
                }
            } elseif($_FILES['attachment']['name']==''){
                //保存按钮
                $arr = $this->saveAll('bank');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'],'bank');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('bank'));
                }
            }
        }

        if (empty($sheetData)){
            $sheetData[] = Transition::getSheetData([],'bank');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'bank', 'sheetData' => $sheetData, 'info' => $info]);
    }

    /**
     * 现金.
     */
    public function actionCash()
    {
        $info = [];
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment']!='' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach($list as $item){
                    $sheetData[] = Transition::getSheetData($item,'cash');
                }
            } elseif($_FILES['attachment']['name']==''){
                //保存按钮,
                $arr = $this->saveAll('cash');
                if (!empty($arr))
                    foreach ($arr as $item) {
                        $data = Transition::getSheetData($item['data'],'cash');
                        if ($item['status'] == 0) {
                            Yii::app()->user->setFlash('error', "保存失败!");
                            $sheetData[] = $data;
                        }
                        if ($item['status'] == 2) {
                            Yii::app()->user->setFlash('error', "数据保存成功，未生成凭证");
                            $sheetData[] = $data;
                        }
                    }
                else{
                    Yii::app()->user->setFlash('success', "保存成功!");
                    //跳转到历史数据管理页面
                    $this->redirect(Yii::app()->createUrl('cash'));

                }
            }
        }

        if (empty($sheetData)){
            $sheetData[] = Transition::getSheetData([],'cash');
        }

        $model[] = new Transition();
        return $this->render('head', ['type' => 'cash', 'sheetData' => $sheetData, 'info' => $info]);
    }

    public function actionReorganise($date)
    {
        //整理按月为结点
        Transition::model()->reorganise($date);
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
        $result = $this->tranPrefix() . $this->tranSuffix($result);
        return $result;
    }

    /*
     * return transition number entry_prefix
     */
    public function tranPrefix($result = "")
    {
        if ($result == "")
            return date("Ym", time());
        else
            return "";
    }

    /*
     * return transition number entry_num suffix
     */
    public function tranSuffix($prefix = "")
    {
        return Transition::model()->tranSuffix($prefix);
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
     *  getUserlist
     */
    public function getUserlist($condition = '', $params = array())
    {
        $data = User::model()->findAll($condition, $params);
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
        $subject = substr($subject, 0, 4);
        switch ($subject) {
            case 2202 : // 应付账款，列出供应商
                $arr['type'] = 1;
                $data = Vendor::model()->findAll();
                foreach ($data as $item) {
                    $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                }
                break;
            case 1122 :  // 应收账款，列出客户列表
                $arr['type'] = 2;
                $data = Client::model()->findAll();
                foreach ($data as $item) {
                    $html .= "<option value=" . $item['id'] . ">" . $item['company'] . "</options>";
                }
                break;
            case 6401 :     //主营业务成本
                $arr['type'] = 4;
                $data = Project::model()->findAll();
                foreach ($data as $item) {
                    $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                }
                break;

            case 6001 :     //主营业务收入
                $arr['type'] = 4;
                $data = Project::model()->findAll();
                foreach ($data as $item) {
                    $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                }
                break;
            default :
                //                $list = $this->getSubjectID(5);
                $list = array(6601, 6602);
                if (in_array($subject, $list) && $subject != 6401) { //全部 5:费用 类科目   列出员工employee

                    $arr['type'] = 3;

                    $data = Employee::model()->findAll();
                    foreach ($data as $item) {
                        $html .= "<option value=" . $item['id'] . ">" . $item['name'] . "</options>";
                    }
                    break;
                }
        }

        if ($html != "")
            $arr += array('html' => '<select class="v-appendix" id="Transition_' . $number . '_entry_appendix_id" name="Transition[' . $number . '][entry_appendix_id]">' . $html . '</select>');
        else
            $arr += array('html' => '');
        return json_encode($arr);
    }

    /*
     *  return corresponding appendix
    */
    public function actionAppendix()
    {
        if (!isset($_POST['subject']) || !isset($_POST['number']))
            echo '';
        else
            echo $this->appendix($_POST["subject"], $_POST["number"]);
    }


    /**
     * 列出一级科目
     * return array(array([sbj_number]=>[sbj_name]).....)
     */
    public function actionListFirst()
    {
        $sql = "select * from subjects where has_sub=0 order by concat(sbj_number) asc"; // 一级科目的为1001～9999
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
//        $arr = Subjects::model()->actionListFirst();
        $result = array();
        foreach ($arr as $number => $item) {
            array_push($result, array($number, $number . Subjects::getSbjPath($number)));
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
                if (isset($item['entry_memo']) && trim($item['entry_memo']) != "") {
                    $items[] = new Transition('create');
                    $sum++;
                }
            }
        }
        if ($id) {
            $sql = "select entry_num_prefix, entry_num from transition as a where id=:id";
            $data = Yii::app()->db->createCommand($sql)
                ->bindValue(":id", $id)
                ->queryRow();
            // load models which is the same entry_num_prefix+entry_num
            $data = Yii::app()->db->createCommand()
                ->select('id')
                ->from('transition as a')
                ->where('entry_num_prefix="' . $data['entry_num_prefix'] . '" and entry_num="' . $data['entry_num'] . '"')
                ->order('entry_transaction')
                ->queryAll();
            foreach ($data as $key => $item) {
                $items[$key] = $this->loadModel($item['id']);
                $count++;
            }
        }
        return $items;
    }

    /*
     * save transition
     */
    public function saveTransitions()
    {
        $valid = true;
        $prefix = '';
        $old = array();
        $new = array();
        $items = array();
        if (isset($_REQUEST['id'])) {
            $data = $this->getItems($_REQUEST['id']);
            foreach ($data as $i) {
                array_push($old, $i['id']);
            }
        }

        if (isset($_REQUEST['entry_num_prefix']) && $_REQUEST['entry_num_prefix_this'] != $_REQUEST['entry_num_prefix']) {
            $prefix = $_REQUEST['entry_num_prefix'];
            $_POST['entry_num'] = $this->tranSuffix($prefix);
        }
//        Yii::app()->db->createCommand('set names "utf8"')->execute();
        foreach ($_POST['Transition'] as $Tran) {
            if (isset($Tran)) {
                $Tran['entry_num'] = intval($_POST['entry_num']);
                $Tran['entry_creater'] = intval($_POST['entry_creater']);
                $Tran['entry_editor'] = intval($_POST['entry_editor']);
                $Tran['entry_num_prefix'] = $_POST['entry_num_prefix'];
                $Tran['entry_date'] = date('Y-m-d H:i:s', strtotime($_POST['entry_date']));
                $Tran['entry_subject'] = intval($Tran['entry_subject']);
                $entry_appendix_id = isset($Tran['entry_appendix_id']) ? $Tran['entry_appendix_id'] : 0;
                $Tran['entry_reviewer'] = isset($Tran['entry_reviewer']) ? $Tran['entry_reviewer'] : 1;
                $Tran['entry_appendix_id'] = intval($entry_appendix_id);
                $Tran['entry_amount'] = floatval($Tran['entry_amount']);
                if (isset($Tran['id']) && $Tran['id'] != "") {
                    $item = $this->loadModel($Tran['id']);
                    $item->attributes = $Tran;
                    if ($item->validate())
                        $item->save();
                    $items[] = $item;
                    array_push($new, $Tran['id']);
                } elseif ($Tran['entry_memo'] != "") {
//                    $Tran['entry_memo'] = utf8_encode($Tran['entry_memo']);
                    $item = new Transition('create');
                    $item->attributes = $Tran;
                    if ($item->validate())
                        $item->save();
                    $items[] = $item;
                    $valid = $item->id;
                }
            }
        }
        foreach ($old as $i) {
            if (!in_array($i, $new)) {
                $item = $this->loadModel($i);
                $item->delete();
            }
        }
        return $items;
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
                    $ob = Vendor::model()->findByPk($id);
                    $result = $ob['company'];
                    break;
                case 2 : // 应收账款，列出客户列表
                    $ob = Client::model()->findByPk($id);
                    $result = $ob['company'];
                    break;
                case 3 :
                    $list = $this->getSubjectID(5);
                    $ob = Employee::model()->findByPk($id);
                    $result = $ob['name'];
                    break;
                case 4 :
                    $ob = Project::model()->findByPk($id);
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
    public function appendixList($type)
    {
        $arr = array();
        switch ($type) {
            case 1 :
                $data = Vendor::model()->findAll();
                foreach ($data as $item) {
                    $arr += array($item['id'] => $item['company']);
                }
                break;
            case 2 :
                $data = Client::model()->findAll();
                foreach ($data as $item) {
                    $arr += array($item['id'] => $item['company']);
                }
                break;
            case 3 :
                $data = Employee::model()->findAll();
                foreach ($data as $item) {
                    $arr += array($item['id'] => $item['name']);
                }
                break;
            case 4 :
                $data = Project::model()->findAll();
                foreach ($data as $item) {
                    $arr += array($item['id'] => $item['name']);
                }
                break;
            default :
                break;
        }
        return $arr;
    }

    /*
     * 审核
     * @param entry_id
     */
    public function actionReview()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = $_REQUEST[0]['id'];
            $list = $this->getItems($id);
            $valid = true;
            foreach ($list as $item) {
                $item = $this->loadModel($item['id']);
                if ($valid = $item->validate() && $valid) {
                    if ($_REQUEST[0]['action'] == 1) {
                        $item->unReviewed();
                    } else {
                        $item->setReviewed();
                    }
                } else {
                } //当前登陆用户id
                $items[] = $item;
            }

            $this->render('update', array(
                'model' => $items,
            ));
//                $this->redirect(array('update','id'=>$id));
//                $this->redirect($this->createUrl('transition/update'), array('admin'));
        }

    }

    /*
     * 批量审核
     */
    public function actionSetReviewedAll(){
        if (Yii::app()->request->isPostRequest)
        {
            $result = true;
            //凭证编号 ：2015050001
            foreach($_POST['selectall'] as $item){
                $criteria= new CDbCriteria;
                $entry_num_prefix = substr($item,0,6);
                $entry_num = (int)substr($item,6);
                $criteria->addCondition('entry_num_prefix= :entry_num_prefix');
                $criteria->addCondition('entry_num = :entry_num');
                $criteria->params['entry_num_prefix'] = $entry_num_prefix;
                $criteria->params['entry_num'] = $entry_num;
                $trans = Transition::model()->findAll($criteria);
                if(!empty($trans)){
                    foreach($trans as $item){
                        $result = $item->setReviewed()?$result:false;
                    }
                }
            }
            if(isset(Yii::app()->request->isAjaxRequest)) {
                if($result)
                    echo CJSON::encode(array('success' => true));
                else
                    echo CJSON::encode(array('success' => false));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'不合法的请求，请稍后重试');
    }

    /*
     * 批量取消审核
     */
    public function actionUnReviewedAll(){
        if (Yii::app()->request->isPostRequest)
        {
            //凭证编号 ：2015050001
            foreach($_POST['selectall'] as $item){
                $criteria= new CDbCriteria;
                $entry_num_prefix = substr($item,0,6);
                $entry_num = (int)substr($item,6);
                $criteria->addCondition('entry_num_prefix= :entry_num_prefix');
                $criteria->addCondition('entry_num = :entry_num');
                $criteria->params['entry_num_prefix'] = $entry_num_prefix;
                $criteria->params['entry_num'] = $entry_num;
                $trans = Transition::model()->findAll($criteria);
                if(!empty($trans)){
                    foreach($trans as $item){
                        $item->unReviewed();
                    }
                }
            }
            if(isset(Yii::app()->request->isAjaxRequest)) {
                echo CJSON::encode(array('success' => true));
            } else
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400,'不合法的请求，请稍后重试');
    }

    /*
     * 获取ID下 该凭证所有条目ID
     * $var $id
     * @return array()
     */
    public function getItems($id)
    {
        $data = Yii::app()->db->createCommand()
            ->select('entry_num_prefix, entry_num')
            ->from('transition as a')
            ->where('id="' . $id . '"')
            ->queryRow();
        // load models which is same with entry_num_prefix+entry_num
        $data = Yii::app()->db->createCommand()
            ->select('id')
            ->from('transition as a')
            ->where('entry_num_prefix="' . $data['entry_num_prefix'] . '" and entry_num="' . $data['entry_num'] . '"')
            ->queryAll();
        return $data;
    }

    /*
     * Settlement凭证结账
     * 本模块是在当月的全部凭证已经被审核完结的基础上，计算并保存本期发生额和期末余额。
            程序流程：
            1)	检查当月是否有结转凭证，如果有结转凭证，当月帐套关闭，无法再录入当月凭证；如果没有结转凭证，继续结转操作步骤2。
            2)	结账时系统自动创建一张新的结转凭证，编号自动生成，第一条记录摘要为“结转凭证”，科目为“xx收入”，设置为“借”，金额为本期收入类科目贷方发生额合计；
                第二记录摘要为“结转凭证”，科目为“xx费用”，设置为“贷”，金额为本期费用类科目借方发生额合计。
                第三记录摘要为“结转凭证”，科目为“本年利润”，设置为“贷”，金额为第第一条记录与第二条记录的差额。此时“借”与“贷”记录中的金额值也应相等。
            3)	另一会计人员登录，对“结转凭证”审核、过账，设置凭证数据表中结转记录对应的“已过账”字段为True。结转凭证的Entry_Closing字段值为True。
            4)	完成

     */
    public function actionSettlement($entry_prefix)
    {
        if ($entry_prefix > Condom::model()->getStartTime()) {
            $lastdate = date('Ym', strtotime('-1 months', strtotime($entry_prefix . '01')));
            while ($lastdate > Condom::model()->getStartTime()) {
                if (Transition::model()->hasTransition($lastdate)) {
                    if (!Transition::model()->tranSettlement($lastdate))
                        throw new CHttpException(400, $lastdate . "需要先结账");
                    else
                        $lastdate = date('Ym', strtotime('-1 months', strtotime($lastdate . '01')));
                } else
                    $lastdate = date('Ym', strtotime('-1 months', strtotime($lastdate . '01')));
            }
        }

        if (!Transition::model()->checkSettlement($entry_prefix))
            throw new CHttpException(400, $entry_prefix . "结账失败");
        if(Transition::model()->isAllClosing($entry_prefix))
            throw new CHttpException(400, $entry_prefix . "已经结账");
        Transition::model()->settlement($entry_prefix);
        Stock::model()->saveWorth();    //过账时的计提折旧操作，在结账时保存净值
        Yii::app()->user->setFlash('success', $entry_prefix . "结账成功!");
        $this->render('/site/success');
    }

    /*
     * 返回未结账的年月
     */
    public function getEntry_prefix()
    {
        $entry_prefix = $this->tranPrefix();
        return $entry_prefix;
    }

    /*
     * 反结账
     */
    public function actionAntiSettlement($edate='')
    {
        $date= date('Ym', time());
//        $date = '201509';
        $result = false;
        while ($date >= Condom::model()->getStartTime() && $date >= $edate) {
            $result = $this->antiSettlement($date);
            $lastdate = $date;
            $date = date('Ym', strtotime('-1 months', strtotime($date . '01')));
        }

        if ($result) {
            Yii::app()->user->setFlash('success', $lastdate."反结账成功!");
            $this->render('/site/success');
        } elseif($date<Condom::model()->getStartTime())
            throw new CHttpException(400, "已经反结账至账套起始日期");
        else
            throw new CHttpException(400, $lastdate . " 反结账失败");
    }

    public function antiSettlement($date){

        $model = Transition::model()->deleteAllByAttributes(array('entry_num_prefix' => $date, 'entry_settlement' => 1,));
        Transition::model()->deleteAllByAttributes(['entry_num_prefix' => $date], 'entry_memo like "附加税-'.$date. '%"');
        $rows = Transition::model()->deleteAllByAttributes(['entry_num_prefix' => $date], 'entry_memo like "计提折旧-'.$date. '%"');
        if($rows > 0)
        {
            $cdb = new CDbCriteria();
            $cdb->addCondition('entry_subject like "1601%" or entry_subject like "1701%" or entry_subject like "1801%"');
            $stocks = Stock::model()->findAll($cdb);
            foreach($stocks as $item){
                $arr = explode(',', $item['worth']);
                array_pop($arr);
                $item->worth = implode(',', $arr);
                $item->save();
            }
        }
        $timeold =
        //删除post表中的数据
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 6);
        Post::model()->deleteAllByAttributes(array('year' => $year, 'month' => $month));
        $newModel = new  Transition();
        $newModel->entry_num_prefix = $date;
        $updated = $newModel->setPosted(0);
        $updated = $newModel->setClosing(0) || $updated;
        if ($model >= 1 or $updated)
            return true;
        else
            return false;
    }

    public function actionSuccess()
    {

        if ($message = Yii::app()->user->getFlash('success')) {
        } else {
            $this->redirect(array('quote'));
        }
    }

    /*
     * 按月为时间段
     */
    public function actionListReview()
    {

        $model = new Transition('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_REQUEST['date'])) {
            $criteria = array('entry_reviewed' => 0, 'entry_num_prefix' => $_REQUEST['date']);
        } else {
            $criteria = array('entry_reviewed' => 0);
        }
        $model->attributes = $criteria;
        $this->render('admin', array(
            'model' => $model, 'operation' => 'listReview'
        ));
    }

    public function actionListTransition()
    {
        $model = new Transition('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_REQUEST['date'])) {
            $criteria = array('entry_num_prefix' => $_REQUEST['date']);
            $model->attributes = $criteria;
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionListPost()
    {       //run post
        if (isset($_REQUEST['date'])) {
            Yii::import('application.controllers.PostController');
            $postctrl = new PostController();
            $postctrl->actionPost($_REQUEST['date']);
        }
    }

    public function actionListReorganise()
    {     //run Reorganise
        if (isset($_REQUEST['date'])) {
            $this->actionReorganise($_REQUEST['date']);
        }
    }

    public function actionListSettlement()
    {     //run settlement
        if (isset($_REQUEST['date'])) {
            $this->actionSettlement($_REQUEST['date']);
        }
    }

    public function actionListAntiSettlement()
    {     //run settlement
        if (isset($_REQUEST['date'])) {
            $this->actionAntiSettlement($_REQUEST['date']);
        }
    }

    public function actionListAssets()
    {
    //run settlement
        if (isset($_REQUEST['date'])) {
            $this->actionDepreciation($_REQUEST['date']);
        }
    }

    public function actionPrintP()
    {

        $this->render("printp");
    }

    public function actionPrint()
    {
        //设置php响应时间为30秒
        ini_set("max_execution_time", 300);
        set_time_limit(300);
        $year = $_REQUEST['year'];

        $fm = $_REQUEST['fm'];
        if ($fm < 10)
            $fm = $year . '0' . $fm;
        else
            $fm = $year . $fm;

        $tm = $_REQUEST['tm'];
        if ($tm < 10)
            $tm = $year . '0' . $tm;
        else
            $tm = $year . $tm;
        $tranList = $this->getAllTransitionList($fm, $tm);


        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1->setAutoFont(AUTOFONT_ALL);
        $mPDF1->SetDisplayMode('fullpage');
        # Load a stylesheet


        $cs = Yii::app()->clientScript;
        if ($_REQUEST['style'] == '2') {

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . Yii::app()->theme->baseUrl . '/assets/admin/layout/css/print_2.css');
            $cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/css/print_2.css');
        } else {
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . Yii::app()->theme->baseUrl . '/assets/admin/layout/css/print.css');
            $cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/css/print.css');
        }
        $mPDF1->WriteHTML($stylesheet, 1);
        foreach ($tranList as $id) {
            $items = $this->getItemsToUpdate($id);
            //$mPDF1->WriteHTML($this->renderPartial('print', array('model' => $items,),true,true));
            $page = 0;
            $pages = array();
            $mount = 0;
            foreach ($items as $key => $item) {
                if ($key % 5 == 0)
                    $page++;
                $pages[$page][] = $item;
                if ($item->entry_transaction == 1)
                    $mount += $item->entry_amount;
            }
            $count = count($pages);
            foreach ($pages as $page => $items) {
//                $this->renderPartial('print', array('model' => $items, 'count' => $count, 'page' => $page,),false,true);
                if ($_REQUEST['style'] == '2')
                    $mPDF1->WriteHTML($this->renderPartial('print_2', array('model' => $items, 'count' => $count, 'page' => $page, 'mount' => $mount
                    ), true, true));
//                    ),false,true));
                else
                    $mPDF1->WriteHTML($this->renderPartial('print_1', array('model' => $items, 'count' => $count, 'page' => $page, 'mount' => $mount
                    ), true, true));
//                    ),false,true));
            }
        }
        if ($_REQUEST['submit'] == '打印凭证')
            $mPDF1->Output('etc.pdf', EYiiPdf::OUTPUT_TO_BROWSER);
        elseif ($_REQUEST['submit'] == '下载凭证')
            $mPDF1->Output('etc.pdf', EYiiPdf::OUTPUT_TO_DOWNLOAD);
    }

    public function getAllTransitionList($fm, $tm)
    {

        $sql = "SELECT id FROM `transition` group by `entry_num_prefix`,`entry_num` having `entry_num_prefix`>=:fm and `entry_num_prefix`<=:tm";

//        $sql = "select * from subjects where has_sub=0 order by concat(sbj_number) asc"; // 一级科目的为1001～9999
        $list = Yii::app()->db
            ->createCommand($sql)->bindValues(array(':fm' => $fm, ':tm' => $tm))->queryAll();
//        $list = Subjects::model()->findAllBySql($sql);
        $arr = array();
        foreach ($list as $row) {
            $arr[] = $row['id'];
        }
        return $arr;
    }

    /*
     * 凭证上一条下一条
     * 0为上一条，1为下一条
     */
    public function getNextPrevious($type, $entry_num_prefix, $entry_num)
    {
        $sql = "select * from `transition` where `entry_num_prefix` = :entry_num_prefix ";
        if ($type == 0 && $entry_num > 1) {
            --$entry_num;
        } else {

            ++$entry_num;
        }
        $sql .= "and `entry_num`= :entry_num group by entry_num";
        $tran = Yii::app()->db
            ->createCommand($sql)->bindValues(array(':entry_num_prefix' => $entry_num_prefix, ':entry_num' => $entry_num))->queryRow();

//        $tran = Transition::model()->findBySql($sql);
        return $tran['id'];

    }

    /*
     * 还有更大或更小的，返回     1
     * 没有则返回          0
     */
    public function hasTransitionM($type, $entry_num_prefix, $entry_num)
    {
        if ($type == 0)
            $sql = "select * from transition where entry_num_prefix= :entry_num_prefix and entry_num<:entry_num";
        else
            $sql = "select * from transition where entry_num_prefix= :entry_num_prefix and entry_num>:entry_num";
        $list = Yii::app()->db
            ->createCommand($sql)->bindValues(array(':entry_num_prefix' => $entry_num_prefix, ':entry_num' => $entry_num))->queryAll();

//        $list = Transition::model()->db()->createCommand($sql)->bindParam(array(':entry_num_prefix'=>$entry_num_prefix,':entry_num'=>$entry_num))->findBySql($sql);
        if ($list == NULL) {
            return 0;
        } else
            return 1;
    }

    public function getTransition($id)
    {

    }

    public function actionCreateExcel()
    {
        Yii::import('ext.phpexcel.PHPExcel');
        $filename = '导出凭证';
        $where = '1=1';
        if (isset($_REQUEST['s_day']) && trim($_REQUEST['s_day']) != '') {
            $filename .= $_REQUEST['s_day'];
            $where .= " and entry_date>=:s_day";
        }
        if (isset($_REQUEST['e_day']) && trim($_REQUEST['e_day']) != '') {
            $filename .= ' to ' . $_REQUEST['e_day'];
            $where .= " and entry_date<=:e_day";
        }

        $sql = "select * from transition where " . $where;
        $command = Yii::app()->db
            ->createCommand($sql)
            ->bindValues(array(':s_day' => $_REQUEST['s_day'], ':e_day' => $_REQUEST['e_day']));
        $data = $command->queryAll();
//        $model->unsetAttributes(); // clear any default values
//        if (isset($_GET['Transition']))
//            $model->attributes = $_GET['Transition'];

        ob_end_clean();
        header('Content-type: application/vnd.ms-excel, charset=utf-8');
        header('Content-Disposition: attachment; filename=' . urlencode($filename) . '.xls');
        /**
         * The header of the table
         * @var string
         */
        $table = "<table><tr><td>$filename</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        $header = "<tr><td>凭证</td><td>凭证摘要</td><td>借贷</td><td>借贷科目</td><td>交易金额</td><td>附加信息</td><td>过账</td><td>凭证日期</td></tr> ";
        $rows = "";
        /**
         * All the data of the table in a formatted string
         * @var string
         */
        foreach ($data as $row) {
            $rows .= "<tr><td>" . $row['entry_num_prefix'] . $this->addZero($row['entry_num']) . "</td>
            <td>" . $row['entry_memo'] . "</td>
            <td>" . Transition::transaction($row['entry_transaction']) . "</td>
            <td>" . Subjects::getSbjPath($row['entry_subject']) . "</td>
            <td>" . $row['entry_amount'] . "</td>
            <td>" . Transition::getAppendix($row['entry_appendix_type'], $row['entry_appendix_id']) . "</td>
            <td>" . Transition::getPosting($row['entry_posting']) . "</td>
            <td>" . $row['entry_date'] . "</td></tr>";
        }
        $data = $table . $header . $rows . '</table>';
        $style = '<style type="text/css">
            table{
                border: 1px solid black;
            }
            td{
                border: 1px solid black;
            }
            th{
                border: 1px solid black;

            }

            </style>';
        echo $style . $data;
    }

    /*
     * 科目表名称
     */
    public function getSbjName($id)
    {
        $model = Subjects::model()->findByAttributes(array('sbj_number' => $id));
        return $model->sbj_name;
    }

    /*
     * 保存数据
     * $status Integer  保存原始数据的状态 0:失败; 1:成功; 2:部分成功
     * $status_tran Integer     生成凭证的状态 0:失败; 1:成功; 2:部分成功
     * $return String   ['status','data'], status:0原数据保存失败，status:1原数据保存成功未生成凭证，status:2保存成功并生成凭证
     */
    public function saveAll($type, $id = '')
    {
        $trans = $_POST['lists'];
        $result = [];
        $newone = 0;
        foreach ($trans as $key => $item) {
            $arr = $item['Transition'];
            $arr['updated_at'] = time();
            if($arr['entry_amount']=='')
                $arr['entry_amount'] = $arr['price']*$arr['count'];
            elseif(!isset($arr['price'])||$arr['price']==''){
                $arr['price'] = $arr['entry_amount'];
            }
            $arr['entry_date'] = date('Ymd',strtotime($arr['entry_date']));
            switch($type){
                case 'bank':
                    $subject_2 = $_POST['subject_2'];
                    $arr['subject_2'] = $subject_2;
                    $model = new Bank;
                    $path = explode('=>', $arr['path']);
                    if($path[2]=='销售收入'){
                        $order = Product::model()->findByAttributes(['order_no'=>$path[4]]);
                        if($order){
                            $model['type'] = 'product';
                            $model['pid'] = $order['id'];
                            $arr['relation'] = json_encode(['product'=>$order['id']]);
                        }
                    }elseif($path[2] == '供应商采购'){
                        $order = Purchase::model()->findByAttributes(['order_no'=>$path[4]]);
                        if($order){
                            $model['type'] = 'purchase';
                            $model['pid'] = $order['id'];
                            $arr['relation'] = json_encode(['purchase'=>$order['id']]);
                        }
                    }elseif($path[2] == '员工报销' && $path[4] != '预支款'){
                        $order = Reimburse::model()->findByAttributes(['order_no'=>$path[4]]);
                        if($order){
                            $model['type'] = 'reimburse';
                            $model['pid'] = $order['id'];
                            $arr['relation'] = json_encode(['reimburse'=>$order['id']]);
                        }
                        $arr['entry_subject'] = $subject_2;
                        $arr['entry_transaction'] = 2;
                        $sbj2241 = Subjects::matchSubject($path[3],['2241']);
                        $sbj1221 = Subjects::matchSubject($path[3], ['1221']);
                        $amounttmp = $order->mountTotal() - $order->mountPaid();
                        if($amounttmp >= $arr['entry_amount'])
                            $arr['subject_2'] = $sbj2241;
                        else{   //金额超出原报销订单的部分，生成预支订单
                            $preOrder = new Preparation();
                            $preOrder->order_no = $preOrder->initOrder('reimburse');
                            $preOrder->type = $type;
                            $preOrder->entry_amount = $arr['entry_amount'] - $amounttmp;
                            $arr['subject_2'] = $sbj2241. ','. $sbj1221;
                            $arr['subject_2_price'] = $amounttmp. ','. ($arr['entry_amount'] - $amounttmp);
                        }
                    }
                    break;
                case 'cash':
                    $arr['subject_2'] = 1001;   //库存现金
                    $model = new Cash;
                    break;
                case 'purchase':
                    $arr['entry_appendix_type'] = 1;
                    $model = new Purchase();
                    $vendor = Vendor::model()->findByPk($arr['vendor_id']);
                    if($vendor!=null)
                        $sbj = Subjects::matchSubject($vendor->company,[2202]);
                    else{
                        $arr['error'] = ['请重新选择供应商'];
                        $arr['id'] = isset($id)?$id:'';
                        $result[] = ['status' => 0, 'data' => $arr];
                        continue 2;
                    }
                    if(isset($arr['preOrder']) && ($arr['preOrder']!='0'||$arr['preOrder']!='')){
                        $amountpre = 0;
                        foreach ($arr['preOrder'] as $item) {
                            $porder = Preparation::model()->findByAttributes(['order_no' => $item]);
                            if ($porder) {
                                //判断预付订单的时间不能晚于，当前采购时间
                                if ($porder['type'] == 'bank')
                                    $ordertmp = Bank::model()->findByPk($porder['pid']);
                                elseif ($porder['type'] == 'cash')
                                    $ordertmp = Cash::model()->findByPk($porder['pid']);
                                if ($ordertmp['date'] > $arr['entry_date']) {
                                    $arr['error'] = ['采购日期必须大于预付款日期'];
                                    $arr['id'] = isset($id) ? $id : '';
                                    $result[] = ['status' => 0, 'data' => $arr];
                                    continue 3;
                                }

                                $amountpre += $porder->entry_amount;
                                $porder->status = 2;
                                $porders[] = $porder;
                            }
                        }
                        $amounttmp = $arr['entry_amount'] - $amountpre;
                        $sbj1123 = Subjects::matchSubject($vendor->company, [1123]);
                        if ($amounttmp <= 0) {
                            $arr['subject_2'] = $sbj1123;
                        } else {
                            $arr['subject_2'] = $sbj . ',' . $sbj1123;
                            $arr['subject_2_price'] = $amounttmp . ',' . $amountpre;
                        }
                    }else
                        $arr['subject_2'] = $sbj;
                    $arr['entry_subject'] = substr($arr['entry_subject'],1);
                    break;
                case 'product':
                    //设置科目，1122应收账款下的子科目
                    $client = Client::model()->findByPk($arr['client_id']);
                    if($client!=null)
                        $sbj = Subjects::matchSubject($client->company,[1122]);
                    else{
                        $arr['error'] = ['请重新选择客户'];
                        $arr['id'] = isset($id)?$id:'';
                        $result[] = ['status' => 0, 'data' => $arr];
                        continue 2;
                    }
                    if(isset($arr['preOrder']) && ($arr['preOrder']!='0'||$arr['preOrder']!='')){
                        $amountpre = 0;
                        foreach ($arr['preOrder'] as $item) {
                            $porder = Preparation::model()->findByAttributes(['order_no'=>$item]);
                            if($porder){
                                if($porder['type']=='bank')
                                    $ordertmp = Bank::model()->findByPk($porder['pid']);
                                elseif($porder['type'] == 'cash')
                                    $ordertmp = Cash::model()->findByPk($porder['pid']);
                                if($ordertmp['date'] > $arr['entry_date']){
                                    $arr['error'] = ['销售日期必须大于预收款日期'];
                                    $arr['id'] = isset($id)?$id:'';
                                    $result[] = ['status' => 0, 'data' => $arr];
                                    continue 3;
                                }
                                $amountpre += $porder->entry_amount;
                                $porder->status = 2;
                                $porders[] = $porder;
                            }
                        }

                        $sbj2203 = Subjects::matchSubject($client->company,[2203]);
                        $amounttmp = $arr['entry_amount']-$amountpre;
                        if($amounttmp <= 0)  //采购金额大于等于 所以预支款金额总和
                            $arr['subject_2'] = $sbj2203;
                        else{
                            $arr['subject_2'] = $sbj . ','. $sbj2203;
                            $arr['subject_2_price'] = $amounttmp . ',' . $amountpre;
                        }
                    }else
                        $arr['subject_2'] = $sbj;
                    $arr['entry_subject'] = substr($arr['entry_subject'],1);
                    $arr['entry_appendix_type'] = 2;
                    $model = new Product();
                    break;
                case 'stock':
                    $product = Product::model()->findByAttributes(['order_no'=>$arr['order_no']]);
                    $arr['entry_memo'] = '成本结转-'. $product->entry_name;
                    $model = new Cost();
                    break;
                case 'salary':
                    $employee = Employee::model()->findByAttributes(['name'=>$arr['employee_name']]);
                    $arr['entry_memo'] = '个人工资-'. $arr['employee_name']. '-'. convertDate($arr['entry_date'],'Y年m月');
                    $model = new Salary();
                    $sbj_arr = [];
                    $sbj_arr[] = Subjects::matchSubject('应付工资', '2211');    //税后工资
                    $sbj_arr[] = Subjects::matchSubject('个人所得税', '2221');   //个税
                    $sbj_arr[] = Subjects::matchSubject('应付社保', '2211');    //社保个人部分
                    $sbj_arr[] = Subjects::matchSubject('应付福利', '2211');    //其他
                    $sbj_arr[] = Subjects::matchSubject('应付公积金', '2211');   //公积金个人
                    $amount_arr = [];
                    $amount_arr[] = $arr['after_tax'] - $arr['benefit_amount']; //去除其他收入部分
                    $amount_arr[] = $arr['personal_tax'];
                    $amount_arr[] = $arr['social_personal'];
                    $amount_arr[] = $arr['benefit_amount'];
                    $amount_arr[] = $arr['provident_personal'];
                    $arr['subject_2'] = implode(',', $sbj_arr);
                    $arr['subject_2_price'] = implode(',', $amount_arr);
                    //删除旧的工资数据和凭证
                    $salary = Salary::model()->findByAttributes(['employee_id'=>$employee->id,'entry_date'=>$arr['entry_date']]);
                    if($salary!=null){
                        Transition::model()->deleteAllByAttributes(['data_type'=>'salary','data_id'=>$salary->id]);
                        $model = $salary;
                        $model->load($arr);
                    }
                    break;
                case 'reimburse':
                    $lists = [
                        'travel_amount' => '差旅费',
                        'benefit_amount' => '福利费',
                        'traffic_amount' => '交通费',
                        'phone_amount' => '通讯费',
                        'entertainment_amount' => '招待费',
                        'office_amount' => '办公费',
                        'rent_amount' => '租金',
                        'watere_amount' => '水电费',
                        'train_amount' => '培训费',
                        'service_amount' => '服务费',
                        'stamping_amount' => '印花税'
                    ];
                    $employee = Employee::model()->findByAttributes(['name'=>$arr['employee_name']]);

                    $model = new Reimburse();
                    $tran_arr = [];
                    //因为一次报销的项目很多，所以，当计算了前面几项报销后，由于还未保存数据，
                    //导致后面几项报销检查其他应收的金额没有及时更新,后面检查时，需要把这次项目前面的金额合并计算在内
                    $reim_amount_2 = 0;
                    foreach ($lists as $key => $item) {
                        if($arr[$key] > 0){
                            $reim = new Transition();
                            $tmp = Department::matchSubject($employee->department_id, $item);
                            $arr['entry_subject'] = $tmp;
                            $reim->attributes = $arr;
                            $reim->entry_amount = $arr[$key];
                            $sbj1221 = Subjects::matchSubject($arr['employee_name'], 1221); //其他应收
                            $sbj2241 = Subjects::matchSubject($arr['employee_name'], 2241); //其他应付
                            //与预支款金额比较
                            if(isset($arr['preOrder']) && ($arr['preOrder']!='0'||$arr['preOrder']!='')) {
                                $amountpre = 0;
                                foreach ($arr['preOrder'] as $a => $item) {
                                    $porder = Preparation::model()->findByAttributes(['order_no' => $item]);
                                    if ($porder) {
                                        if ($porder['type'] == 'bank')
                                            $ordertmp = Bank::model()->findByPk($porder['pid']);
                                        elseif ($porder['type'] == 'cash')
                                            $ordertmp = Cash::model()->findByPk($porder['pid']);
                                        if ($ordertmp['date'] > $arr['entry_date']) {
                                            $arr['error'] = ['报销日期必须大于预支款日期'];
                                            $arr['id'] = isset($id) ? $id : '';
                                            $result[] = ['status' => 0, 'data' => $arr];
                                            continue 3;
                                        }
                                        $amountpre += $porder->entry_amount;
                                        $porder->status = 2;
                                        $porders[$a] = $porder;
                                    }
                                }
                                    $amounttmp = $reim_amount_2 + $arr[$key] - $amountpre;
                                    if ($amounttmp <= 0) {
                                        $sbj2['subject_2'] = $sbj1221;
                                        $sbj2['subject_2_price'] = $arr[$key];
                                    } elseif ($reim_amount_2 >= $amountpre) {
                                        $sbj2['subject_2'] = $sbj2241;
                                        $sbj2['subject_2_price'] = $arr[$key];
                                    } else {
                                        $sbj2['subject_2'] = $sbj1221 . ',' . $sbj2241;
                                        $sbj2['subject_2_price'] = ($amountpre - $reim_amount_2) . ',' . ($arr[$key] - $amountpre + $reim_amount_2);
                                    }
                            }else{
                                $sbj2['subject_2'] = $sbj2241;
                                $sbj2['subject_2_price'] = $arr[$key];
                            }
                            $reim_amount_2 += round(floatval($arr[$key]), 2);
                            $tran_arr[] = [$reim, $sbj2];
                            $arr['subject_2'] = $sbj2['subject_2'];
                        }
                    }
                    break;
            }
            if($newone==0 && $id != '' && $id != '0' )
                $model = $model::model()->findByPk($id);
            elseif (!empty($item['Transition']['d_id'])){
                $model = $model::model()->findByPk($item['Transition']['d_id']);
                $arr['order_no'] = $model->initOrderno();
            }elseif(empty($arr['order_no'])){
                $arr['order_no'] = $model->initOrderno();
            }
            $newone ++;
            if ($arr['price'] == "" || ($arr['price'] == 0 && $arr['before_tax'] == '')) {
                $arr['error'] = ['金额不能为空或为0'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }elseif(!checkAmount($arr['price'])){
                $arr['error'] = ['金额格式不正确'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }
            if ($arr['entry_memo'] == "") {
                $arr['error'] = ['交易说明不能为空'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }
            if ($arr['entry_date'] == "") {
                $arr['error'] = ['日期不能为空'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }elseif(!Transition::createCheckDate($arr['entry_date'])){   //该日期是否已经过账
                $arr['error'] = ['该日期已经结账，或早于账套起始日期'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }
            if(Transition::model()->checkReviewed($id)){
                $arr['error'] = ['该数据生成凭证已经审核，无法修改'];
                $result[] = ['status' => 0, 'data' => $arr];
                continue;
            }
            $model->load($arr);
            if($model->validate()&&$type=='stock'){//成本结转
                mb_internal_encoding( 'UTF-8');
                mb_regex_encoding( 'UTF-8');
                $stocks = mbsplit("\r\n",$arr['stocks']);
                $stocks_price = mbsplit("\r\n",$arr['stocks_price']);
                $stocks_count = mbsplit("\r\n",$arr['stocks_count']);
                $stock = new Stock();
                $order = Product::model()->findByAttributes(['order_no'=>$arr['order_no']]);
                $stock->order_no_sale = $order->order_no;
                $stock->client_id = $order->client_id;
                foreach($stocks as $key => $item){
                    $stock->name = $item;
                    $stock->out_price = $stocks_price[$key];
                    $stock->out_date = $arr['entry_date'];
                    $old_count = $stock->getCount(['order_no_sale'=>$stock->order_no_sale]);
                    if($model->isNewRecord)
                        $old_count = 0;
                    $count = $old_count - $stocks_count[$key];
                    if($count == 0) //数量不变
                        $stock->setStock($stocks_count[$key],2,['order_no_sale'=>$order->order_no]);
                    elseif($count < 0){ //数量增加，增加数量不能大于库存
                        $left = $stock->getCount(['name'=>$item,'status'=>1]);
                        if($left<-$count){    //修改后 数量有新增，判断库存数量是否足够
                            if($key == 0 || !isset($arr['error'])){
                                $arr['error'] = ["$item 数量不能大于：". ($left + $old_count)];
                                $result[] = ['status' => 0, 'data' => $arr];
                            }else
                                end($result)['data']['error'] += ["$item 数量不能大于：". ($left + $old_count)];
                            continue;
                        }else{
                            $stock->setStock($stocks_count[$key],2,['order_no_sale'=>$order->order_no]);
                            $stock->setStock(-$count, 2);    //新增加的
                        }
                    }else{  //数量减少
                        $stock->setStock($stocks_count[$key],2,['order_no_sale'=>$order->order_no]);
                        $stock->setStock($count, 1);    //新增加的
                    }
                }
            }
            $new = $model->isNewRecord?true:false;
            if ($model->save()) {

                //修改原来以此为预收或预付的订单的状态为正常，再将新的订单状态更新为已使用
                Preparation::model()->updateAll(['status'=>1,'real_order'=>''], 'real_order="'. $model->order_no. '"');
                if(isset($preOrder)){   //生成预支预付预收订单
                    Preparation::model()->deleteAllByAttributes(['pid'=>$model->id, 'type'=>$type]);
                    $preOrder->pid = $model->id;
                    $preOrder->save();
                }
                if(isset($porders) && count($porders)>0){   //修改预支预付预收订单的状态和真实关联订单
                    $relation = [];
                    foreach ($porders as $porder) {
                        $porder->real_order = $model->order_no;
                        $porder->save();
                        $relation[] = [$porder->type=>$porder->pid];
                    }
                    $model->relation = json_encode($relation);
                    $model->save();
                }
                if($type == 'bank' || $type == 'cash'){
                    if($path[4]=='预支款' || $path[4]=='预付款'|| $path[4]=='预收款'){  //预收
                        Preparation::model()->deleteAllByAttributes(['pid'=>$model->id, 'type'=>$type]);
                        $order = new Preparation();
                        if(substr($arr['entry_subject'],0,4)=='2203')
                            $order->order_no = $order->initOrder('product');
                        elseif(substr($arr['entry_subject'],0,4)=='1123')
                            $order->order_no = $order->initOrder('purchase');
                        elseif(substr($arr['entry_subject'],0,4)=='1221')
                            $order->order_no = $order->initOrder('reimburse');
                        $order->entry_amount = $arr['entry_amount'];
                        $order->type = $type;
                        $order->pid = $model->id;
                        $order->save();
                    }

                    //银行如果保存的是员工报销的话，需要把报销的项目保存起来
                    $pro_arr = ['travel', 'benefit', 'traffic', 'phone', 'entertainment', 'office', 'rent','watere', 'train','service','stamping'];
                    $tmp_arr = [];
                    foreach ($pro_arr as $item) {
                        if(isset($arr[$item. '_amount']) && $arr[$item. '_amount']>0)
                            $tmp_arr[] = $item. '_amount';
                    }
                    if(!empty($tmp_arr)){
                        //查询出报销的订单，然后保存报销的项目
                        $order = $arr['last'];
                        $reim = Reimburse::model()->findByAttributes(['order_no'=>$order]);
                        if($reim){
                            if($new){
                                $tmp_arr2 = array_filter(explode(',', $reim->paid));
                                $tmp_arr = array_unique( array_merge($tmp_arr,$tmp_arr2) );
                            }
                            $str = implode(',', $tmp_arr);
                            $reim->paid = $str;
                            $reim->save();
                        }
                    }
                }
                //采购的如果是固定资产，无形资产，长期待摊，需要把当时的
                if($type == 'purchase'){
                    $stock = new Stock();
                    $stock->load($arr, 'purchase');
                    if($id != '' && $arr['entry_name']!='劳务服务' && $arr['entry_name']!='缴纳税款'){

                        $model = $model::model()->findByPk($id);
                        $old_count = count(Stock::model()->findAllByAttributes(['order_no'=>$stock->order_no]));

                        $count = $old_count - (int)$arr['count'];
                        $stock->updateAll($stock->form('purchase'),"order_no='$stock->order_no'");
                        $one = $stock->findByAttributes(['order_no'=>$stock->order_no]);
                        if($one){
                            $stock->value_year = $one['value_year'];
                            $stock->value_rate = $one['value_rate'];
                        }
                        if($count<0){   //数量有增加
                            $stock->saveMultiple(-$count);
                        }
                        elseif($count>0){   //数量减少
                            $left = $stock->getCount(['name'=>$arr['entry_name'],'status'=>1]);
                            $stock->delStock($count);
                            if($left>=$count && $count!=0)
                                $stock->delStock($count);
                            else{
                                $arr['error'] = ["数量不能小于：". ($count - $left + $arr['count'])];
                                $result[] = ['status' => 0, 'data' => $arr];
                                continue;
                            }
                        }
                    }else{
                        $stock->saveMultiple($arr['count']);
                    }
                }
                if($arr['entry_transaction']=='')
                    $arr['entry_transaction'] = 1;
                $tran = new Transition;
                $tran2 = new Transition;
                $tran->attributes = $arr;
                $tran2->attributes = $arr;
                $prefix = substr($tran->entry_date, 0, 6);
                //设置一些默认值，如果是利息相关的，都是借，金额为负
                $data = [
                    'data_type' => $type,
                    'data_id' => $model->id,
                    'entry_num_prefix' => $prefix,
                    'entry_memo' => $arr['entry_memo'],
                    'entry_date' => $arr['entry_date'],
                    'entry_num' => $this->tranSuffix($prefix),
                    'entry_creater' => Yii::app()->user->id,
                    'entry_editor' => Yii::app()->user->id,
                ];
                $tran->attributes = $data;
                $data['entry_appendix_type'] = null;
                $data['entry_appendix_id'] = 0;
                //如果有手动生成的数组凭证，则表明不只一条凭证
                if(!empty($tran_arr)){
                    foreach ($tran_arr as $item) {
//                        $data['entry_num'] = $this->tranSuffix($prefix);
                        $data['entry_transaction'] = 1;
                        $item[0]->attributes = $data;
                        $item[0]->save();
                        $subject_2_arr = explode(',', $item[1]['subject_2']);
                        $subject_2_price = explode(',', $item[1]['subject_2_price']);
                        foreach($subject_2_arr as $key => $item2){
                            if($subject_2_price[$key]!=0){
                                $tran_tmp = Transition::model()->findByAttributes([
                                    'entry_num_prefix'=>$item[0]->entry_num_prefix,
                                    'entry_num' => $item[0]->entry_num,
                                    'entry_subject' => $item2
                                ]);
                                if(!$tran_tmp){
                                    $tmp = new Transition();
                                    $tmp->attributes = $item[0]->attributes;
                                    $tmp->entry_transaction = 2;
                                    $tmp->entry_subject = $item2;
                                    $tmp->entry_amount = $subject_2_price[$key];
                                    $tmp->save();
                                }else{
                                    $tran_tmp->entry_amount += $subject_2_price[$key];
                                    $tran_tmp->save();
                                }
                            }
                        }
                    }
                }
                elseif ($tran->validate()) {
                    //设置同一凭证的其他条目，并修改$tran的金额
                    //@subject
                    //@amount
                    $amount = $tran->getAttribute('entry_amount');
                    $list = [];
                    if (!empty($_POST['lists'][$key]['Transition']['additional'])) {
                        foreach ($_POST['lists'][$key]['Transition']['additional'] as $item) {
                            if ($item['subject'] != '' && $item['amount'] != '') {
                                $tmp = new Transition;
                                $tmp->attributes = $arr;
                                $tmp->attributes = $data;
                                $tmp->setAttribute('entry_subject', $item['subject']);
                                $tmp->setAttribute('entry_amount', $item['amount']);
                                $amount = $amount - $item['amount'];
                                $list[] = $tmp;
                            }
                        }
                        $tran->setAttribute('entry_amount', $amount);
                    }
                    if (!$this->keepTransaction($tran->entry_subject))
                        $data['entry_transaction'] = $tran->entry_transaction == 1 ? 2 : 1;
                    else
                        $tran['entry_amount'] = -$tran['entry_amount'];
                    $data['entry_subject'] = $arr['subject_2'];
                    $subject_2_arr = explode(',', $arr['subject_2']);

                    if(count($subject_2_arr)>1){
                        $subject_2_price = explode(',', $arr['subject_2_price']);
                        foreach($subject_2_arr as $key => $item){
                            if($subject_2_price[$key]!=0){
                                $data['entry_amount'] = $subject_2_price[$key];
                                $data['entry_subject'] = $item;
                                $tran_tmp = new Transition();
                                $tran_tmp->attributes = $data;
                                $tran_temp[] = $tran_tmp;
                            }
                        }
                    }else
                        $tran2->attributes = $data;
                    try{
                        if ($model->id != '')
                            $this->delTran($type, $model->id);
                        if($arr['status_id']=="1") {  //0：作废；2：银行间转账，都不需要生成凭证，
                            if($tran->entry_amount!=0)
                                $tran->save();
                            if(!empty($tran_temp))
                                foreach($tran_temp as $item){
                                    $item->save();
                                }
                            else
                                $tran2->save();
                            foreach ($list as $item) {
                                $item->save();
                            }
                            if (isset($arr['tax'])&&$arr['tax'] == 5) { //营业税需要生成2个凭证
                                $tran3 = new Transition();
                                $tran4 = new Transition();
                                $data = array_merge($data, [
                                    'entry_memo' => $arr['entry_memo'],
                                    'entry_amount' => $arr['entry_amount'] * 0.05,
                                    'entry_num' => $this->tranSuffix($prefix),
                                    'entry_subject' => 640304,   //借 营业税金及附加 营业税
                                    'entry_transaction' => 1,
                                ]);
                                $tran3->attributes = $data;
                                $data = array_merge($data, ['entry_subject' => 222102, 'entry_transaction' => 2]);     //贷 应交税费/营业税
                                $tran4->attributes = $data;
                                $tran3->save();
                                $tran4->save();
                            }
                            //设置该记录已经生成凭证
                            $model->status_id = 1;
                        }
                        $model->save();
                    }catch (CDbException $e){

                    }
                }
            } else {//未保存
                if ($model->id == null)
                    $arr['error'] = $model->getErrors();
                else
                    $arr['error'] = ['原始数据已保存，未做选择，凭证保存失败'];
                $arr['d_id'] = $model->id;
                $result[] = ['status' => 0, 'data' => $arr];
            }
        }
        return $result;
    }

    /*
     * 删除旧的凭证
     * @type String
     * @id integer
     */
    public function delTran($type, $id)
    {
        Transition::model()->deleteAll('data_type=:type and data_id=:id ', [':type' => $type,':id' => $id]);
    }

    /*
     * 凭证的借贷，有可能都是借，下列列表中的科目都是借或都是贷，只是金额为负
     * @sbj_number
     */
    public function keepTransaction($id)
    {
        $arr = [660302];    //660302利息费用
        if (in_array($id, $arr))
            return true;
        else
            return false;
    }
}
