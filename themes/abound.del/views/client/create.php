<?php
$this->pageTitle=Yii::app()->name . ' - 客户管理';
$this->breadcrumbs=array(
	'客户管理',
	'添加'
);
?>
<div class="panel panel-default voucher form">
    <!-- Default panel contents -->
    <div class="panel-heading">
		<h2>客户管理</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
