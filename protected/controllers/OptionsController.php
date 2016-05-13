<?php

class OptionsController extends Controller
{
	public function actionIndex()
	{
        $condom = Condom::model()->findByAttributes(['dbname'=>substr(SYSDB,8)]);
        $id = $condom->id;
        $this->redirect("http://backend.".DOMAIN."/condoms/default/update?id=$id");
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
                $option->entry_subject = $key;
                $option->attributes = $item;
                $option->save();
            }

            //保存企业所得税征收类型
            if(isset($_REQUEST['income_t'])){
                $condom = Condom::getCondom();
                $condom->income_t = $_REQUEST['income_t'];
                $condom->save();
            }
            $this->refresh();
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }
}