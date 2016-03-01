 <!-- 客户报表 -->
 <!-- 供应商报表 -->
<?php

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/profit.js', CClientScript::POS_HEAD);

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
	<h3><?= Yii::t('import', '客户表 供应商表') ?> </h3>
	<div class="form-group">
		<label class="control-label" for="date"><?= Yii::t('import', '请选择报表日期：') ?></label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="<?= Yii::t('import', '查看报表') ?>" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>
<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2><?= Yii::t('import', '报 表') ?></h2>
	</div>
	<div class="panel-body">
		<p class="pull-right"><?= Yii::t('import', '金额单位：元') ?></p>
	</div>

	<table class="table table-bordered table-hover">
		<thead>
		 <tr>
		 <th>&nbsp;</th>
		 <th><?= Yii::t('import', '本期借方') ?></th>
		 <th><?= Yii::t('import', '本期贷方') ?></th>
		 <th><?= Yii::t('import', '本年借方') ?></th>
		 <th><?= Yii::t('import', '本年贷方') ?></th>
		 <th><?= Yii::t('import', '余额') ?></th>
		 </tr>
		<?php echoData($data) ?>
	 </table>
</div>