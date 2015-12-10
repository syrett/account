<?php
/* @var $this PermissionController */
/* @var $model Permission */

$this->breadcrumbs=array(
	'Permissions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Permission', 'url'=>array('index')),
	array('label'=>'Manage Permission', 'url'=>array('admin')),
);
?>

<h1>Create Permission</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>