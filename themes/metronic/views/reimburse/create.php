<?php
/* @var $this ReimburseController */
/* @var $model Reimburse */

$this->breadcrumbs=array(
	'Reimburses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Reimburse', 'url'=>array('index')),
	array('label'=>'Manage Reimburse', 'url'=>array('admin')),
);
?>

<h1>Create Reimburse</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>