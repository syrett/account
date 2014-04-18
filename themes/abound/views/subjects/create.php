<?php
$this->pageTitle=Yii::app()->name . ' - 会计科目表管理';
$this->breadcrumbs=array(
	'会计科目表管理',
	'添加'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 会计科目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row">
	<h2>会计科目表管理</h2>
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
