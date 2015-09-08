<?php
/* @var $this PreparationController */
/* @var $model Preparation */

$this->breadcrumbs=array(
	'Preparations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Preparation', 'url'=>array('index')),
	array('label'=>'Manage Preparation', 'url'=>array('admin')),
);
?>

<h1>Create Preparation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>