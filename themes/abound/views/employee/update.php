<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工管理',
);

$this->menu=array(
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加员工',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 员工列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),	
);
?>
<div class="row">
	<h2>员工管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="row">
            <?php $this->renderPartial('_form', array('model' => $model,'department_array'=>$department_array)); ?>
</div>
