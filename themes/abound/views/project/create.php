<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 项目管理';
$this->breadcrumbs=array(
	'项目管理',
	'添加项目'
);

$this->menu=array(
	array('label'=>'<i class="icon-list-alt"></i> 项目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn')
		  ),	
);
?>
<div class="row-fluid">
	<h2>项目管理</h2>
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

            <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>