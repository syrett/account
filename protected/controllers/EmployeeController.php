<?php

class EmployeeController extends Controller
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
    public function accessRules()
    {
        $rules = parent::accessRules();
        if ($rules[0]['actions'] == ['manage'])
            $rules[0]['actions'] = ['admin', 'index', 'create', 'update', 'view', 'delete', 'createemployee', 'salary', 'createmultiple'];
        $rules[0]['actions'] = array_merge($rules[0]['actions'], ['admin']);
        return $rules;
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
        $model = new Employee;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $department_array = $model->listDepartment();
        $this->render('create', array(
            'model' => $model,
            'department_array' => $department_array,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreatemultiple()
    {
        Yii::import('ext.phpexcel.PHPExcel.PHPExcel_IOFactory');
        if (Yii::app()->request->isPostRequest) {
            //上传附件查看
            if ($_FILES['attachment'] != '' && file_exists($_FILES['attachment']['tmp_name'])) {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['attachment']['tmp_name']);
                $list = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                //去除第一行
                array_shift($list);
                foreach ($list as $item) {
                    $sheetData[] = Employee::getSheetData($item);
                }
            } elseif ($_FILES['attachment']['name'] == '') {
                $lists = $_POST['Employee'];
                foreach ($lists as $item) {
                    $employee = new Employee();
                    $employee->attributes = $item;
                    $employee->base = str_replace(',', '', $employee->base);
                    if (!$employee->save())
                        $sheetData[] = $employee;
                }
                if (empty($sheetData)) {
                    Yii::app()->user->setFlash('success', "添加成功!");
                } else
                    Yii::app()->user->setFlash('error', "添加失败!");

            }
        }

        if (empty($sheetData)) {
            $sheetData[] = Employee::getSheetData('');
        }

        $this->render('import', ['sheetData' => $sheetData]);
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

        if (isset($_POST['Employee'])) {
            $model->attributes = $_POST['Employee'];
            if ($model->save())
                $this->redirect(array('admin'));
        }

        $dataProvider = $model->search();
        $department_array = $model->listDepartment();
        $this->render('update', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'department_array' => $department_array,
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

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->redirect(['admin']);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $model->attributes = $_GET['Employee'];

        $dataProvider = $model->search();
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Employee the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Employee $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /*
     * 保存员工
     */
    public function actionCreateemployee()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Employee();
            $data['name'] = $_POST['name'];
            $data['department_id'] = $_POST['department'];
            $a = $model->model()->findByAttributes($data);
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
     * 员工工资
     */
    public function actionSalary()
    {

    }
}
