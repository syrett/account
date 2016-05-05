<!-- 纳税申报表 -->
<?php

Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_HEAD);
if ($type == 'A')
    $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/tax4_a.js', CClientScript::POS_HEAD);
else
    $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/tax4_b.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/excel_export.js', CClientScript::POS_HEAD);

?>

<div class="alert alert-info">
    <?php echo CHtml::beginForm('', 'post', array('class' => 'form-inline', 'id' => 'report')); ?>
    <h3><?= Yii::t('report', '企业所得税纳税申报表') ?></h3>

    <div class="form-group">
        <label class="control-label" for="date"><?= Yii::t('report', '请选择报表日期') ?>：</label>
        <input type="text" data-date-format="yyyymmdd" name="date"
               class="form-control form-control-inline input-small date-picker"
               value="<?php echo isset($date) ? $date : '' ?>" id="date" readonly="">
        <input type="button" onclick="javascript:$('#type').val('month');$('#report').submit();" class="btn btn-primary"
               value="<?= Yii::t('report', '按月份查看') ?>"/>
        <input type="button" onclick="javascript:$('#type').val('quarter');$('#report').submit();"
               class="btn btn-primary"
               value="<?= Yii::t('report', '按季度查看') ?>"/>
        <input type="hidden" name="type" id="type" value="<?= $zone ?>">
    </div>
    <p>&nbsp;</p>
    <?php echo CHtml::endForm(); ?>
</div>
<?
    if( $type == 'A')
        $this->renderPartial("tax4_A", array("data" => $data,
            "date" => $date));
    else
        $this->renderPartial("tax4_B", array("data" => $data,
            "date" => $date));

?>
<div class="alert">
    <a id="dlink" style="display:none;"></a>
    <?php
    echo CHtml::beginForm($this->createUrl('/Report/createexcel'), 'post');
    if ($date != ""){
    $d = date('Y-m', strtotime($date));
    $excel_name = Yii::t('report', "增值税纳税申报表") . "-$d.xls";
    ?>
    <input type="hidden" name="data" id="data" value=""/>
    <input type="hidden" name="name" id="name" value="<?= $excel_name ?>"/>

    <p class="text-right">
        <?php
        echo '<button type="button"onclick="tableToExcel()"class="btn btn-primary"><span class="glyphicon glyphicon-export"></span>' . Yii::t('report', '导出') . '</button>';
        }
        echo CHtml::endForm();
        ?>
    </p>
</div>