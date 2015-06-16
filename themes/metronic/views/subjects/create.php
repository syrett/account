<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.css');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/admin/layout/scripts/subjects.js', CClientScript::POS_END);

$this->pageTitle=Yii::app()->name . ' - 会计科目表管理';
$this->breadcrumbs=array(
	'会计科目表管理',
	'添加'
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 会计科目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
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
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>会计科目管理</h2>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
	</div>
</div>
