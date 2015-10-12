<!-- 期初余额设置 -->
<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/subjects.js', CClientScript::POS_END);

$this->pageTitle=Yii::app()->name . ' - 科目期初余额';
$this->breadcrumbs=array(
	'科目期初余额',
);



?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp">期初余额</span>
		</div>
		<div class="actions">
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
		</div>
	</div>
	<div class="portlet-body">
        <div class="errorMessage" style="color: red;">
            <?php
            foreach (Yii::app()->user->getFlashes() as $key => $message) {
                echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
            }
            ?>
        </div>
		<div class="alert alert-info">注意:改变期初余额将会影响报表的准确性，所以每次改变期初余额后都请反结账！</div>
		<form action="?r=subjects/balance" method="POST">
		<table class="table table-bordered table-hover">
		  <thead>
		  <tr>
		  <th class="col-md-3">科目编码</th>
		  <th class="col-md-3">科目名称</th>
		  <th class="col-md-1">科目类别</th>
		  <th class="col-md-2">期初余额</th>
		  </tr>
		  </thead>
		<?php
		  //  var_dump($dataProvider);
		//exit(1);
		//$data2 = $data->getData();
		  foreach ($data as $i => $item) {  
		?>
		  <tr>
			<td id="sbj_number" class="col-md-3">
		<?php echo $item["sbj_number"]; ?>
			</td>
			<td class="col-md-3">
		<?php echo $item["sbj_name"]; ?>
			</td>
			<td class="col-md-3">
		<?php
		 switch ($item["sbj_cat"]) {
		 case "1":echo "资产";break;
		 case "2":echo "负债";break;
		 case "3":echo "权益";break;
		 }
		?>
			</td>
			<td id="start_balance" class="col-md-3">
			  <?php if ($item["has_sub"]==0){  ?>
											   <input name=<?php echo $item["sbj_number"];?> value=<?php echo isset($_POST[$item["sbj_number"]])?$_POST[$item["sbj_number"]]:$item["start_balance"]; ?> />
											   <?php }else{?>
														   <label><?php echo $item["start_balance"];?></label>
														   <?php } ?>
			</td>
		  </tr>

		<?php
		}
		?>
		</table>
		<div class="form-group" >
			<div class="text-center">
			<?php echo CHtml::submitButton('保存', array('class'=>'btn btn-circle btn-primary',)); ?>
			<?php echo BtnBack(); ?>
			</div>
		</div>
		</form>
	</div><!-- .portlet-body -->
</div><!-- .portlet -->
