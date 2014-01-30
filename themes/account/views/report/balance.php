<style>
.table-c table{border-right:1px solid #F00;border-top:1px solid #F00; cellpadding:0; cellspacing:0 }
.table-c table th{border-left:1px solid #F00;border-bottom:1px solid #F00; cellpadding:0; cellspacing:0}
.table-c table td{border-left:1px solid #F00;border-bottom:1px solid #F00; cellpadding:0; cellspacing:0}
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
      echo "<td>  </td>";
      echo "<td>  </td>";
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
<table cellpadding="0";cellspacing="0";style="padding:0px;margin:0px;">
                                         <tr>
                                         <th >资产</th>
                                         <th >年初数</th>
                                         <th>期末数</th>
                                         <th >负债及股权益(所有者权益)</th>
                                         <th >年初数</th>
                                         <th>期末数</th>
                                         </tr>
                                         <tr> 
                                         <?php echoData(0, $data, "流动资产:") ?>
                                         <?php echoData(0, $data,  "流动负债:") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(1, $data, "货币资金" ) ?>
                                         <?php echoData(31, $data,  "短期借款") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(2, $data,  "交易性金融资产") ?>
                                         <?php echoData(32, $data,  "交易性金融负债") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(3, $data,  "应收票据") ?>
                                         <?php echoData(33, $data,  "应付票据") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(4, $data,  "应收账款") ?>
                                         <?php echoData(34, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(9, $data,  "todo(两个),减:坏账准备") ?>
                                         <?php echoData(35, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(5, $data,  "预付账款") ?>
                                         <?php echoData(36, $data ) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(7, $data,  "应收利息") ?>
                                         <?php echoData(0, $data,  "todo,其中职工福利费") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(6, $data,  "应收股利") ?>
                                         <?php echoData(0, $data,  "todo,职工教育经费") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(8, $data,  "其他应收款") ?>
                                         <?php echoData(37, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(9, $data,  "todo(两个)减:坏账准备") ?>
                                         <?php echoData(38, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(11, $data,  "存货") ?>
                                         <?php echoData(39, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(12, $data,  "减:存货跌价准备") ?>
                                         <?php echoData(40, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,一年内到期的非流动资产") ?>
                                         <?php echoData(0, $data,  "todo,一年内到期的非流动负债 ") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(10, $data,  "其他流动资产") ?>
                                         <?php echoData(41, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData("flow_property", $data,  "流动资产合计") ?>
                                         <?php echoData("flow_debt", $data,  "流动负债合计") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "非流动资产:") ?>
                                         <?php echoData(0, $data,  "") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(15, $data,  "可供出售金融资产") ?>
                                         <?php echoData(0, $data,  "非流动负债:") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo, 减:可供出售金融资产减值准备") ?>
                                         <?php echoData(42, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(13, $data,  "持有至到期投资") ?>
                                         <?php echoData(43, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(14, $data,  "减:持有至到期投资减值准备") ?>
                                         <?php echoData(45, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(19, $data,  "长期应收款") ?>
                                         <?php echoData(46, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(16, $data,  "长期股权投资") ?>
                                         <?php echoData(47, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(17, $data,  "减:长期股权投资减值准备") ?>
                                         <?php echoData(48, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(18, $data,  "投资性房地产") ?>
                                         <?php echoData(44, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(22,$data, "减:累计折旧(或摊销)") ?>
                                         <?php echoData("unflow_debt",$data, "非流动负债合计") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data, "todo,减:投资性房地产减值准备") ?>
                                         <?php echoData(0, $data, "") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(21, $data, "固定资产") ?>
                                         <?php echoData("debt", $data, "负债合计") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(22, $data, "减:累计折旧") ?>
                                         <?php echoData(0, $data, "todo, 上级拨入") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(23, $data,  "减:固定资产减值准备") ?>
                                         <?php echoData(0, $data,  "股东权益(所有者权益):") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(24, $data,  "在建工程") ?>
                                         <?php echoData(50, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,减:在建工程减值准备") ?>
                                         <?php echoData(51, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(25, $data,  "工程物资") ?>
                                         <?php echoData(54,  $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,减:工程物资减值准备") ?>
                                         <?php echoData(52, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,固定资产清理") ?>
                                         <?php echoData(0, $data,  "todo,其中:法定盈余公积") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(26,  $data, "无形资产") ?>
                                         <?php echoData(0,  $data, "todo,任意盈余公积") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0,  $data, "todo,其中:土地使用权") ?>
                                         <?php echoData(0,  $data, "储备基金") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(27, $data,  "减:无形资产减值准备") ?>
                                         <?php echoData(0,  $data, "企业发展基金") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(28, $data,  "商誉") ?>
                                         <?php echoData(53, $data) ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,减:商誉减值准备") ?>
                                         <?php echoData(0, $data,  "todo,外币报表折算差额") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(29, $data,  "长期待摊费用") ?>
                                         <?php echoData("parent_owner", $data,  "归属于母公司股东权益(所有者权益)合计") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(30, $data,  "递延所得税资产") ?>
                                         <?php echoData(0, $data,  "todo,少数股东权益") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(20, $data,  "其他非流动资产") ?>
                                         <?php echoData(0, $data,  "") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData("unflow_property", $data,  "非流动资产合计") ?>
                                         <?php echoData("owner", $data,  "股东权益(所有者权益)合计") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData(0, $data,  "todo,拨付所属资金") ?>
                                         <?php echoData(0, $data,  "") ?>
                                         </tr>
                                         <tr>
                                         <?php echoData("property", $data,  "资产合计") ?>
                                         <?php echoData("debt_owner", $data,  "负债及股东权益(所有者权益)合计") ?>
                                         </tr>

                                         </table>
                                         </div>



