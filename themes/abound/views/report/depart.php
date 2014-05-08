<?php
//Yii::import('ext.select2.Select2');
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
function echoData($data, $subjects)
{

  $column = array();
    echo "<tr>";
    echo "<th > </th>";
  foreach($subjects as $sbj_id=>$sbj_name){
    echo "<th>".$sbj_name."</th>";
    $column[]=$sbj_id;
  }
  echo "</tr>";

  $column_len = count($column);

    foreach($data as $k=>$depart)
      {
        echo "<tr>";
        echo "<td>".$k."</td>";
        for($i=0;$i++;$i<$column_len){
          if(isset($depart[$column[$i]])){
            $balance = $depart[$column[$i]];
          }else{
            $balance = 0;
          }
        echo "<td>".number_format($balance, 2)."</td>";
        }
        echo "<tr>";                                                   
      }
}
?>

<div class="alert alert-info">
<?php echo CHtml::beginForm('','post',array('class'=>'form-inline','role'=>'form')); ?>
	<h3>部 门 表</h3>
	<div class="form-group">
		<label for="date">请选择日期：</label>
		<input type="text" name="date" id="date" class="form-control" value="<?php echo isset($date)?$date:'' ?>" readonly/>
	</div>
	<input class="btn btn-primary" type="submit" value="查看报表" />
<?php echo CHtml::endForm(); ?>
</div>

<?php
	if ($data) {
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2>部 门 表</h2>
	</div>

	<table cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;">
       <tr>
          <td colspan="6" align="right"> 金额单位:元 </td>
       </tr>
<?php echoData($data, $subjects) ?>
    </table>
</div>
<?php
}
?>