 <!-- 客户报表 -->
<?php

//Yii::app()->clientScript->registerCoreScript('jquery');
//$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
////$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profit.js', CClientScript::POS_HEAD);

?>
<style>
.table-c table{border-right:1px solid #F00;border-top:1px solid #F00; cellpadding:0; cellspacing:0 }
.table-c table th{border-left:1px solid #F00;border-bottom:1px solid #F00; cellpadding:0; cellspacing:0}
.table-c table td{border-left:1px solid #F00;border-bottom:1px solid #F00; cellpadding:0; cellspacing:0}
.ui-datepicker table{
    display: none;
}
</style>

<style>
.table-d table{ background:#000; border-right:1px solid #000}
.table-d table td{ background:#FFF}
</style>

<?php
function echoData($data, $options=array("css"=>"table-c"))
{

  if (empty($options["css"]))
    {
      $css= "table-c";
    }
  else
    {
    $css = $options["css"];
    }   

    foreach($data as $ti)
      {
        echo "<tr>";
        echo "<div class=".$css.">";
        echo "<td>".$ti["id"]."</td>";
        echo "<td>".number_format($ti["month_debit"], 2)."</td>";
        echo "<td>".number_format($ti["month_credit"], 2)."</td>";
        echo "<td>".number_format($ti["year_debit"], 2)."</td>";
        echo "<td>".number_format($ti["year_credit"], 2)."</td>";
        echo "<td>".number_format($ti["balance"], 2)."</td>";
        echo "<tr>";                                                   
      }
}
?>

<div class="table-c";>

 <div>
<?php echo CHtml::beginForm(); ?>
<h5>日期:
    <input type="text" name="date" id="date" class="span2" value="<?php echo isset($date)?$date:'' ?>" readonly/>
</h5>

<input type="submit" value="查看报表" />
<?php echo CHtml::endForm(); ?>
    </div>
<div style="display:<?php if($data=='') echo 'none';?>">
<table cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=6 align=right> 金额单位:元 </td>
                                         </tr>

                                         <tr>
                                         <th > </th>
                                         <th >本期借方</th>
                                         <th>本期贷方</th>
                                         <th >本年借方</th>
                                         <th>本年贷方</th>
                                         <th >余额</th>
                                         </tr>


    <?php echoData($data) ?>

                                         </td>
                                         </table>
    </div>
  </div>






