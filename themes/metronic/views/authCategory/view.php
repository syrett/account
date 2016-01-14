<?php
/* @var $this AuthCategoryController */
/* @var $model AuthCategory */

$this->breadcrumbs=array(
	'Auth Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AuthCategory', 'url'=>array('index')),
	array('label'=>'Create AuthCategory', 'url'=>array('create')),
	array('label'=>'Update AuthCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AuthCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AuthCategory', 'url'=>array('admin')),
);
?>

<h1>View AuthCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'type',
		'sort_num',
	),
)); ?>
