 <!-- 科目余额表 -->
<style>
.ui-datepicker table{
    display: none;
}
</style>

<div class="row">
<?php echo CHtml::beginForm('','post',array('class'=>'form-inline','role'=>'form')); ?>
	<div class="alert alert-info">
	<h3>科目余额表</h3>
	请选择报表日期：
	<div class="form-group">
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
         else
         {
             $year = '';
             $fm = '';
             $tm = '';
         }

//         $years = array(2013=>'2013',2014=>'2014');
//         $this->widget('Select2', array(
//             'name' => 'year',
//             'value' => $year,
//             'data' => $years,
//         ));

        $years = Transition::model()->hasData();
         ?>
            <select name="year" class="form-control">
                <?
                foreach ($years as  $year){
                    echo "<option value=$year >$year</option>";
                }
                ?>
            </select>
         <?php
         $months = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');
        ?>
         <select name="fm" class="form-control">
                <?
                foreach ($months as $month){
                    echo "<option value=$month >$month</option>";
                }
                ?>
            </select>
            月 至
            <select name="tm" class="form-control">
                <?
                foreach ($months as $value => $month){
                    echo "<option value=$value >$month</option>";
                }
                ?>
            </select>
            月
			<input class="btn btn-primary" type="submit" value="查看报表" />
	</div><!-- .form-group -->
	</div>
<?php echo CHtml::endForm(); ?>
</div>

<?php
 function echoItmes($items){
   foreach($items as $info) {
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

<?php if(!empty($_REQUEST['year'])) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<h2>科目余额表</h2>
  	<?php echo $fromMonth."-".$toMonth ?>
  </div>
  
<table class="table table-bordered">
	<thead>
		 <tr>
		 <td>科目编码</td>
		 <td>科目名称</td>
		 <td>期初借方</td>
		 <td>期初贷方</td>
		 <td>本期发生借方</td>
		 <td>本期发生贷方</td>
		 <td>期末借方</td>
		 <td>期末贷方</td>
		 </tr>
	 </thead>
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


foreach($items as $info) {
  echo "<tr>";
  echo "<td>".$info["subject_id"]."</td>";
  echo "<td>".$info["subject_name"]."</td>";
  echo "<td>".$info["start_debit"]."</td>";
  echo "<td>".$info["start_credit"]."</td>";
  echo "<td>".$info["sum_debit"]."</td>";
  echo "<td>".$info["sum_credit"]."</td>";
  echo "<td>".$info["end_debit"]."</td>";
  echo "<td>".$info["end_credit"]."</td>";
  echo "</tr>";

};


echo "<tr>";
echo "<td>&nbsp;</td>";
echo "<td>" .$sbjCat_name."</td>";
echo "<td>".$sbjCat_info["start_debit"]."</td>";
echo "<td>".$sbjCat_info["start_credit"]."</td>";
echo "<td>".$sbjCat_info["sum_debit"]."</td>";
echo "<td>".$sbjCat_info["sum_credit"]."</td>";
echo "<td>".$sbjCat_info["end_debit"]."</td>";
echo "<td>".$sbjCat_info["end_credit"]."</td>";
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
<? }
