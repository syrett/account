<!-- 损益表 -->
<?php

//Yii::app()->clientScript->registerCoreScript('jquery');
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
function echoData($key, $data, $name="default")
{
  if (empty($data[$key]))
    {
      echo "<th>".$name."</th>";
      echo "<td>0.00</td>";
      echo "<td>0.00</td>";
    }
  else
    {
      $arr=$data[$key];
      if($name ==="default")
        {
          echo "<th>".$arr["name"]."</th>";
        }
      else
        {
          echo "<th>".$name."</th>";
        }
        echo "<td>" .number_format($arr["sum_year"],2,".",",")."</td>";
      echo "<td>".number_format($arr["sum_month"],2,".",",")." </td>";
    }
}

?>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3><?= Yii::t('import', '损益表') ?></h3>
	<div class="form-group">
		<label class="control-label" for="date"><?= Yii::t('import', '请选择报表日期：') ?></label>
		<input type="text" data-date-format="yyyymmdd" name="date" class="form-control form-control-inline input-small date-picker" value="<?php echo isset($date)?$date:'' ?>" id="date" readonly="">
		<input type="submit" class="btn btn-primary" value="<?= Yii::t('import', '查看报表') ?>" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>
<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2><?= Yii::t('import', '损 益 表') ?></h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left"><?= Yii::t('import', '日期：') ?><?php echo $date; ?></span><?= Yii::t('import', '编制单位：') ?> <?php echo $company ?> <span class="pull-right"><?= Yii::t('import', '金额单位：元') ?></span></p>
	</div>

	<table id="profit" class="table table-bordered table-hover">
		<thead>
		 <tr>
		 <th><?= Yii::t('import', '项目') ?></th>
		 <th class="text-right"><?= Yii::t('import', '本年累计发生额') ?></th>
             <th class="text-right"><?= Yii::t('import', '本期发生额') ?></th>
		 </tr>
		</thead>
		 <tr>
		 <?php echoData(55, $data, Yii::t('import', "一、营业收入")) ?>
		 </tr>
		 <tr>
		 <?php echoData(61, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(62, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(64, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(65, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(63, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(66, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(57, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(58, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData("trading_profit", $data, Yii::t('import', "二、营业利润")) ?>
		 </tr>
		 <tr>
		 <?php echoData(60, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(67, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData("profit_sum", $data, Yii::t('import', "三、利润总额")) ?>
		 </tr>
		 <tr>
		 <?php echoData(68, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData("net_profit", $data, Yii::t('import', "四、净利润")) ?>
		 </tr>
		 <tr>
		 <?php echoData("net_profit", $data, Yii::t('import', "其中：归属于母公司所有者的净利润")) ?>
		 </tr>
		 <tr>
		 <?php echoData(70, $data, Yii::t('import', "加：年(期)初未分配利润")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "其他转入")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "减：提取法定盈余公积")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "提取储备基金")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "提取企业发展基金")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "提取职工奖励及福利基金")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "提取任意盈余公积")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "应付现金股利(利润)")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "其中：分配控股母公司现金股利")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "转作股本的普通股股利")) ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, Yii::t('import', "盈余公积补亏")) ?>
		 </tr>
		 <tr>
		 <?php echoData("undistributed_profit", $data, Yii::t('import', "五、未分配利润")) ?>
		 </tr>
		 </td>
	</table>
</div>
<div class="alert">
	<a id="dlink"  style="display:none;"></a>
	<?php
	echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
	if ($date != ""){
		$d = date('Y-m',strtotime($date));
		$excel_name = Yii::t('import', "损益表-").$d.".xls";
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