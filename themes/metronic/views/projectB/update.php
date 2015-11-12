<?php
/* @var $this ProjectBController */
/* @var $model ProjectB */

$this->pageTitle=Yii::app()->name . ' - 修改在建工程';
$this->breadcrumbs=array(
    '在建工程列表',
    '新建在建工程'
);

?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption">
            <span class="font-green-sharp">修改在建工程</span>
        </div>
        <div class="actions">
            <?php
            echo CHtml::link('<i class="fa fa-bars"></i> 在建工程列表', array('admin'), array('class' => 'btn btn-circle btn-primary btn-sm'));
            ?>
            <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen" data-original-title="" data-original-title title="全屏"></a>
        </div>
    </div>
    <div class="portlet-body">
        <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>