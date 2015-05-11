<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'导入凭证',
);

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h2>导入现金交易</h2>
	</div>
	<?php
	foreach(Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
	?>
	<?php $this->renderPartial('_import', array('type'=>'cash','model' => $model,'sheetData' => $sheetData)); ?>
</div>
