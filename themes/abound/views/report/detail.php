 <!-- 明细表 -->

<?php
Yii::import('ext.select2.Select2');
?>

<style>
.ui-datepicker table{
    display: none;
}
</style>

<div class="alert alert-info">
	<h3>资产负债表</h3>
    <?php echo CHtml::beginForm(); ?>
    <div class="form-group">
    请选择日期：
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
        年
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
        </div>
        <div class="form-group">
        选择科目
        <?php
        $this->widget('Select2', array(
            'name' => 'subject_id',
            'value' => $subject_id,
            'data' => Transition::model()->listSubjects(),
        ));
        ?>
		<input type="submit" value="查看报表" class="btn btn-primary" />
		</div>
    <?php echo CHtml::endForm(); ?>
</div>

 <?php if(!empty($dataProvider)) {

 ?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<h2>资产负债表</h2>
  	<?php echo $fromMonth."-".$toMonth ?>
  </div>
  
<table class="table table-bordered">
	<tdead>
	 <tr>
	 <td>日期</td>
	 <td>凭证号码</td>
	 <td>描述</td>
	 <td>借方</td>
	 <td>贷方</td>
	 <td>余额</td>
	 </tr>
	</thead>
	 <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>期初余额</td>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td><?php echo $dataProvider["start_balance"] ?></td>
	 </tr>
	<tr>

<?php
$info = $dataProvider["info"];
foreach($info as $ti){
        echo "<tr>";
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
      echo "</tr>";
}

?>

	 <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>总计</td>
	 <td><?php echo $dataProvider["sum_debit"] ?></td>
	 <td><?php echo $dataProvider["sum_credit"] ?></td>
	 <td><?php echo $dataProvider["end_balance"] ?></td>
	 </tr>
</table>
 <? }
