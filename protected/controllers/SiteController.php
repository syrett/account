<?php

class SiteController extends Controller
{

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('login',),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $condom = Condom::model()->findByAttributes(['dbname'=>substr(SYSDB,8)]);
        $need_chg_tax = false;
        if ($condom->taxpayer_t == 1) {
            $subjects = Subjects::model()->findByAttributes(['sbj_tax' => 3]);
            if ($subjects !== null) {
                $need_chg_tax = true;
            }
        }

        //日志
        $logs = OperatingRecords::model()->recently()->findAll();

        $this->render('index', ['need_chg_tax' => $need_chg_tax, 'logs' => $logs]);
//        $this->redirect($this->createUrl('transition/create'));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->redirect(LoginURL);

        // if it is ajax validation request
        //单点登陆，注释掉这部分登陆页面
//		$model=new LoginForm;
//		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//
//		// collect user input data
//		if(isset($_POST['LoginForm']))
//		{
//            $_POST['LoginForm']['password'] = md5($_POST['LoginForm']['password']);
//			$model->attributes=$_POST['LoginForm'];
//			// validate user input and redirect to the previous page if valid
//			if($model->validate() && $model->login())
//				$this->redirect(Yii::app()->user->returnUrl);
//		}
//		// display the login form
//		$this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * Displays Operation
     */
    public function actionOperation()
    {
        if (isset($_REQUEST['operation'])) {
            $operation = $_REQUEST['operation'];
            $date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Ym', time());
            $this->render('operation', array('operation' => $operation, 'date' => $date));
        } else
            $this->redirect('/');
    }

    /*
     * @operation string
     * @return array(2013=>array(1,2,4),2014=>array(1,2,3))
     */
    public function listMonth($operation)
    {
        $arr = call_user_func(array('Transition', $operation));
        return $arr;
    }

    /*
     * 一键操作
     */
    public function actionOneKey()
    {
        if (Yii::app()->request->isPostRequest) {
            $this->onekey(!empty($_REQUEST['edate']) ? $_REQUEST['edate'] : '');
            $this->refresh();
        }

        $this->render('one');
    }

    /*
     * 进度条
     */
    public function ActionGetProgressBarData($key,$date){
        $response = ProgressBar::get($key,$date);
        echo json_encode($response);
    }

    /*
     * 结账情况
     */
    public function actionCondomStatus(){
        $this->render('status');
    }
}