<?php
/* @var $this SiteController */
/* @var $operation string */
Yii::import('ext.select2.Select2');

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
            $this->widget('Select2', array(
                'name' => 'edate',
                'data' => $data,
                'htmlOptions' => array('class' => 'action')
            ));
        ?>

            <?php echo CHtml::hiddenField('progress_key', uniqid(), array('id'=>'progress_key')); ?>
        <input type="button" class="btn btn-primary" onclick="save()" value="确定" />
        <?
        } else
            echo '没有数据需要处理，请尝试直接导出报表';
        $this->endWidget();
        ?>
        <div>
            <a href="<?= $this->createUrl("/transition/antiSettlement") ?>" >
                <input type="button" class="btn btn-primary" value="反结账" />
            </a>
        </div>
        <?
        $this->widget('zii.widgets.jui.CJuiButton',array('name'=>'just_for_include_jqeuryui_css','htmlOptions'=>array('style'=>'display:none;')));
        $this->renderPartial('VProgressBar');    // include the progress bar here, should we wrap it into a CJuiWidget?
?>
    </div>