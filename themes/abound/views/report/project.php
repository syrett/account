 <!-- 项目报表 -->
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
<?php echo CHtml::beginForm('','post',array('class'=>'form-inline','role'=>'form')); ?>
	<h3>项目表</h3>
	<div class="form-group">
		<label for="date">请选择日期：</label>
		<input type="text" name="date" id="date" class="form-control" value="<?php echo isset($date)?$date:'' ?>" readonly/>
	</div>
	<div class="form-group">
			<label for="type">类别：</label>
            <select name="type" class="form-control">
            	<option value="1">收入</option>
            	<option value="2">成本</option>
            </select>
			<input class="btn btn-primary" type="submit" value="查看报表" />
	</div>
<?php echo CHtml::endForm(); ?>
</div>

<?php
 if ($data) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<h2>项 目 表</h2>
  </div>
  
  <table class="table table-bordered">
	<thead>
		 <tr>
		 <td>项目名称</td>
		 <td>本期借方</td>
		 <td>本期贷方</td>
		 <td>本年借方</td>
		 <td>本年贷方</td>
		 <td>余额</td>
		 </tr>
	 </thead>
    <?php echoData($data); ?>
   </table>
</div>
<?php
}
?>





