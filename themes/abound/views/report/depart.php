<!-- 部门报表 -->
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
function echoData($data, $subjects)
{
  $column = array();
    echo "<tr>";
    echo "<th>&nbsp;</th>";
  foreach($subjects as $sbj_id=>$sbj_name){
    echo "<th>".$sbj_name."</th>";
    $column[]=$sbj_id;
  }
  echo "</tr>";

  $column_len = count($column);
 
    foreach($data as $k=>$depart)
      {

        echo "<tr>";
        echo "<td>".$depart["name"]."</td>";
        for($i=0;$i<$column_len;$i++){
          if(isset($depart[$column[$i]])){
            $balance = $depart[$column[$i]];
          }else{
            $balance = 0;
          }
        echo "<td>".number_format($balance, 2)."</td>";
        }
        echo "</tr>";                                                   
      }
}
?>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3>部 门 表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
        <label class="control-label" for="sbj_id">选择科目</label>
        <?php
        $this->widget('Select2', array(
            'name' => 'sbj_id',
            'value' => $subject_id,
            'data' => $list,
        ));
        ?>
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>

<div <?php if(!$data) echo 'style="display:none"'; ?> class="panel panel-default">
	<div class="panel-heading">
		<h2>部 门 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo $date; ?></span> 编制单位：<?php echo $company ?> <span class="pull-right">金额单位：元</span></p>
	</div>
	<table id="depart" class="table table-bordered table-hover">
		<?php echoData($data, $subjects) ?>
    </table>
</div>
<div>
    <a id="dlink"  style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');

    if ($subject_id != ""){
        $subject_name = $list[$subject_id];
        $d = date('Y-m',strtotime($date));
        $excel_name = "部门表-".$subject_name." ".$d.".xls";
        ?>

        <input type="hidden" name="data" id="data" value="" />
        <input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
        <?php
        echo "<input type='button' onclick='tableToExcel()'  value='导出'>";
    }
    echo CHtml::endForm();
    ?>
</div>
