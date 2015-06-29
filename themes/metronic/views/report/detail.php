<!-- 明细表 -->
<?php
Yii::import('ext.select2.ESelect2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/excel_export.js', CClientScript::POS_HEAD);
?>

<style>
.ui-datepicker table{
    display: none;
}
</style>
<div class="alert alert-info">
	<?php echo CHtml::beginForm('','post',array('class'=>'form-inline')); ?>
	<h3>明 细 表</h3>
	<div class="form-group">
		<label class="control-label" for="date">请选择报表日期：</label>
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

        //$years = array(2013=>'2013',2014=>'2014');
        //有凭证的年份
        $years = Transition::model()->hasTransitionYears();
        $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');

        $this->widget('ESelect2', array(
            'name' => 'year',
            'value' => $year,
            'data' => $years,
        ));
        ?>
        年
        <?php
        $this->widget('ESelect2', array(
            'name' => 'fm',
            'value' => $fm,
            'data' => $months,
        ));
        ?>
        月 至
        <?php
        $this->widget('ESelect2', array(
            'name' => 'tm',
            'value' => $tm,
            'data' => $months,
        ));
        ?>
		月
        <label class="control-label" for="date">选择科目</label>
        <?php
        $this->widget('ESelect2', array(
            'name' => 'subject_id',
            'value' => $subject_id,
            'data' => Transition::model()->listSubjects(),
        ));
        ?>
		<input type="submit" class="btn btn-primary" value="查看报表" />
	</div>
	<p>&nbsp;</p>
	<?php echo CHtml::endForm(); ?>
</div>


<?php
 if(!empty($dataProvider)) {
?>
<div class="panel panel-default">

	<div class="panel-heading">
		<h2>明 细 表</h2>
	</div>
	<div class="panel-body">
		<p class="text-center"><span class="pull-left">日期：<?php echo $fromMonth."-".$toMonth ?></span> 编制单位：<?php echo $company ?> <span class="pull-right"><span class="pull-right">金额单位：元</span></p>
	</div>
     <table id="detail" class="table table-bordered table-hover">
		 <tr>
		 <td colspan=6 align=center> <?php echo $fromMonth."-".$toMonth ?> </td>
		 </tr>

		 <tr>
		 <th>日期</th>
		 <th>凭证号码</th>
		 <th>描述</th>
		 <th class="text-right">借方</th>
		 <th class="text-right">贷方</th>
		 <th class="text-right">余额</th>
		 </tr>

		 <tr>
		 <th>&nbsp;</th>
		 <th>&nbsp;</th>
		 <th>期初余额</th>
		 <th>&nbsp;</th>
		 <th>&nbsp;</th>
		 <th class="text-right"><?php echo $dataProvider["start_balance"] ?></th>
		 </tr>
		 <tr>
<?php
 $info = $dataProvider["info"];
 $month_debit=0;
 $month_credit=0;
 $month_balance=$dataProvider["start_balance"];
 $month=0;
 $sbj_cat = Subjects::model()->getCat($subject_id);
 foreach($info as $ti){
   if(isset($ti["debit"])){
     $debit = $ti["debit"];
   }else{
     $debit = 0;
   }
      
   if(isset($ti["credit"])){
     $credit = $ti["credit"];
   }else{
     $credit = 0;
   }
   $row_month = substr($ti["entry_date"], 5, 2);
   if ($row_month == $month || $month == 0) {
     $month_debit += $debit;
     $month_credit += $credit;
     $month=$row_month;
   }else{

     $month_balance = balance($month_balance, $month_debit, $month_credit, $sbj_cat);
     echo "<tr>";
     echo "<td colspan=3>".$month."月总计 </td>";
     echo '<td class="text-right">'.number_format($month_debit, 2)."</td>";
     echo '<td class="text-right">'.number_format($month_credit, 2)."</td>";
     echo '<td> class="text-right"'.$month_balance."</td>";
     echo "</tr>";
     $month_debit = $debit;
     $month_credit = $credit;
     $month=$row_month;
   };

   echo "<tr>";
   echo "<td>".substr($ti["entry_date"],0,10)."</td>";
   echo "<td>".$ti["entry_num"]."</td>";
   echo "<td>".$ti["entry_memo"]."</td>";

   if(isset($ti["debit"])){
     echo '<td class="text-right">'.number_format($ti["debit"],2)."</td>";
     $debit = $ti["debit"];
   }else{
     echo "<td> </td>";
     $debit = 0;
   }
      
   if(isset($ti["credit"])){
     echo '<td class="text-right">'.number_format($ti["credit"],2)."</td>";
     $credit = $ti["credit"];
   }else{
     echo "<td> </td>";
     $credit = 0;
   }
   echo '<td class="text-right">'.number_format($ti["balance"],2)."</td>";
   echo "</div>";
   echo "</tr>";


 }
 
 if($month != 0){
     echo "<tr>";
     echo "<td colspan=3>".$month."月总计 </td>";
     echo '<td class="text-right">'.number_format($month_debit, 2)."</td>";
     echo '<td class="text-right">'.number_format($month_credit, 2)."</td>";
     echo '<td class="text-right">'.balance($month_balance, $month_debit, $month_credit, $sbj_cat)."</td>";
     echo "</tr>";
 }
?>
				 <tr>
				 <th>&nbsp;</th>
				 <th>&nbsp;</th>
				 <th>总计</th>
 <th class="text-right"><?php echo number_format($dataProvider["sum_debit"],2) ?></th>
 <th class="text-right"><?php echo number_format($dataProvider["sum_credit"],2) ?></th>
 <th class="text-right"><?php echo number_format($dataProvider["end_balance"],2) ?></th>
				 </tr>
		</table>
</div>

<?php }
?>

<div class="alert">
    <a id="dlink"  style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($subject_id != ""){
      $excel_name = "明细表-".$subject_name." ".$fromMonth."-".$toMonth.".xls";
        ?>

        <input type="hidden" name="data" id="data" value="" />
        <input type="hidden" name="name" id="name" value="<?=$excel_name?>" />
		<p class="text-right">
		<?php
		echo '<button type="button" onclick="tableToExcel()" class="btn btn-primary"><span class="glyphicon glyphicon-export"></span> 导出</button>';
	}
	echo CHtml::endForm();
	?>
	</p>
</div>
