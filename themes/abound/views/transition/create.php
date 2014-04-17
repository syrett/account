<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'凭证管理',
	'添加'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 全部凭证列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row-fluid">
	<h2>凭证管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>
<div class="row-fluid">
        <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>