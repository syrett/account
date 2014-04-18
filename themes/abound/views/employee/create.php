<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工列表',
	'添加员工'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 员工列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row">
	<h2>添加员工</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
			));
			?>
</div>
<div class="row">
    <?php $this->renderPartial('_form', array('model' => $model, 'department_array'=>$department_array)); ?>
</div>
