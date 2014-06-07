<!-- 损益表 -->
<?php

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profit.js', CClientScript::POS_HEAD);

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
      echo "<td>0</td>";
      echo "<td>0</td>";
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
      echo "<td>".$arr["sum_month"]." </td>";
      echo "<td>" .$arr["sum_year"]."</td>";
    }
}

?>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3>损益表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>
<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2>损 益 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo date('Y-m-d',$date); ?></span> 编制单位：<?php echo $company ?> <span class="pull-right">金额单位：元</span></p>
	</div>

	<table class="table table-bordered table-hover">
		<thead>
		 <tr>
		 <th>项目</th>
		 <th>本期数</th>
		 <th>本年累计同期数</th>
		 </tr>
		</thead>
		 <tr>
		 <?php echoData(55, $data, "一、营业收入") ?>
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
		 <?php echoData(59, $data) ?>
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
		 <?php echoData("trading_profit", $data, "二、营业利润") ?>
		 </tr>
		 <tr>
		 <?php echoData(60, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData(67, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData("profit_sum", $data, "三、利润总额") ?>
		 </tr>
		 <tr>
		 <?php echoData(68, $data) ?>
		 </tr>
		 <tr>
		 <?php echoData("net_profit", $data, "四、净利润") ?>
		 </tr>
		 <tr>
		 <?php echoData("net_profit", $data, "其中：归属于母公司所有者的净利润") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "加：年初未分配利润") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "其他转入") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "减：提取法定盈余公积") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "提取储备基金") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "提取企业发展基金") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "提取职工奖励及福利基金") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "提取任意盈余公积") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "应付现金股利(利润)") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "其中：分配控股母公司现金股利") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "转作股本的普通股股利") ?>
		 </tr>
		 <tr>
		 <?php echoData(0, $data, "盈余公积补亏") ?>
		 </tr>
		 <tr>
		 <?php echoData("undistributed_profit", $data, "五、未分配利润") ?>
		 </tr>
		 </td>
	</table>
</div>