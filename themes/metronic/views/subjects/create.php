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

?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">科目表管理</span>
		</div>
		<div class="actions">
		    <?php
				echo CHtml::link('<i class="fa fa-edit"></i> 科目列表', array('admin'), array('class' => 'btn btn-circle btn-primary btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
	</div>
</div>
