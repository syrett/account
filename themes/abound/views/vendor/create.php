<?php
/* @var $this VendorController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
	'添加'
);

?>
<div class="panel panel-success">
	<div class="panel-heading">
		<h2>供应商管理</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
