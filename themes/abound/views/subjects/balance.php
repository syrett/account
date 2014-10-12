<!-- 期初余额设置 -->
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/subjects.js', CClientScript::POS_HEAD);

$this->pageTitle=Yii::app()->name . ' - 科目期初余额';
$this->breadcrumbs=array(
	'科目期初余额',
);



?>
<?php echo CHtml::beginForm(); ?>
<table class="table table-bordered transition" id="transitionRows">
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

; ?>
    </td>
    <td id="start_balance" class="col-md-3">
<?php echo CHtml::activeTextField($item, "[$i]start_balance", array('class' => 'form-control input-size', 'onkeyup'=>'checkInputAmount(this)')); ?>
    </td>
  </tr>

<?php
}
?>

<button>保存</button>
<?php echo CHtml::endForm(); ?>