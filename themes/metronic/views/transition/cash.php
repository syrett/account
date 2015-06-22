<?php
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'导入现金交易',
);

?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
		<i class="fa fa-edit"></i>导入现金交易
		</div>
	</div>
	<div class="portlet-body">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
