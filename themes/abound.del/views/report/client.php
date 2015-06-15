<!-- 客户报表 -->
<?php

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profit.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/excel_export.js', CClientScript::POS_HEAD);
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
        echo "<tr>";                                                   
      }
}
?>

<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3>客 户 表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<?php echo CHtml::endForm(); ?>
	<p>&nbsp;</p>
</div>

<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2>客 户 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo $date; ?></span> 编制单位：<?php echo $company ?><span class="pull-right">金额单位：元</span></p>
	</div>
	<table id="client" class="table table-bordered table-hover">
	 <tr>
	 <th>&nbsp;</th>
	 <th>本期借方</th>
	 <th>本期贷方</th>
	 <th>本年借方</th>
	 <th>本年贷方</th>
	 <th>余额</th>
	 </tr>
     <?php echoData($data) ?>
	 </table>
</div>
<div class="alert">
    <a id="dlink"  style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
        $d = date('Y-m',strtotime($date));
        $excel_name = "客户表 ".$d.".xls";
        ?>

        <input type="hidden" name="data" id="data" value="" />
        <input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
		<p class="text-right">
		<?php
		echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span> 导出</button>';
	}
	echo CHtml::endForm();
	?>
	</p>
</div>
