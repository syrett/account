<?php

class PermissionController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function getCat(){
        return 'permission';
    }
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
            $rules[0]['actions'] = ['index', 'access'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], []);
        return $rules;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionAccess($id)
    {

        //不能修改所有者权限
        $condom = Condom::model()->findByAttributes(['dbname'=>substr(SYSDB,8)]);
        if ($condom->owner == $id) {
            Yii::app()->user->setFlash('error', '不能修改账套所有者的权限！');
            $this->redirect($this->createUrl('permission/index'), array());
            return;
        }

        //不能修改自己
        if (Yii::app()->user->id == $id) {
            Yii::app()->user->setFlash('error', '不能修改自己的权限！');
            $this->redirect($this->createUrl('permission/index'), array());
            return;
        }

        //是否在同一个组
        $user = User2::model()->findByPk(Yii::app()->user->id);
        $g_users = User2::model()->findAllByAttributes(['group' => $user->group]);
        $g_users_arr = [];
        foreach ($g_users as $g_user) {
            $g_users_arr[] = $g_user->id;
        }
        if(!in_array($id, $g_users_arr)) {
            Yii::app()->user->setFlash('error', "该用户ID不在同一组中，请检查!");
            $this->redirect($this->createUrl('permission/index'), array());
            return;
        }

        $model = AuthRelation::model()->findAllByAttributes(['user_id' => $id], ['order' => 'permission']);

        if (isset($_POST['AuthPermission'])) {
            AuthRelation::model()->deleteAllByAttributes(['user_id' => $id]);
            foreach ($_POST['AuthPermission'] as $item => $value) {
                if($value == 1){
                    $auth = new AuthRelation();
                    $auth->user_id = $id;
                    $auth->permission = $item;
                    $auth->role = '';
                    $auth->save();

                }
            }
        }
        $this->render('access', array(
            'model' => $model,
            'user_id' => $id
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $user = User2::model()->findByPk(Yii::app()->user->id);
        $criteria = new CDbCriteria;
        $criteria->compare('`group`', $user->group);
        $criteria->with = ['profiles'];
        $dataProvider = new CActiveDataProvider(User2::model(), [
            'criteria' => $criteria,
        ]);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Permission the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Permission::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Permission $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'permission-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
