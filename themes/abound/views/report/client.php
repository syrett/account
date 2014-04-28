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
function echoData($key, $data, $name="default",$options=array("css"=>"table-c"))
{

  if (empty($options["css"]))
    {
      $css= "table-c";
    }
  else
    {
    $css = $options["css"];
    }   
  if (empty($data[$key]))
    {
      echo "<div class=".$css.">";
      echo "<th>".$name."</th>";
      echo "<td>0</td>";
      echo "<td>0</td>";
      echo "</div>";
    }
  else
    {
      $arr=$data[$key];
      echo "<div class=".$css.">";
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
      echo "</div>";
    }
}

?>

<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
<div class="alert alert-info">
	<h3>客户表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
		<input class="form-control" type="text" name="date" id="date" value="<?php echo isset($date)?$date:'' ?>" readonly />
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
</div>
<?php echo CHtml::endForm(); ?>

<div style="display:<?php if($data=='') echo 'none';?>">
<table cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=3 align=center> <?php echo $date ?> </td>
                                         <td align=right> 金额单位:元 </td>
                                         </tr>

                                         <tr>
                                         <th > </th>
                                         <th >本期借方</th>
                                         <th>本期贷方</th>
                                         <th >本年借方</th>
                                         <th>本年贷方</th>
                                         <th >余额</th>
                                         </tr>


<?php
    $css = "table-c";
    foreach($data as $ti)
                                         {
                                                   echo "<tr>";
      echo "<div class=".$css.">";
      echo "<td>".$ti["id"]."</td>";
      echo "<td>".$ti["month_debit"]."</td>";
      echo "<td>".$ti["month_credit"]."</td>";
      echo "<td>".$ti["year_debit"]."</td>";
      echo "<td>".$ti["year_credit"]."</td>";
      echo "<td>".$ti["balance"]."</td>";
                                                   echo "<tr>";                                                   
                                         }
?>

                                         </td>
                                         </table>
    </div>