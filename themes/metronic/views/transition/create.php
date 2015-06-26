<?php
require_once(dirname(__FILE__) . '/../viewfunctions.php');

//Yii::app()->clientScript->registerCoreScript('jquery');
//Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.css');
//
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui.min.css');
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/theme.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/transition.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit','ComponentsPickers.init();', CClientScript::POS_READY);

$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'录入凭证',
	'添加'
);

?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">录入凭证</span>
		</div>
		<div class="actions">
		    <?php
				echo CHtml::link('<i class="fa fa-bank"></i> 导入银行交易', array('bank'), array('class' => 'btn btn-circle btn-default btn-sm'));
				echo "\n";
				echo CHtml::link('<i class="fa fa-money"></i> 导入现金交易', array('cash'), array('class' => 'btn btn-circle btn-default btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
