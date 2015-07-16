<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    /*
     * 补全4位
     */
    public function AddZero($num){
        return substr(strval($num + 10000), 1, 4);
    }

    /*
     * 账套权限检验
     */
    public function beforeAction($action){
        //以下controller才执行权限检验
        $controllers = ['bank','cash','purchase','product','client','department','employee','options','post','project','report','subjects','transition','vendor'];
        if(!in_array($this->uniqueId, $controllers) || User::model()->superAdmin())
            return true;
        else{
            $dbname = substr(SYSDB, 8);
            $test = ['test','account'];  //均为测试账套，所有人都有权限
            if(in_array($dbname,$test))
                return true;
            $cri = new CDbCriteria;
            $cri->compare('dbname',$dbname);
            $con = Condom::model()->find($cri);
            if(!$con)   //不存在账套
                throw new CHttpException(403, '你没有权限操作此账套，请从管理页重新进入账套');

            $cri = new CDbCriteria;
            $cri->compare('user_id',Yii::app()->user->id);
            $cri->compare('condom_id',$con->id);
            $acc = Access::model()->find($cri);
            if($acc)
                return true;
            else
                throw new CHttpException(403, '你没有权限操作此账套，请从管理页重新进入账套');
        }
    }

    /**
     * 是否VIP
     */
    public function checkVIP(){
        return User2::model()->checkVIP()?true:false;
    }

    /*
     * 凭证可选日期,视图transitiondate为已过账日期，condomdate为已完全成功结账日期
     */
    public function getTransitionDate($type){
        if($type=='post')
            $table = 'transitiondate';
        if($type=='end')
            $table = 'condomdate';
        $sql = "select date from $table";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $date =  $command->queryRow();
        if($date['date']==null)
            return ['date'=>Condom::model()->getStartTime()];
        else
            return $date;
    }

}