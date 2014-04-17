<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 部门管理';
$this->breadcrumbs=array(
	'部门管理',
	'添加部门'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 部门列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row">
	<h2>部门管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="row">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>