<?php
/* @var $this CashController */
/* @var $model Cash */

$this->breadcrumbs=array(
	Yii::t('import', 'CASH')=>array('index'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bank-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>交易信息修改</h2>
	</div>
	<?php

	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}

	$this->renderPartial('_form', array('model' => $model, 'sheetData'=> $sheetData)); ?>
</div>