<?php
// 客户表

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

<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
<div class="alert alert-info">
	<h3>客 户 表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
</div>
<?php echo CHtml::endForm(); ?>

<?php
 if ($data) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<h2>客 户 表</h2>
  </div>
  
  <table class="table table-bordered">
	<thead>
		 <tr>
		 <td>&nbsp;</td>
		 <td>本期借方</td>
		 <td>本期贷方</td>
		 <td>本年借方</td>
		 <td>本年贷方</td>
		 <td>余额</td>
		 </tr>
	 </thead>
<?php
    foreach($data as $ti)
    {
      echo "<tr>";
      echo "<td>".$ti["id"]."</td>";
      echo "<td>".$ti["month_debit"]."</td>";
      echo "<td>".$ti["month_credit"]."</td>";
      echo "<td>".$ti["year_debit"]."</td>";
      echo "<td>".$ti["year_credit"]."</td>";
      echo "<td>".$ti["balance"]."</td>";
      echo "<tr>";                                                   
    }
?>
   </table>
</div>
<?php
}
?>
