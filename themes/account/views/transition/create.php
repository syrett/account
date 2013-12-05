<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->breadcrumbs=array(
	'Transitions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Transition', 'url'=>array('index')),
	array('label'=>'Manage Transition', 'url'=>array('admin')),
);
?>

<h1>Create Transition</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>