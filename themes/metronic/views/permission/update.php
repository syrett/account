<?php
/* @var $this PermissionController */
/* @var $model Permission */

$this->breadcrumbs=array(
	'Permissions'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Permission', 'url'=>array('index')),
	array('label'=>'Create Permission', 'url'=>array('create')),
	array('label'=>'View Permission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Permission', 'url'=>array('admin')),
);
?>

<h1>Update Permission <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>