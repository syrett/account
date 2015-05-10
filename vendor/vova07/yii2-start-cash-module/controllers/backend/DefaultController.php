<?php

namespace vova07\cash\controllers\backend;

use alexgx\phpexcel\PhpExcel;
use laofashi\transition\models\Employee;
use laofashi\transition\models\Subj;
use laofashi\transition\models\Subject;
use laofashi\transition\models\Transition;
use vova07\admin\components\Controller;
use vova07\cash\models\backend\Cash;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use vova07\imperavi\actions\GetAction as ImperaviGet;
use vova07\imperavi\actions\UploadAction as ImperaviUpload;
use Yii;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Default backend controller.
 */
class DefaultController extends Controller
{
    //  ajax post 从yii1到yii2没有csrf，所以部分函数去除csrf验证
    public function beforeAction($action){
        $arr = ['type','option','createemployee','createsubject','save', 'update'];
        if(in_array($action->id,$arr))
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'index' => ['get', 'post'],
                'create' => ['get', 'post'],
                'update' => ['get', 'put', 'post'],
                'delete' => ['post', 'delete'],
                'batch-delete' => ['post', 'delete'],
                'type' => ['post'],
                'option' => ['get','post'],
                'createemployee' => ['post'],
            ]
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'imperavi-get' => [
                'class' => ImperaviGet::className(),
                'url' => $this->module->contentUrl,
                'path' => $this->module->contentPath
            ],
            'imperavi-image-upload' => [
                'class' => ImperaviUpload::className(),
                'url' => $this->module->contentUrl,
                'path' => $this->module->contentPath
            ],
            'imperavi-file-upload' => [
                'class' => ImperaviUpload::className(),
                'url' => $this->module->fileUrl,
                'path' => $this->module->filePath,
                'uploadOnlyImage' => false
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'path' => $this->module->imagesTempPath
            ]
        ];
    }

    /**
     * Posts list page.
     */
    public function actionIndex()
    {
        $objPHPExcel = \PHPExcel_IOFactory::load(Yii::getAlias('@temp'). '/test.xlsx');
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//        $sheetData = array();
        if (Yii::$app->request->post() && isset($_FILES['attachment']) == true) {
            $objPHPExcel = \PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        }elseif(Yii::$app->request->post()){
            $this->save();
        }
        return $this->render('index', ['sheetData' => $sheetData]);
    }

    /**
     * Find model by ID.
     *
     * @param integer|array $id Post ID
     *
     * @return \vova07\cash\models\backend\Cash Model
     *
     * @throws HttpException 404 error if post not found
     */
    protected function findModel($id)
    {
        if (is_array($id)) {
            /** @var \vova07\cash\models\backend\Cash $model */
            $model = cash::findAll($id);
        } else {
            /** @var \vova07\cash\models\backend\Cash $model */
            $model = Cash::findOne($id);
        }
        if ($model !== null) {
            return $model;
        } else {
            throw new HttpException(404);
        }
    }
    /*
     * ajax
     */
    public function actionType(){
        $this->enableCsrfValidation = false;
        if(Yii::$app->request->post())
            echo json_encode(cash::chooseType($_POST['type']));
        else
            throw new HttpException(400);
    }

    /*
     * 返回的选项
     * $_POST['pid'] int 父id
     * $_POST['id']  int 当前选择id
     */
    public function actionOption(){
        if(Yii::$app->request->post()){
            echo json_encode(Cash::chooseOption($_POST['type'],$_POST['option'],$_POST['data']));
        }
        else
            throw new HttpException(400);
    }

    /*
     * 保存员工
     */
    public function actionCreateemployee()
    {
        if (Yii::$app->request->isAjax) {
            $model = new Employee();
            $data['name'] = $_POST['name'];
            $data['department_id'] = $_POST['department'];
            $a = $model->findOne($data);
            if ($a != null)
                echo $a->id;
            else {
                $model->name = $_POST['name'];
                $model->department_id = $_POST['department'];
                if ($model->save())
                    echo $model->id;
                else
                    echo 0;
            }
        }
    }

    /*
     * 新建科目
     */
    public function actionCreatesubject(){
        if(Yii::$app->request->isAjax){
            $name = $_POST['name'];
            $sbj = $_POST['subject'];
            $id = Subject::createSubject($name, $sbj);
            if($id)
                echo $id;
            else
                echo 0;
        }
    }

    /*
     *
     */
    public function actionUpdate($id){
        $model = $this->findModel($id);
//        $models = $this->findModels($id);

        if (!empty(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($this->saveAll($id)) {
                    return $this->refresh();
                } else {
                    Yii::$app->session->setFlash('danger', '凭证修改失败');
                    return $this->refresh();
                }
            } elseif (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        Yii::$app->response->redirect('/index.php?r=cash/update&id='. $id);
    }

    /*
     * 生成凭证
     */
    public function actionSave()
    {
        $this->saveAll();
        Yii::$app->response->redirect('/index.php?r=Transition/cash&action=save');
    }

    /*
     * 保存数据
     * $status Integer  保存原始数据的状态 0:失败; 1:成功; 2:部分成功
     * $status_tran Integer     生成凭证的状态 0:失败; 1:成功; 2:部分成功
     */
    protected function saveAll($id=''){
        $status = 0;
        $status_tran = 0;
        $trans = $_POST['lists'];
        foreach ($trans as $key => $item) {
            if($id!='')
                $cash = Cash::findOne($id);
            elseif(isset($item['Transition']['id']))
                $cash = Cash::findOne($item['Transition']['id']);
            else
                $cash = new Cash();
            $cash->load($_POST['lists'][$key]);
            if($_POST['lists'][$key]['Transition']['entry_name'] == ""){
                Yii::$app->session->setFlash('error', '交易方名称不能为空');
//                break;
            }
            if($_POST['lists'][$key]['Transition']['entry_memo'] == ""){
                Yii::$app->session->setFlash('error', '交易说明不能为空');
//                break;
            }
            if ($cash->save()) {   //有科目编号才能创建凭证
                $status = 1;

                $tran = new Transition(['scenario' => 'create']);
                $tran2 = new Transition(['scenario' => 'create']);
                $tran->load($_POST['lists'][$key]);
                $tran2->load($_POST['lists'][$key]);
                $prefix = substr($tran->entry_date, 0, 6);
                //设置一些默认值，如果是利息相关的，都是借，金额为负
                $data = [
                    'data_type' => 1,   //银行
                    'data_id' => $cash->id,
                    'entry_num_prefix' => $prefix,
                    'entry_num' => $tran->tranSuffix($prefix),
                ];
                $tran->attributes = $data;
                if ($tran->validate()) {
                    //设置同一凭证的其他条目，并修改$tran的金额
                    //@subject
                    //@amount
                    $amount = $tran->getAttribute('entry_amount');
                    $list = [];
                    if (isset($_POST['lists'][$key]['Transition']['additional'])) {
                        foreach ($_POST['lists'][$key]['Transition']['additional'] as $item) {
                            if ($item['subject'] != '' && $item['amount'] != '') {
                                $tmp = new Transition(['scenario' => 'create']);
                                $tmp->load($_POST['lists'][$key]);
                                $tmp->attributes = $data;
                                $tmp->setAttribute('entry_subject', $item['subject']);
                                $tmp->setAttribute('entry_amount', $item['amount']);
                                $amount = $amount - $item['amount'];
                                $list[] = $tmp;
                            }
                        }
                        $tran->setAttribute('entry_amount', $amount);
                    }
                    if(!$this->keepTransaction($tran->entry_subject))
                        $data['entry_transaction'] = $tran->entry_transaction==1?2:1;
                    else
                        $tran['entry_amount'] = -$tran['entry_amount'];
//                    $model = Subj::findOne ($tran->entry_subject);  //银行交易 中的对应银行存款1002，银行存款二级科目可供选择
//                    $data['entry_subject'] = $model->sub_sub;
                    $data['entry_subject'] = 1002;  // 银行存款（1002）
                    $tran2->attributes = $data;
                    if($id!='')
                        $this->delTran(1, $id);
                    if ($tran->save() && $tran2->save()) {
                        foreach ($list as $item) {
                            $item->save();
                        }
                        $status_tran = 1;
                        //设置该记录已经生成凭证
                        $cash->status_id=1;
                        $cash->save();
                    }elseif($status_tran==1){
                        $status_tran = 2;
                    }
                }
            }else{//未保存
                if($status==1)
                    $status = 2;
                $_SESSION['tran'][] = $cash->toArray();
            }
        }
        if($status_tran==0)
            $_SESSION['status'] = 'failed';
        if($status_tran==1)
            $_SESSION['status'] = 'success';
        if($status_tran==2)
            $_SESSION['status'] = 'notall';

        return $status;
    }

    /*
     * 删除旧的凭证
     * @type integer
     * @id integer
     */
    public function delTran($type, $id){
        switch($type){
            case 1:
                Transition::deleteAll(['data_id'=>$id]);
                break;
        }
    }

    /*
     * 凭证的借贷，有可能都是借，下列列表中的科目都是借或都是贷，只是金额为负
     * @sbj_number
     */
    public function keepTransaction($id){
        $arr = [660302];    //660302利息费用
        if(in_array($id, $arr))
            return true;
        else
            return false;
    }
}
