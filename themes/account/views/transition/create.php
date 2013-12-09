<?php
/* @var $this TransitionController */
/* @var $model Transition */


$this->menu=array(
	array('label'=>'List Transition', 'url'=>array('index')),
	array('label'=>'Manage Transition', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>