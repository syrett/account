<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工列表',
	'添加员工'
);

?>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2>添加员工</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model, 'department_array'=>$department_array)); ?>
</div>
