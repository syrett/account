<?php
/* @var $this AuthPermissionController */
/* @var $model AuthPermission */

$this->breadcrumbs=array(
	'Auth Permissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AuthPermission', 'url'=>array('index')),
	array('label'=>'Manage AuthPermission', 'url'=>array('admin')),
);
?>

<h1>Create AuthPermission</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>