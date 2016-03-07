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
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/filechoose.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit','ComponentsPickers.init();', CClientScript::POS_READY);

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
		<span class="font-green-sharp"><?= Yii::t('import', '导入') ?> <?= Yii::t('import', LFSModel::typeName($type)) ?></span>
		</div>
		<div class="actions">
			<?php echo CHtml::link('<i class="glyphicon glyphicon-search"></i> '. Yii::t('import', '已导入数据'), array('/' . $type), array('class' => 'btn btn-circle btn-default')); ?>
			<input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate('post') ?>">
		    <?php
//				echo CHtml::link('<i class="fa fa-'.$bank_money_icon.'"></i> 导入'.Yii::t('import', $bank_money), array($bank_money), array('class' => 'btn btn-circle btn-info btn-sm'));
//				echo "\n";
				echo CHtml::link('<i class="fa fa-edit"></i> '. Yii::t('import', '手动录入凭证'), array('create'), array('class' => 'btn btn-circle btn-default btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
		</div>
	</div>
    <div id="portlet-info" class="portlet-info">

    </div>
	<div class="portlet-body">
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
    $vip = 1;
    if($this->checkVIP()){
        $this->renderPartial('_import_'.$type, array('type'=>$type,'sheetData' => $sheetData, 'info' => $info, 'option' => isset($option)?$option:''));
        $vip = 2;
    }
    else{
        $this->renderPartial('_import', array('type'=>$type,'sheetData' => $sheetData, 'info' => $info, 'option' => isset($option)?$option:''));
    }
    ?>
	</div>
</div>
<input id="vip" type="hidden" value="<?= $vip?>" >
<input id="type" type="hidden" value="<?= $this->createUrl(
    '/'. $type. '/type'
) ?>">
<input id="user-bank" type="hidden" value="<?= $this->createUrl(
    '/user/savebank'
) ?>">
<input id="option" type="hidden" value="<?= $this->createUrl(
    '/'.$type .'/option'
) ?>">
<input id="employee" type="hidden" value="<?= $this->createUrl(
    '/employee/createemployee'
) ?>">
<input id="new-url" type="hidden" value="<?= $this->createUrl(
    '/subjects/createsubject'
) ?>">
<input id="new-vendor" type="hidden" value="<?= $this->createUrl(
    '/vendor/createvendor'
) ?>">
<input id="get-vendor" type="hidden" value="<?= $this->createUrl(
    '/vendor/getvendor'
) ?>">
<input id="new-client" type="hidden" value="<?= $this->createUrl(
    '/client/createclient'
) ?>">
<input id="get-client" type="hidden" value="<?= $this->createUrl(
    '/client/getclient'
) ?>">
<input id="get-usefor" type="hidden" value="<?= $this->createUrl(
    '/subjects/getusefor'
) ?>">
<input id="gen-porder" type="hidden" value="<?= $this->createUrl(
    '/preparation/create'
) ?>">
<input id="get-subject" type="hidden" value="<?= $this->createUrl(
    '/subjects/matchsubject'
) ?>">
<input id="get-porder" type="hidden" value="<?= $this->createUrl(
    '/preparation/getporder'
) ?>">
<input id="data" type="hidden" value="">
<input id="subject" type="hidden" value="">
<input id="item_id" type="hidden" value="">
<input id="action" type="hidden" value="<?=$type?>">