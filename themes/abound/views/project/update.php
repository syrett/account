<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 项目管理';
$this->breadcrumbs=array(
	'项目管理',
);
?>
<div class="panel panel-success voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2>项目管理</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
