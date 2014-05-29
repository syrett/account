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
<div class="row">
  <?php $this->widget('zii.widgets.CMenu', array(
	/*'type'=>'list',*/
	'encodeLabel'=>false,
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
	));
	?>
</div>
<p>&nbsp;</p>
<div class="panel panel-success">
	<div class="panel-heading">
	<h2>记 账 凭 证</h2>	
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
