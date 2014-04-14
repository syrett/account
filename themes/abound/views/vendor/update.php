<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 供应商管理';
$this->breadcrumbs=array(
	'供应商管理',
);

$this->menu=array(
		array('label'=>'<i class="icon-plus-sign"></i> 添加供应商',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn')
		  ),
	array('label'=>'<i class="icon-list-alt"></i> 供应商列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn')
		  ),	
);
?>
<div class="row-fluid">
	<h2>供应商管理</h2>
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