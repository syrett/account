<?php

class EmployeeController extends Controller
{
	public function actionIndex()
	{
            $sql = "select * from employee";

      $First = Employee::model()->findAllBySql($sql);
      
      echo "<pre>";
      var_dump($First);
      echo "</pre>";
      foreach($First as $row) { 
        $array = array(
                       'id' => $row['id'],
                       'name' => $row['name']
                       );

        echo json_encode($row);
        echo json_encode($array);
        echo "<br />";  
        echo $row['id'] . " " . $row['name'];
        echo "<br />";  
      }

        /*		$dataProvider=new CActiveDataProvider('Employee');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            ));*/
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}