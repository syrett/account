<?php
/* @var $this AuthPermissionController */
/* @var $model AuthPermission */

$this->breadcrumbs=array(
	'Auth Permissions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AuthPermission', 'url'=>array('index')),
	array('label'=>'Create AuthPermission', 'url'=>array('create')),
	array('label'=>'View AuthPermission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AuthPermission', 'url'=>array('admin')),
);
?>

<h1>Update AuthPermission <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>