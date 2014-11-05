<?php

$this->pageTitle=Yii::app()->name . ' - 公司信息';
$this->breadcrumbs=array(
    '公司信息',
);
/* @var $this OptionsController */
/* @var $model Options */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h2>公司信息</h2>
    </div>
    <div class="panel-body">
        <?php echo CHtml::beginForm(); ?>
        <div class="input-group">
            <span class="input-group-addon">公司名称：</span>
            <?php echo CHtml::activeTextField($model[0], "name", array('class' => 'form-control')); ?>
        </div>
        <p>&nbsp;</p>
        <div class="text-center">
            <?php
                echo CHtml::tag('button',array('encode'=>false,'class' => 'btn btn-primary',),'<span class="glyphicon glyphicon-floppy-disk"></span> 保存');

            ?>
        </div>
        <!-- search-form -->

        <?php echo CHtml::endForm(); ?>
    </div>
</div>

