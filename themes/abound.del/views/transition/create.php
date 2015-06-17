<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'录入凭证',
	'添加'
);

?>

<div class="panel panel-success">
	<div class="panel-heading">
	<h2>录入凭证</h2>
	</div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
