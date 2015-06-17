<?php
/* @var $this CashController */
/* @var $model Cash */

$this->breadcrumbs=array(
	'Cashes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cash', 'url'=>array('index')),
	array('label'=>'Manage Cash', 'url'=>array('admin')),
);
?>

<h1>Create Cash</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>