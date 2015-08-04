<?php

class OptionsController extends Controller
{
	public function actionIndex()
	{
        $condom = Condom::model()->findByAttributes(['dbname'=>substr(SYSDB,8)]);
        $id = $condom->id;
        $this->redirect("http://manage.".DOMAIN."/backend/web/index.php?r=blogs%2Fdefault%2Fupdate&id=$id");
	}

    public function actionSetting()
    {
        $company = Options::model()->findAll();

        if(isset($_REQUEST['Options'])){
            $options = $_REQUEST['Options'];
            foreach($options as $key=>$item){
                $option = Options::model()->findByPk($key);
                if($option==null)
                    $option = new Options();
                $option->attributes = $item;
                $option->save();
            }
            $this->refresh();
        }
		$this->render('index',array(
            'model' => $company));
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
}