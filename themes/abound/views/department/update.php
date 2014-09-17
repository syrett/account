<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 部门管理';
$this->breadcrumbs=array(
	'部门管理',
);

?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2>部门管理</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
