<?php
/* @var $this PreparationController */
/* @var $model Preparation */

$this->breadcrumbs=array(
	'Preparations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Preparation', 'url'=>array('index')),
	array('label'=>'Create Preparation', 'url'=>array('create')),
	array('label'=>'Update Preparation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Preparation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Preparation', 'url'=>array('admin')),
);
?>

<h1>View Preparation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'order_no',
		'memo',
		'create_time',
		'status',
	),
)); ?>
