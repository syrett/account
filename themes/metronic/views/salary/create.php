<?php
/* @var $this SalaryController */
/* @var $model Salary */

$this->breadcrumbs=array(
	'Salaries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Salary', 'url'=>array('index')),
	array('label'=>'Manage Salary', 'url'=>array('admin')),
);
?>

<h1>Create Salary</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>