<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
	Yii::t('import', 'BANK')=>array('index'),
);

$cs = Yii::app()->clientScript;

$cs->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bank-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
$cs->registerScript('ChartsFlotchartsInitPie','TableManaged.init();', CClientScript::POS_READY);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/select2/select2.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/table-managed.js', CClientScript::POS_END);

?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">交易信息修改</span>
		</div>
		<div class="actions">
            <?php echo CHtml::link('<i class="glyphicon glyphicon-search"></i> 已导入数据', array('/bank'), array('class' => 'btn btn-circle btn-default')); ?>
		    <a href="<?= $this->createUrl('transition/bank') ?>"  class="btn btn-circle btn-info btn-sm"><i class="fa fa-bank"></i> 导入银行交易</a>
		    <a href="<?= $this->createUrl('transition/cash') ?>"  class="btn btn-circle btn-info btn-sm"><i class="fa fa-money"></i> 导入现金交易</a>
		    <a href="<?= $this->createUrl('transition/create') ?>"  class="btn btn-circle btn-default btn-sm"><i class="fa fa-edit"></i> 手动录入凭证</a>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
	<?php

	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}

	$this->renderPartial('_form', array('model' => $model, 'sheetData'=> $sheetData)); ?>
	</div>
</div>