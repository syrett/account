<!-- 损益表 -->
<?php

Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/profit.js', CClientScript::POS_HEAD);

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
.table-d table{ background:#000 border-right:1px solid #000}
.table-d table td{ background:#FFF}
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
      echo "<td>".$arr["start"]." </td>";
      echo "<td>" .$arr["end"]."</td>";
      echo "</div>";
    }
}

?>

<div class="table-c";>

<?php echo CHtml::beginForm(); ?>
<div>
<h5>日期:
    <input type="text" name="date" id="date" class="span2" value="" readonly/>
</h5>

<input type="submit" value="查看报表" />
<?php echo CHtml::endForm(); ?>
    </div>
<table cellpadding="0";cellspacing="0";style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=3 align=center> <?php echo $date ?> </td>
                                         </tr>

                                         <tr>
                                         <td>编制单位:</td>
                                         <td> <?php echo $company ?> </td>
                                         <td align=right> 金额单位:元 </td>
                                         </tr>

                                         <tr>
                                         <th >项目</th>
                                         <th >本期数</th>
                                         <th>本年累计同期数</th>
                                         </tr>
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
                                         <?php echoData(0, $data, "其中：归属于母公司所有者的净利润") ?>
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