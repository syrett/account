<?php
/* @var $this PermissionController */
/* @var $model Permission */

$this->breadcrumbs=array(
	'Permissions'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Permission', 'url'=>array('index')),
	array('label'=>'Create Permission', 'url'=>array('create')),
	array('label'=>'Update Permission', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Permission', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Permission', 'url'=>array('admin')),
);
?>

<h1>View Permission #<?php echo $model->id; ?></h1>

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
