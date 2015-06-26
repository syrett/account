<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'导入凭证',
);
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/import.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/filechoose.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/select2/select2.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/table-managed.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit','ComponentsPickers.init();', CClientScript::POS_READY);
$cs->registerScript('ChartsFlotchartsInitPie','TableManaged.init();', CClientScript::POS_READY);

$bank_money = '';
$bank_money_icon = 'bank';
if ($type == 'bank') 
{
	$bank_money = 'cash';
}else{
	$bank_money = 'bank';
} 

if ($bank_money == 'cash') 
	$bank_money_icon = 'money';
?>

<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">导入<?= Yii::t('import', $type) ?>交易</span>
		</div>
		<div class="actions">
			<?php echo CHtml::link('<i class="glyphicon glyphicon-search"></i> 已导入数据', array('/' . $type), array('class' => 'btn btn-circle btn-default')); ?>
			<input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate() ?>">
		    <?php
				echo CHtml::link('<i class="fa fa-'.$bank_money_icon.'"></i> 导入'.Yii::t('import', $bank_money).'交易', array($bank_money), array('class' => 'btn btn-circle btn-info btn-sm'));
				echo "\n";
				echo CHtml::link('<i class="fa fa-edit"></i> 手动录入凭证', array('create'), array('class' => 'btn btn-circle btn-default btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
	?>
	<?php
	$this->renderPartial('_import', array('type'=>$type,'sheetData' => $sheetData)); ?>
	</div>
</div>
