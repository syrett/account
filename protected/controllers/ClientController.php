<?php

class ClientController extends Controller
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
            $rules[0]['actions'] = ['index', 'admin', 'update', 'create', 'view', 'delete'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['createclient', 'getclient', 'bad']);
        return $rules;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        //查看所有凭证，并列出
        $model = $this->loadModel($id);
        foreach (Client::$ageZone as $tab => $item) {
            switch ($tab) {
                case 0:
                    $fDate = '';
                    $tDate = '';
                    break;
                case 1: //30天内
                    $fDate = date('Ymd', time() - 3600 * 24 * 30);
                    $tDate = '';
                    break;
                case 2: //30-90天
                    $fDate = date('Ymd', time() - 3600 * 24 * 90);
                    $tDate = date('Ymd', time() - 3600 * 24 * 30);
                    break;
                case 3: //90-180天
                    $fDate = date('Ymd', time() - 3600 * 24 * 180);
                    $tDate = date('Ymd', time() - 3600 * 24 * 90);
                    break;
                case 4: //180-365天
                    $fDate = date('Ymd', time() - 3600 * 24 * 365);
                    $tDate = date('Ymd', time() - 3600 * 24 * 180);
                    break;
                case 5: //1-2年
                    $fDate = date('Ymd', time() - 3600 * 24 * 365 * 2);
                    $tDate = date('Ymd', time() - 3600 * 24 * 365);
                    break;
                case 6: //2-5
                    $fDate = date('Ymd', time() - 3600 * 24 * 365 * 5);
                    $tDate = date('Ymd', time() - 3600 * 24 * 365 * 2);
                    break;
                case 7: //5-
                    $fDate = '';
                    $tDate = date('Ymd', time() - 3600 * 24 * 365 * 5);
                    break;
            }
            $trans = $model->getDetail($fDate, $tDate);
            $dataProvider[] = new CArrayDataProvider($trans);
        }
        $this->render('view', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Client;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Client'])) {
            $model->attributes = $_POST['Client'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $this->render('update', array(
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

        if (isset($_POST['Client'])) {
            $oldName = $model->company;
            $model->attributes = $_POST['Client'];
            if ($model->save()) {
                //更新科目表
                Subjects::model()->updateName($oldName, $model->company);
                $this->redirect(array('admin'));
            }
        }

        $dataProvider = $model->search();
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
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
        $sbj = Subjects::model()->findByAttributes(['sbj_name' => $model->company]);
        //如果科目表有以该客户名称为名的科目，则不能删除，
        if ($sbj == null)
            $this->loadModel($id)->delete();
        else
            echo '该客户不能删除';

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Client');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Client('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Client']))
            $model->attributes = $_GET['Client'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Client the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Client::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Client $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'client-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * 新建供应商
     */
    public function actionCreateclient()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Client();
            $data['company'] = $_POST['name'];
            $a = $model->model()->findByAttributes($data);
            if ($a != null)
                echo $a->id;
            else {
                $model = new Client;
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
    public function actionGetclient()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $models = Client::model()->findAll();
            foreach ($models as $model) {
                $result[$model->id] = $model->company;
            }
            echo json_encode($result);
        }
    }

    /*
     * 坏账处理
     */
    public function actionBad()
    {
        $client_id = $_POST['client_id'];
        $amount = $_POST['bad-amount'];
        $action = $_POST['action'];
        $model = $this->loadModel($client_id);
        if ($model) {
            if ($action == 'bad') {
                if ($amount == 0 || $amount == '') {
                    Yii::app()->user->setFlash('success', "金额为0，无需处理!");
                    $this->redirect(['age']);
                }
                $uamount = $model->getUnreceived();
                if ($amount > $uamount)
                    $amount = $uamount;
                $tran1 = new Transition();
                $tran2 = new Transition();
                $tran1->entry_transaction = 1;
                $tran2->entry_transaction = 2;
                $tran1->entry_subject = Subjects::matchSubject('坏账损失', '6701');
                $tran2->entry_subject = '1231';
                $date = Transition::getTransitionDate();
                $dates = Condom::model()->getStartTime();
                if ($date < $dates . '01')
                    $date = $dates;
                $prefix = substr($date, 0, 6);
                $data = [
//                    'data_type' => 'bad_debts',
//                    'data_id' => $model->id,
                    'entry_num_prefix' => $prefix,
                    'entry_memo' => $model->company . '_坏账',
                    'entry_date' => convertDate($date, 'Y-m-d 00:00:00'),
                    'entry_num' => Transition::model()->tranSuffix($prefix),
                    'entry_creater' => Yii::app()->user->id,
                    'entry_editor' => Yii::app()->user->id,
                    'entry_amount' => $amount,
                ];
                $tran1->attributes = $data;
                $tran2->attributes = $data;
                if ($tran1->save() && $tran2->save()) {
                    Yii::app()->user->setFlash('success', "计提坏账成功!");
                    $this->redirect(['age']);
                }
            } elseif ($action == 's-bad') {      //确认坏账
                if ($amount == 0 || $amount == '') {
                    Yii::app()->user->setFlash('success', "金额为0，无需处理!");
                    $this->redirect(['age']);
                }
//                $uamount = $model->getBalance();
//                if ($amount > $uamount)
//                    $amount = $uamount;
                $tran1 = new Transition();
                $tran2 = new Transition();
                $tran1->entry_transaction = 1;
                $tran2->entry_transaction = 2;
                $tran1->entry_subject = '1231';
                $tran2->entry_subject = Subjects::matchSubject($model->company, '1122');
                $date = Transition::getTransitionDate();
                $dates = Condom::model()->getStartTime();
                if ($date < $dates . '01')
                    $date = $dates;
                $prefix = substr($date, 0, 6);
                $data = [
//                    'data_type' => 'bad_debts',
//                    'data_id' => $model->id,
                    'entry_num_prefix' => $prefix,
                    'entry_memo' => $model->company . '_确认坏账',
                    'entry_date' => convertDate($date, 'Y-m-d 00:00:00'),
                    'entry_num' => Transition::model()->tranSuffix($prefix),
                    'entry_creater' => Yii::app()->user->id,
                    'entry_editor' => Yii::app()->user->id,
                    'entry_amount' => $amount,
                ];
                $tran1->attributes = $data;
                $tran2->attributes = $data;
                if ($tran1->save() && $tran2->save()) {
                    Yii::app()->user->setFlash('success', "确认坏账成功!");
                    $this->redirect(['age']);
                }

            }
        } else
            Yii::app()->user->setFlash('error', "无法找到该客户，刷新后重试!");
        $this->redirect(['age']);
    }

    /*
     * 账龄控制器
     */
    public function actionAge()
    {

        $arr = [[1122, 2203], [1221]];
        foreach ($arr as $key => $item) {
            $clients = Client::model()->findAll();


            foreach ($clients as $client) {
                //检查应收、预收、其他应收
                $regexp = '';
                foreach ($item as $one => $sbj) {
                    $regexp .= $regexp == '' ? 'sbj_number regexp "^' . $sbj . '"' : ' or sbj_number regexp "^' . $sbj . '"';
                }
                $sbjs = Subjects::model()->findAllByAttributes(['sbj_name' => $client->company, 'has_sub' => 0], $regexp);
                if (count($sbjs) > 0) {   //最多应该只有3个科目
                    $where = '';
                    foreach ($sbjs as $sbj) {
                        $where .= $where == '' ? "(entry_subject='$sbj->sbj_number'" : " or entry_subject='$sbj->sbj_number'";
                    }
                    $where .= ')';
                    $orderby = ' order by entry_date';
                    //借方
                    $debits = Transition::model()->findAllByAttributes([], $where . ' and ((entry_transaction = 1 and entry_amount > 0) or (entry_transaction = 2 and entry_amount < 0))' . $orderby);
                    //贷方
                    $credits = Transition::model()->findAllByAttributes([], $where . ' and ((entry_transaction = 2 and entry_amount > 0) or (entry_transaction = 1 and entry_amount < 0))' . $orderby);
                    $debit_amount = 0;
                    foreach ($debits as $debit) {
                        $debit_amount += abs($debit->entry_amount);
                    }
                    $credit_amount = 0;
                    foreach ($credits as $credit) {
                        $credit_amount += abs($credit->entry_amount);
                    }
//                $balance = $debit_amount - $credit_amount;
                    if ($debit_amount > $credit_amount) {   //借方大于0，客户需要付钱给公司
                        foreach ($debits as $debit) {
                            if ($credit_amount < $debit->entry_amount) {    //有钱未收完，把时间算出
                                $client->ageZone[$client::getZone($debit->entry_date)] += $credit_amount <= 0 ? $debit->entry_amount : ($debit->entry_amount - $credit_amount);
                                $client->ageZone['全部'] += $credit_amount <= 0 ? $debit->entry_amount : ($debit->entry_amount - $credit_amount);
                            }
                            $credit_amount -= $debit->entry_amount;
                        }
                    }

                }
            }
            $dataProvider[$key] = $clients;
        }
        $this->render('age', array(
            'dataProvider0' => $dataProvider[0],
            'dataProvider1' => $dataProvider[1],
        ));
    }
}






















