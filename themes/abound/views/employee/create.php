<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 员工管理';
$this->breadcrumbs=array(
	'员工列表',
	'添加员工'
);

$this->menu=array(
	array('label'=>'<i class="icon-list-alt"></i> 员工列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn')
		  ),	
);
?>
<div class="row-fluid">
	<h2>添加新员工</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>
<div class="row-fluid">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <?php $this->renderPartial('_form', array('model' => $model, 'department_array'=>$department_array)); ?>
</div>
