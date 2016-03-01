<!-- 项目报表 -->
<?php
Yii::import('ext.select2.ESelect2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/profit.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit','ComponentsPickers.init();', CClientScript::POS_READY);
?>
<style>
.ui-datepicker table{
    display: none;
}
</style>

<?php
function echoData($data)
{
    foreach($data as $ti)
      {
        echo "<tr>";
        echo "<td>".$ti["company"]."</td>";
        echo "<td>".number_format($ti["month_debit"], 2)."</td>";
        echo "<td>".number_format($ti["month_credit"], 2)."</td>";
        echo "<td>".number_format($ti["year_debit"], 2)."</td>";
        echo "<td>".number_format($ti["year_credit"], 2)."</td>";
        echo "<td>".number_format($ti["balance"], 2)."</td>";
        echo "</tr>";                                                   
      }
}
?>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3><?= Yii::t('import', '项目报表') ?></h3>
	<div class="form-group">
		<label class="control-label" for="date"><?= Yii::t('import', '请选择报表日期：') ?></label>
		<input type="text" data-date="201210" data-date-format="yyyymm" data-date-viewmode="years" data-date-minviewmode="months" name="date" class="form-control form-control-inline input-small date-picker" value="<?php echo isset($date)?$date:'' ?>" id="date" readonly="">
		<label class="control-label" for="type"><?= Yii::t('import', '类别：') ?></label>
<?php
  $this->widget('ESelect2', array(
                                 'name' => 'type',
                                 'value' => $type,
                                 'data' => array(1=>Yii::t('import', "收入"),2=>Yii::t('import', "成本")),
                                 ));
?>		
		<input type="submit" class="btn btn-primary" value="<?= Yii::t('import', '查看报表') ?>" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>

<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2><?= Yii::t('import', '项 目 报 表') ?></h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left"><?= Yii::t('import', '日期：') ?><?php echo $date; ?></span><?= Yii::t('import', '编制单位：') ?><?php echo $company ?><span class="pull-right"><?= Yii::t('import', '金额单位：元') ?></span></p>
	</div>
	<table id="project" class="table table-bordered table-hover">
		<thead>
		 <tr>
		 <th>&nbsp;</th>
		 <th class="text-right"><?= Yii::t('import', '本期借方') ?></th>
		 <th class="text-right"><?= Yii::t('import', '本期贷方') ?></th>
		 <th class="text-right"><?= Yii::t('import', '本年借方') ?></th>
		 <th class="text-right"><?= Yii::t('import', '本年贷方') ?></th>
		 <th class="text-right"><?= Yii::t('import', '余额') ?></th>
		 </tr>
		</thead>
		<?php echoData($data) ?>
	</table>
</div>
<div class="alert">
	<a id="dlink"  style="display:none;"></a>
	<?php
	echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
	if ($date != ""){
		$d = date('Y-m',strtotime($date));
		$excel_name = Yii::t('import', "项目表-").$d.".xls";
		?>
		<input type="hidden" name="data" id="data" value="" />
		<input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
		<p class="text-right">
		<?php
		echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span>'.Yii::t('import', '导出').'</button>';
	}
	echo CHtml::endForm();
	?>
	</p>
</div>
