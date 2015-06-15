<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 部门管理';
$this->breadcrumbs=array(
	'Departments',
);

$this->menu=array(
	array('label'=>'Create Department', 'url'=>array('create')),
	array('label'=>'Manage Department', 'url'=>array('admin')),
);
?>
<div class="page-header">
	<h1>Departments</h1>
</div>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
