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
        $condom = Condom::model()->findByAttributes(['dbname' => substr(SYSDB, 8)]);
        $need_chg_tax = false;
        if ($condom->taxpayer_t == 1) {
            $subjects = Subjects::model()->findByAttributes(['sbj_tax' => 3]);
            if ($subjects !== null) {
                $need_chg_tax = true;
            }
        }

        //日志
        $logs = new OperatingRecords();

        //文章
        $blog = new Blog();
        $blog->unsetAttributes();  // clear any default values
        if (isset($_GET['Blog'])) {
            $blog->attributes = $_GET['Blog'];
        }

        //税务中心数据
        /*
         * 	        个人所得税222102	营业税 640304	增值税222101	企业所得税6801 	印花税660207
         * 本月应交
         * 上月已交
         * 本年已交
         */
        $tax = [
            ['id' => '本月应交', 'p_tax' => 0, 'b_tax' => 0, 's_tax' => 0, 'i_tax' => 0, 'o_tax' => 0],
            ['id' => '上月已交', 'p_tax' => 0, 'b_tax' => 0, 's_tax' => 0, 'i_tax' => 0, 'o_tax' => 0],
            ['id' => '本年已交', 'p_tax' => 0, 'b_tax' => 0, 's_tax' => 0, 'i_tax' => 0, 'o_tax' => 0]
        ];
        $sbjs = [
            'p_tax' => '222102',
            'b_tax' => '640304',
            's_tax' => '22210101',
            'i_tax' => '6801',
            'o_tax' => '660207',
        ];
        foreach ($sbjs as $key => $sbj) {

            $post = Post::model()->findByAttributes(['subject_id' => $sbj, 'year' => date('Y', time()), 'month' => date('m', time())]);
            if (!empty($post)) {
                $tax[0][$key] = $post['credit'];
                $tax[1][$key] = $post['debit'];
            } else {
                $tax[0][$key] = 0;
                $tax[1][$key] = 0;

            }
            $year = date('Y-01-01');
            $sql = "SELECT sum(`entry_amount`) as `amount` FROM `transition` where entry_date >= '$year' and entry_subject = $sbj and entry_transaction=1 and (data_type = 'bank' or data_type = 'cash')";
            $tran = Transition::model()->findBySql($sql);
            $tax[2][$key] = $tran->amount ? $tran->amount : 0;
//            $post = Post::model()->findAllByAttributes(['subject_id' => $sbj, 'year' => date('Y', time())]);
//            if (!empty($post)) {
//                $tax[2][$key] = 0;
//                foreach ($post as $item) {
//                    $tax[2][$key] += $item['debit'];
//                }
//            } else
//                $tax[2][$key] = 0;
        }

        //增值税 进项明细列表
        $taxDetail = [];
        $trans = Transition::model()->findAllByAttributes(['entry_subject' => '22210102', 'entry_transaction' => 1]);
        foreach ($trans as $tran) {
            $detail = ['id'=> $tran->id, 'memo' => $tran->entry_memo, 'date' => substr($tran->entry_date, 0, 10), 'amount' => $tran->entry_amount];
            if ($tran->data_type != null) {   //不是往来调整中添加的凭证
                if ($tran->data_type == 'purchase') {
                    $purchase = Purchase::model()->findByPk($tran->data_id);
                    $vendor = Vendor::model()->findByPk($purchase->vendor_id);
                    $detail += ['vendor' => $vendor->company, 'name' => $purchase->entry_name, 'tax' => $purchase->tax];
                    $detail['amount'] = $purchase->price * $purchase->count;

                }

            }
            $taxDetail[] = $detail;
        }

        $tax = new CArrayDataProvider($tax);
        $taxDetail = new CArrayDataProvider($taxDetail);
        $blog_select_arr = array(
            array('val' => Blog::CATEGORY_ACCOUNT, 'name' => '会计'),
            array('val' => Blog::CATEGORY_TAX, 'name' => '税法'),
            array('val' => Blog::CATEGORY_LAW, 'name' => '经济')
        );

        $this->render('index', array('need_chg_tax' => $need_chg_tax, 'logs' => $logs, 'blog' => $blog, 'select_arr' => $blog_select_arr, 'tax' => $tax, 'taxDetail' => $taxDetail));
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
    public function ActionGetProgressBarData($key, $date)
    {
        $response = ProgressBar::get($key, $date);
        echo json_encode($response);
    }

    /*
     * 结账情况
     */
    public function actionCondomStatus()
    {
        $this->render('status');
    }

    /**
     * 文章
     */
    public function actionBlog($id)
    {
        $model = new Blog();
        $article = $model->article($id);

        if ($article == null) {
            $this->redirect('/');
        } else {
            $this->render('blog', array('article' => $article));
        }

    }
}