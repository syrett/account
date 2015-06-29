<?php
/* @var $this SiteController */
/* @var $operation string */
Yii::import('ext.select2.ESelect2');

$this->pageTitle = Yii::app()->name;

$list = $this->listMonth('listSettlement');
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading"><h2>
            账套操作

        </h2></div>
    <div class="panel-body v-title">

        <!-- search-form -->

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal',),
        ));
        if (!empty($list)) {
            echo '一键结账截至日期';
            foreach ($list as $year => $months) {
                foreach ($months as $month) {
                    $data[$year . $month] = $year . '年' . $month;
                }
            }
            $this->widget('ESelect2', array(
                'name' => 'edate',
                'data' => $data,
                'htmlOptions' => array('class' => 'action')
            ));
            ?>

            <?php echo CHtml::hiddenField('progress_key', uniqid(), array('id' => 'progress_key')); ?>
            <input type="button" class="btn btn-primary" onclick="save()" value="确定"/>
        <?
        } else
            echo '没有数据需要处理，可以导出报表';
        $this->endWidget();
        ?>
        <?
        $this->widget('zii.widgets.jui.CJuiButton', array('name' => 'just_for_include_jqeuryui_css', 'htmlOptions' => array('style' => 'display:none;')));
        $this->renderPartial('VProgressBar');
        ?>
        <div id="modalDivProgress" style="margin: 20px auto 0; height: 25px;">
            <div id="progressbar" style="width:100%; height: 10px; margin-bottom: 5px"></div>
            <div id="percentage" style="width: 100%; text-align: center"></div>
        </div>
    </div>
