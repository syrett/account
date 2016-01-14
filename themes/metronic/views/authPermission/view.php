<?php
/* @var $this AuthPermissionController */
/* @var $model AuthPermission */

$this->breadcrumbs=array(
	'Auth Permissions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AuthPermission', 'url'=>array('index')),
	array('label'=>'Create AuthPermission', 'url'=>array('create')),
	array('label'=>'Update AuthPermission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AuthPermission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AuthPermission', 'url'=>array('admin')),
);
?>

<h1>View AuthPermission #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'category',
		'name',
		'description',
		'form',
		'options',
		'default_value',
		'rule',
		'sort_num',
	),
)); ?>
