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
                'actions' => array('create', 'update', 'getTranSuffix', 'Appendix', 'ListFirst', 'reorganise', 'ajaxListFirst',
                    'review', 'settlement', 'antiSettlement','listReview',
                    'ListTransition', 'listPost', 'listReorganise', 'listSettlement', 'Print'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin',),
                'roles'=>array('admin'),
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
            $sessionKey = $user_id.'_is_sending';


            if(isset($session[$sessionKey])){
                $first_submit_time = $session[$sessionKey];
                $current_time      = time();
                if($current_time - $first_submit_time < 10){
                    $session[$sessionKey] = $current_time;
                    throw new CHttpException(400, "10秒内不能重复提交");
                }else{
                    unset($session[$sessionKey]);//超过限制时间，释放session";
                }
            }


            //第一次点击确认按钮时执行
            if(!isset($session[$sessionKey])){
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
                $this->render('success');
            }
            else{
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
//        $items = $this->getItemsToUpdate($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Transition'])) {
            $items = $this->saveTransitions();
            $this->redirect('index.php?r=transition/admin');
        } else {
            $items = $this->getItemsToUpdate($id);
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
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            $id = $_REQUEST[0]['id'];
            $action = $_REQUEST[0]['action'];
            $items = $this->getItemsToUpdate($id);
            foreach ($items as $item) {
                if($action==0)
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
//        $dataProvider = new CActiveDataProvider('Transition');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
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


    public function actionReorganise($date)
    {
//        if (!isset($_POST['entry_num_prefix'])) {
//            $prefix = date('Y') . date('m');
//        };
        //整理按月为结点
        $this->reorganise($date);
        $this->redirect("index.php?r=transition/index");
    }

    public function reorganise($date){
        $prefix = $date;
        $del_condition = 'entry_num_prefix=:prefix and entry_deleted=:bool';
        Transition::model()->deleteAll($del_condition, array(':prefix' => $prefix, ':bool' => 1));

        $sql = "select id,entry_num from transition where entry_num_prefix=:prefix order by entry_num ASC"; //从小到大排序
        $data = Transition::model()->findAllBySql($sql, array(':prefix' => $prefix));

        $num = 1;
        $i = 1;
        $last = 0;
        foreach ($data as $row) {
            if ($num == 1)
                $last = $row['entry_num'];

            if ($last != $row['entry_num']) {
                $i++;
            }
            $pk = $row['id'];
            Transition::model()->updateByPk($pk, array('entry_num' => $i));
            $last = $row['entry_num'];
            $num++;
        }
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
        $result = $this->tranPrefix(). $this->tranSuffix($result);
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
     *  getUserlist
     */
    public function getUserlist($condition='',$params=array())
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
                $list=array(6601,6602);
                if (in_array($subject, $list)&&$subject!=6401) { //全部 5:费用 类科目   列出员工employee

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
            array_push($result, array($number, $item));
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

        if (isset($_REQUEST['entry_num_prefix']))
            $prefix = $_REQUEST['entry_num_prefix'];
        $_POST['entry_num'] = $this->tranSuffix($prefix);
//        Yii::app()->db->createCommand('set names "utf8"')->execute();
        foreach ($_POST['Transition'] as $Tran) {
            if (isset($Tran)) {
                $Tran['entry_num'] = intval($_POST['entry_num']);
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
            $itmes = array();
            foreach($list as $item){
                $item = $this->loadModel($item['id']);
                if($valid = $item->validate() && $valid)
                {
                    if($_REQUEST[0]['action']==1)
                    {
                        $item->entry_reviewed = 0;
                        $item->entry_reviewer = 0;
                    }
                    else{
                        $item->entry_reviewed = 1;
                        $item->entry_reviewer = Yii::app()->user->id;
                    }
                    $item->save();
                }
                else
                {
                } //当前登陆用户id
                $items[] = $item;
            }
            if($valid)
                $this->redirect($this->createUrl('transition/admin'));
            else{
                $this->render('update', array(
                    'model' => $items,
                ));
            }
//                $this->redirect(array('update','id'=>$id));
//                $this->redirect($this->createUrl('transition/update'), array('admin'));
        }

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
        // load models which is the same entry_num_prefix+entry_num
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
    public function actionSettlement($entry_prefix){
        if($entry_prefix>Yii::app()->params['startDate'])
        {
            $lastdate = date('Ym', strtotime('-1 months', strtotime($entry_prefix . '01')));
            while($lastdate>Yii::app()->params['startDate']){
                if(Transition::model()->hasTransition($lastdate))
                {
                    if(!Transition::model()->tranSettlement($lastdate))
                        throw new CHttpException(400, $lastdate. "需要先结账");
                    else
                        $lastdate = date('Ym', strtotime('-1 months', strtotime($lastdate . '01')));
                }
                else
                    $lastdate = date('Ym', strtotime('-1 months', strtotime($lastdate . '01')));
            }
        }

        if(!Transition::model()->checkSettlement($entry_prefix))
            throw new CHttpException(400, $entry_prefix. "结账失败");
        $this->reorganise($entry_prefix); //结账前先整理
        $entry_num = $this->tranSuffix($entry_prefix);
        $entry_memo = '结转凭证';
        $entry_editor = Yii::app()->user->id;
        $entry_reviewer = 0;
        $entry_settlement = 1;
        $arr = Subjects::model()->actionListFirst();
        $sum = 0;
        $hasDate = false;
        $date = getYear($entry_prefix).'-'.getMon($entry_prefix).'-01'.' 00:00:00';
        $date = date('Y-m-d H:i:s', strtotime($date));
        foreach($arr as $sub){
            $tran = new Transition();
            $tran->entry_num_prefix = $entry_prefix;
            $tran->entry_num = $entry_num;
            $tran->entry_date = $date;
            $tran->entry_settlement = $entry_settlement;
            $tran->entry_memo = $entry_memo;
            $tran->entry_transaction = $sub['sbj_cat']=='4'?1:2;    //4：收入类 借 5费用类 贷
            $tran->entry_editor = $entry_editor;
            $tran->entry_reviewer = $entry_reviewer;
            $tran->entry_subject = $sub['id'];
            $amount = $this->getEntry_amount($entry_prefix, $sub['id']);
            $tran->entry_amount = $this->getEntry_amount($entry_prefix, $sub['id']);
            $sum = $sub['sbj_cat']=='4'?$sum + $amount: $sum - $amount;     //该科目合计多少
//          $trans[] = $tran;
            if($amount>0){
                $tran->save();
                $hasDate = true;
            }
        }
        if($hasDate>0){
            $tran = new Transition();
            $tran->entry_num_prefix = $entry_prefix;
            $tran->entry_num = $entry_num;
            $tran->entry_memo = $entry_memo;
            $tran->entry_date = $date;
            $tran->entry_transaction = 2;    //本年利润 为贷
            $tran->entry_editor = $entry_editor;
            $tran->entry_settlement = $entry_settlement;
            $tran->entry_reviewer = $entry_reviewer;
            $tran->entry_subject = '4103';              //本年利润
            $tran->entry_amount = $sum;
            $tran->save();
        }
        if($sum==0)
            $tran->setClosing(1);
        Yii::app()->user->setFlash('success', $entry_prefix."结账成功!");
        $this->render('success');
    }

    /*
     * 返回未结账的年月
     */
    public function getEntry_prefix(){
        $entry_prefix = $this->tranPrefix();
        return $entry_prefix;
    }

    /*
     * 本期科目发生额合计
     */
    public function getEntry_amount($prefix, $sub_id){
        $sql ="SELECT sum(entry_amount) amount FROM `transition` WHERE entry_num_prefix='$prefix' and entry_subject='$sub_id'";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        if(isset($data[0]['amount']))
            return $data[0]['amount'];
        else
            return 0;
    }

    /*
     * 反结账
     */
    public function actionAntiSettlement(){

        $date = date('Ym', time());
        while($date>Yii::app()->params['startDate']){
            if(!Transition::model()->isPosted($date))
                break;
            $date = date('Ym', strtotime('-1 months', strtotime($date . '01')));
        }

        $model = Transition::model()->deleteAllByAttributes(array('entry_num_prefix'=>$date, 'entry_settlement'=>1,));
        //删除post表中的数据
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 6);
        Post::model()->deleteAllByAttributes(array('year'=>$year,'month'=>$month));
        $newModel =new  Transition();
        $newModel->entry_num_prefix = $date;
        $updated = $newModel -> setPosted(0);
        $updated = $newModel->setClosing(0) || $updated;
        if($model>=1 or $updated)
        {
//            header('refresh:2;url=index.php');
            Yii::app()->user->setFlash('success', $date. " 反结账成功!");
            $this->render('success');
        }else
            throw new CHttpException(400, $date. " 反结账失败");
    }

    public function actionSuccess()
    {

        if($message= Yii::app()->user->getFlash('success'))
        {
        }
        else
        {
            $this->redirect(array('quote'));
        }
    }
    /*
     * 按月为时间段
     */
    public function actionListReview(){

            $model = new Transition('search');
            $model->unsetAttributes(); // clear any default values
        if(isset($_REQUEST['date'])){
            $criteria = array('entry_reviewed' => 0, 'entry_num_prefix' => $_REQUEST['date']);
        }
        else{
            $criteria = array('entry_reviewed' => 0);
        }
            $model->attributes = $criteria;
            $this->render('admin', array(
                'model' => $model,'operation' => 'listReview'
            ));
    }

    public function actionListTransition(){
        if(isset($_REQUEST['date'])){
            $model = new Transition('search');
            $model->unsetAttributes(); // clear any default values
            $criteria = array('entry_num_prefix' => $_REQUEST['date']);
            $model->attributes = $criteria;
            $this->render('admin', array(
                'model' => $model,
            ));
        }
        else
            throw new CHttpException(400, "参数错误，请选择时间");
    }

    public function actionListPost(){       //run post
        if(isset($_REQUEST['date'])){
            Yii::app()->runController('Post/post');
        }
    }
    public function actionListReorganise(){     //run Reorganise
        if(isset($_REQUEST['date'])){
            $this->actionReorganise($_REQUEST['date']);
        }
    }
    public function actionListSettlement(){     //run settlement
        if(isset($_REQUEST['date'])){
            $this->actionSettlement($_REQUEST['date']);
        }
    }

    public function actionPrint(){

        $id = 2225;
        $mPDF1 = Yii::app()->ePdf->mpdf();

        $mPDF1->setAutoFont(AUTOFONT_ALL);

        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot'). Yii::app()->theme->baseUrl . '/assets/css/print.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        $items = $this->getItemsToUpdate($id);
        $mPDF1->WriteHTML($this->renderPartial('print', array('model' => $items,),false,true));


        # Outputs ready PDF
//        $mPDF1->Output( 'etc.pdf' , EYiiPdf::OUTPUT_TO_BROWSER );
    }
}
