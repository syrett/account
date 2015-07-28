<?php
/* @var $this CostController */
/* @var $model Cost */

$this->breadcrumbs=array(
	'Costs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cost', 'url'=>array('index')),
	array('label'=>'Manage Cost', 'url'=>array('admin')),
);
?>

<h1>Create Cost</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>