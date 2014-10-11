<!-- 项目报表 -->
<?php
Yii::import('ext.select2.Select2');
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
        echo "</tr>";                                                   
      }
}
?>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3>项目报表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<label class="control-label" for="type">类别：</label>
<?php
  $this->widget('Select2', array(
                                 'name' => 'type',
                                 'value' => $type,
                                 'data' => array(1=>"收入",2=>"成本"),
                                 ));
?>		
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>

<div <?php if(!$data) echo 'style="display:none"'; ?>" class="panel panel-default">
	<div class="panel-heading">
		<h2>项 目 报 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo date('Y-m-d',strtotime($date)); ?></span>&nbsp;&nbsp;<span class="pull-right">金额单位：元</span></p>
	</div>
	<table id="project" class="table table-bordered table-hover">
		<thead>
		 <tr>
		 <th>&nbsp;</th>
		 <th>本期借方</th>
		 <th>本期贷方</th>
		 <th>本年借方</th>
		 <th>本年贷方</th>
		 <th>余额</th>
		 </tr>
		</thead>
		<?php echoData($data) ?>
	</table>
</div>
<div>
    <a id="dlink"  style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    $d = date('Y-m',strtotime($date));
    if ($subject_name != ""){
        $d = date('Y-m',strtotime($date));
        $excel_name = "项目表-".$subject_name." ".$d.".xls";
        ?>

        <input type="hidden" name="data" id="data" value="" />
        <input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
        <?php
        echo "<input type='button' onclick='tableToExcel()'  value='导出'>";
    }
    echo CHtml::endForm();
    ?>
</div>
