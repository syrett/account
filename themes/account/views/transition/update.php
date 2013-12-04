<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->breadcrumbs=array(
	'Transitions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Transition', 'url'=>array('index')),
	array('label'=>'Create Transition', 'url'=>array('create')),
	array('label'=>'View Transition', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Transition', 'url'=>array('admin')),
);
?>

<h1>Update Transition <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>