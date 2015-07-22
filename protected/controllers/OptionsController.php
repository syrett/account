<?php

class OptionsController extends Controller
{
	public function actionIndex()
	{
//        $company = Options::model()->findAllByPk(1);
//
//        if(isset($_REQUEST['Options']['name'])){
//            $this->actionSave($company);
//        }
//		$this->render('index',array(
//            'model' => $company));
        $condom = Condom::model()->findByAttributes(['dbname'=>substr(SYSDB,8)]);
        $id = $condom->id;
        $this->redirect("http://manage.".DOMAIN."/backend/web/index.php?r=blogs%2Fdefault%2Fupdate&id=$id");
	}

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
            array('allow',
                'users'=>array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*
     * 保存公司信息
     */
    public function actionSave($company){
        $company[0]['name'] = $_REQUEST['Options']['name'];
        $company[0]->save();
    }

}