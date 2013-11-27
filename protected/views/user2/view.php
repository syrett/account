<?php
/* @var $this User2Controller */
/* @var $model User2 */

$this->breadcrumbs=array(
	'User2s'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List User2', 'url'=>array('index')),
	array('label'=>'Create User2', 'url'=>array('create')),
	array('label'=>'Update User2', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete User2', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User2', 'url'=>array('admin')),
);
?>

<h1>View User2 #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'email',
	),
)); ?>
