 <!-- 科目余额表 -->
 <?php

 Yii::import('ext.select2.Select2');
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

 <div>
     <?php echo CHtml::beginForm(); ?>
     <h5>日期:
         <?php
         if(isset($_REQUEST['year']))
         {
             $year = $_REQUEST['year'];
             $fm = $_REQUEST['fm'];
             $tm = $_REQUEST['tm'];
             if($fm > $tm)
             {
                 $temp = $fm;
                 $fm = $tm;
                 $tm = $temp;
             }
         }

         $years = array(2013=>'2013',2014=>'2014');
         $this->widget('Select2', array(
             'name' => 'year',
             'value' => $year,
             'data' => $years,
         ));
         ?>
         年</h5>
     <h5>
         <?php
         $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');
         $this->widget('Select2', array(
         'name' => 'fm',
         'value' => $fm,
         'data' => $months,
         ));
         ?>
         月 至
         <?php

         $this->widget('Select2', array(
             'name' => 'tm',
             'value' => $tm,
             'data' => $months,
         ));
         ?>月
     </h5>

     <input type="submit" value="查看报表" />
     <?php echo CHtml::endForm(); ?>
 </div>

<?php
 function echoItmes($items, $options=array("css"=>"table-c")){
  if (empty($options["css"]))
    {
      $css= "table-c";
    }else
    {
      $css = $options["css"];
    }   
   foreach($items as $info) {
      echo "<div class=".$css.">";
      echo "<td>".$info["subject_id"]."</td>";
      echo "<td>".$info["sbj_name"]."</td>";
      echo "<td>".$info["start_debit"]."</td>";
      echo "<td>".$info["start_credit"]."</td>";
      echo "<td>".$info["sum_debit"]."</td>";
      echo "<td>".$info["sum_credit"]."</td>";
      echo "<td>".$info["end_start"]."</td>";
      echo "<td>".$info["end_credit"]."</td>";

   };
  }
?>

<div class="table-c";>
     <table cellpadding="0";cellspacing="0";style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=8 align=center> <?php echo $fromMonth."-".$toMonth ?> </td>
                                         </tr>

                                         <tr>
                                         <th >科目编码</th>
                                         <th >科目名称</th>
                                          <th>期初借方</th>
                                         <th >期初贷方</th>
                                         <th >本期发生借方</th>
                                         <th>本期发生贷方</th>
                                          <th>期末借方</th>
                                         <th >期末贷方</th>
                                         </tr>
                                         <tr>

    <?php

  foreach($dataProvider as $sbjCat=>$sbjCat_info) {
    switch ($sbjCat) {
      case "1":
      $sbjCat_name = "资产小计";
      break;
      case "2":
      $sbjCat_name = "负债小计";
      break;
      case "3":
      $sbjCat_name = "权益小计";
      break;
      case "4":
      $sbjCat_name = "收入小计";
      break;
      case "5":
      $sbjCat_name = "费用小计";
      break;

    };
    $items = $sbjCat_info["items"];
    $css = "table-c";
    


   foreach($items as $info) {
      echo "<tr>";
      echo "<div class=".$css.">";
      echo "<td>".$info["subject_id"]."</td>";
      echo "<td>".$info["subject_name"]."</td>";
      echo "<td>".$info["start_debit"]."</td>";
      echo "<td>".$info["start_credit"]."</td>";
      echo "<td>".$info["sum_debit"]."</td>";
      echo "<td>".$info["sum_credit"]."</td>";
      echo "<td>".$info["end_debit"]."</td>";
      echo "<td>".$info["end_credit"]."</td>";
      echo "</div>";
      echo "</tr>";

   };


    echo "<tr>";
    echo "<div class=".$css.">";
    echo "<td> </td>";
    echo "<td>" .$sbjCat_name."</td>";
    echo "<td>".$sbjCat_info["start_debit"]."</td>";
    echo "<td>".$sbjCat_info["start_credit"]."</td>";
    echo "<td>".$sbjCat_info["sum_debit"]."</td>";
    echo "<td>".$sbjCat_info["sum_credit"]."</td>";
    echo "<td>".$sbjCat_info["end_debit"]."</td>";
    echo "<td>".$sbjCat_info["end_credit"]."</td>";
    echo "</div>";
    echo "</tr>";
    
}

/*
$this->widget('zii.widgets.grid.CGridView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'columns' => array(
                                                                     'subject_id',
                                                                     'sbj_name',
                                                                     'sbj_cat',
                                                                     'start_debit',
                                                                     'start_credit',
                                                                     'sum_debit',
                                                                     'sum_credit',
                                                                     'end_debit',
                                                                     'end_credit',

                                                                     )
));
*/
?>
</tr>
</table>
</div>
