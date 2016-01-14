<?php
/* @var $this AuthPermissionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Auth Permissions',
);

$this->menu=array(
	array('label'=>'Create AuthPermission', 'url'=>array('create')),
	array('label'=>'Manage AuthPermission', 'url'=>array('admin')),
);
?>

<h1>Auth Permissions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
