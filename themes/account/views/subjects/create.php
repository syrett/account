<?php
/* @var $this SubjectsController */
/* @var $model Subjects */

$this->breadcrumbs=array(
	'Subjects'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Subjects', 'url'=>array('index')),
	array('label'=>'Manage Subjects', 'url'=>array('admin')),
);
?>

<h1>Create Subjects</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>