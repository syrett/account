<?php
/* @var $this VendorController */
/* @var $model Vendor */

$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vendor', 'url'=>array('index')),
	array('label'=>'Manage Vendor', 'url'=>array('admin')),
);
?>

<h1>Create Vendor</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>