<?php
/* @var $this PreparationController */
/* @var $model Preparation */

$this->breadcrumbs=array(
	'Preparations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Preparation', 'url'=>array('index')),
	array('label'=>'Create Preparation', 'url'=>array('create')),
	array('label'=>'View Preparation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Preparation', 'url'=>array('admin')),
);
?>

<h1>Update Preparation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>