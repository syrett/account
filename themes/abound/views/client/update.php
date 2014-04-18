<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 客户管理';
$this->breadcrumbs=array(
	'客户管理',
);

$this->menu=array(
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加客户',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 客户列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),	
);
?>
<div class="row">
	<h2>客户管理</h2>
	<?php $this->widget('zii.widgets.CMenu', array(
		/*'type'=>'list',*/
		'encodeLabel'=>false,
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
		));
		?>
</div>

<div class="row">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>

