 <!-- 项目报表 -->
<?php
Yii::import('ext.select2.Select2');
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
.table-d table{ background:#000; border-right:1px solid #000}
.table-d table td{ background:#FFF}
</style>

<?php
function echoData($data, $subjects, $options=array("css"=>"table-c"))
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
  if (empty($options["css"]))
    {
      $css= "table-c";
    }
  else
    {
    $css = $options["css"];
    }   

    foreach($data as $k=>$depart)
      {

        echo "<tr>";
        echo "<div class=".$css.">";
        echo "<td>".$depart["name"]."</td>";
        for($i=0;$i<$column_len;$i++){
          if(isset($depart[$column[$i]])){
            $balance = $depart[$column[$i]];
          }else{
            $balance = 0;
          }
        echo "<td>".number_format($balance, 2)."</td>";
        }
        echo "</div>";
        echo "</tr>";                                                   

      }
}
?>

<div class="table-c";>

 <div>
<?php echo CHtml::beginForm(); ?>
<h5>日期:
    <input type="text" name="date" id="date" class="span2" value="<?php echo isset($date)?$date:'' ?>" readonly/>
</h5>

    <h5>
        选择科目
        <?php
        $this->widget('Select2', array(
            'name' => 'sbj_id',
            'value' => $subject_id,
            'data' => $list,
        ));
        ?>
    </h5>

<input type="submit" value="查看报表" />
<?php echo CHtml::endForm(); ?>
    </div>
<div style="display:<?php if($data=='') echo 'none';?>">
<table cellpadding="0" cellspacing="0" style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=2 align=right> 金额单位:元 </td>
                                         </tr>

    <?php echoData($data, $subjects) ?>

                                         </td>
                                         </table>
    </div>
  </div>








