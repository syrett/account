<?php

class PostController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */


    function __construct()
    {
    }

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
        $model = new Post;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['Post'])) {
            $model->attributes = $_POST['Post'];
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


    public function actionPost($date)
    {
        $status = $this->postTran($date);
        if ($status['status'] == 'success')
            $this->render('/site/success');
        else {
            throw new CHttpException(400, $status['msg']);
        }

    }

    public function postTran($date)
    {

        //过账检测总账期初余额和期初余额明细金额是否相等
        $post = Transition::model()->findByAttributes(['entry_posting' => 1]);
        if (!$post) {
            $arr = ['1403', '1405', '1601', '1701', '1801'];
            foreach ($arr as $sbj) {
                if (!Stock::model()->check_balance($sbj)) {
                    $result['status'] = 'failed';
                    $result['msg'] = '总账期初余额与期初明细不相等，请重新核对。   科目：' . Subjects::getName($sbj);
                    return $result;
                }
            }

        }
        $transition = new Transition;

        //检查上月有没有过账
        $date_timestamp = strtotime($date . '01');
        if ($date_timestamp === false) {
            throw new CHttpException(400, '过账月分格式错误!');
        } else {
            $last_month = date('Ym', $date_timestamp - 86399);
            if (!$transition->isAllPosted($last_month)) {
                //假如 上月的数据 还没做凭证的情况 会有问题
                $result['status'] = 'failed';
                $result['msg'] = "需要先过账!";
            }
        }

//      if($transition->isAllPosted($date))
//      {
//          throw new CHttpException(400, $date . "已经过账");
//      }
        $transition->entry_num_prefix = $date;

        if (!Transition::model()->isReorganised($date)) {
            $result['status'] = 'failed';
            $result['msg'] = "还有凭证未整理";
        }
        if ($transition->isAllReviewed($date)) {
            //过账成功后，要计提固定资产折旧
            Yii::import('application.controllers.StockController');
            $con = new StockController('');
            if (SYSDB != 'account_testabxc' && SYSDB != 'account_gbl' && SYSDB != 'account_201508089731')
                $con->actionDepreciation($date);
            //生成附加税凭证
            Transition::createSurtax($date);
            Post::model()->postTransition($date);
            OperatingRecords::insertLog(['msg'=>'过账：'.$date]);
            Yii::app()->user->setFlash('success', $date . "过账成功!");
            $result['status'] = 'success';
        } else{
            $result['status'] = 'failed';
            $result['msg'] = "还有凭证未审核";
        }
        return $result;
    }


    public function actionPosted()
    {
        $model = new Post();
        if (isset($_POST['year']))
            $model->year = $_POST['year'];
        else
            $model->year = date('Y');

        if (isset($_POST['month']))
            $model->month = $_POST['month'];
        else
            $model->month = date('m');
        $dataProvider = $model->listposted();
        $this->render('posted', array(
            'dataProvider' => $dataProvider,
            'header' => "已过账",
            'nextLabel' => "未过账",
            'nextUrl' => array('unposted'),
        ));
    }


    public function actionUnposted()
    {
        $model = new Post;
        $year = (isset($_POST['year'])) ? $_POST['year'] : date('Y');
        $month = (isset($_POST['month'])) ? $_POST['month'] : date('m');

        $model->year = $year;
        $model->month = $month;

        $dataProvider = $model->listunposted();
        $this->render('unposted', array(
            'date' => $year . $month,
            'dataProvider' => $dataProvider,
            'header' => "未过账",
            'nextLabel' => "已过账",
            'nextUrl' => array('posted'),
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Post();
        if (isset($_POST['year']))
            $model->year = $_POST['year'];
        else
            $model->year = date('Y');

        if (isset($_POST['month']))
            $model->month = $_POST['month'];
        else
            $model->month = date('m');
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Post('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Post']))
            $model->attributes = $_GET['Post'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Post the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Post::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Post $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
