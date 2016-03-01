<?php
/* @var $this DepartmentController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . Yii::t('import', ' - 员工管理');
$this->breadcrumbs=array(
	'员工管理',
);
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption">
		<span class="font-green-sharp"><?= Yii::t('import', '员工管理') ?></span>
		</div>
		<div class="actions">
		    <?php
				echo CHtml::link('<i class="fa fa-bars"></i>'.Yii::t('import', '员工列表'), array('admin'), array('class' => 'btn btn-circle btn-primary btn-sm'));
    		?>
			<a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
		</div>
	</div>
	<div class="portlet-body">
    <?php $this->renderPartial('_form', array('model' => $model,'department_array'=>$department_array)); ?>
    </div>
</div>
