 <!-- 供应商报表 -->
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

<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
<div class="alert alert-info">
	<h3>供应商报表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
</div>
<?php echo CHtml::endForm(); ?>

<div style="display:<?php if($data=='') echo 'none';?>" class="panel panel-default">
	<div class="panel-heading">
		<h2>供 应 商 报 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo $date ?></span> <span class="pull-right">金额单位：元</span></p>
	</div>

	<table class="table table-bordered">
		<thead>
		 <tr>
		 <th>供应商</th>
		 <th>本期借方</th>
		 <th>本期贷方</th>
		 <th>本年借方</th>
		 <th>本年贷方</th>
		 <th>余额</th>
		 </tr>
		</thead>
<?php
    foreach($data as $ti)
    {
      echo "<tr>";
      echo "<td>".$ti["company"]."</td>";
      echo "<td>".$ti["month_debit"]."</td>";
      echo "<td>".$ti["month_credit"]."</td>";
      echo "<td>".$ti["year_debit"]."</td>";
      echo "<td>".$ti["year_credit"]."</td>";
      echo "<td>".$ti["balance"]."</td>";
      echo "</tr>";
    }
?>

     </table>
</div>
