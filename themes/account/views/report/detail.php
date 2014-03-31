 <!-- 明细表 -->

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
            $subject_id = $_REQUEST['subject_id'];
        }
        else
        {
            $year = '';
            $fm = '';
            $tm = '';
            $subject_id = '';
        }

        $years = array(2013=>'2013',2014=>'2014');
        $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');
//        $subjects =

        $this->widget('Select2', array(
            'name' => 'year',
            'value' => $year,
            'data' => $years,
        ));
        ?>
        年</h5>
    <h5>
        <?php
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
    <h5>
        选择科目
        <?php
        $this->widget('Select2', array(
            'name' => 'subject_id',
            'value' => $subject_id,
            'data' => Transition::model()->listSubjects(),
        ));
        ?>
    </h5>

    <input type="submit" value="查看报表" />
    <?php echo CHtml::endForm(); ?>
</div>

 <?php if(!empty($dataProvider)) {

 ?>
<div class="table-c">
     <table cellpadding="0";cellspacing="0";style="padding:0px;margin:0px;">
                                         <tr>
                                         <td colspan=6 align=center> <?php echo $fromMonth."-".$toMonth ?> </td>
                                         </tr>

                                         <tr>
                                         <th >日期</th>
                                         <th >凭证号码</th>
                                          <th>描述</th>
                                         <th >借方</th>
                                         <th >贷方</th>
                                         <th >余额</th>
                                         </tr>

                                         <tr>
                                         <th ></th>
                                         <th ></th>
                                          <th>期初余额</th>
                                         <th ></th>
                                         <th ></th>
                                         <th ><?php echo $dataProvider["start_balance"] ?></th>
                                         </tr>
                                              <tr>

<?php
    $css = "table-c";
                                              $info = $dataProvider["info"];
foreach($info as $ti){
        echo "<tr>";
      echo "<div class=".$css.">";
      echo "<td>".$ti["entry_date"]."</td>";
      echo "<td>".$ti["entry_num"]."</td>";
      echo "<td>".$ti["entry_memo"]."</td>";

      if(isset($ti["debit"])){
        echo "<td>".$ti["debit"]."</td>";
      }else{
        echo "<td> </td>";
      }
      
      if(isset($ti["credit"])){
      echo "<td>".$ti["credit"]."</td>";
      }else{
        echo "<td> </td>";
      }
      echo "<td>".$ti["balance"]."</td>";
      echo "</div>";
      echo "</tr>";
}

?>

                                         <tr>
                                         <th ></th>
                                         <th ></th>
                                          <th>总计</th>
                                         <th ><?php echo $dataProvider["sum_debit"] ?></th>
                                         <th ><?php echo $dataProvider["sum_credit"] ?></th>
                                         <th ><?php echo $dataProvider["end_balance"] ?></th>
                                         </tr>


</table>



</div>
 <? }