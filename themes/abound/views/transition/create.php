<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'录入凭证',
	'添加'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 凭证列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-default')
		  ),	
);
?>
<div class="operations">
<?php $this->widget('zii.widgets.CMenu', array(
	/*'type'=>'list',*/
	'encodeLabel'=>false,
	'items'=>$this->menu,
	'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
	));
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<div class="panel panel-success">
	<div class="panel-heading">
	<h2>录入凭证</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
