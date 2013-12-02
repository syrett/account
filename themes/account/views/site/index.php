<?php
/* @var $this SiteController */
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/datepicker.css');
$this->pageTitle = Yii::app()->name;
?>
<script>
    $(document).ready(function () {
        //your code here
        $('#dp1').datepicker();
        $(document).ready(function () {
            $('#test').select2({
                placeholder: "Select a State",
                allowClear: true
            });
        });
    });
</script>
<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">凭证录入</div>
    <div class="panel-body v-title">
        <div class="row">
            <div class="col-md-4"><h5>凭证号: *****</h5></div>
            <div class="col-md-4"><h5>日期:
                    <input type="text" class="span2" value="<?php echo date("m/d/Y"); ?>" id="dp1" readonly>
                </h5></div>
            <div class="col-md-4"><h5></h5></div>
        </div>
    </div>

    <!-- Table -->
    <table class="table">
        <tr>
            <td>
                <div class="row">
                    <div class="col-md-3">摘要</div>
                    <div class="col-md-1">借/贷</div>
                    <div class="col-md-3">科目</div>
                    <div class="col-md-1">金额</div>
                    <div class="col-md-4">附加</div>
                </div>
                <div class="row v-detail">
                    <div class="col-md-3">.col-md-4</div>
                    <div class="col-md-1">
                        <?php
                        $this->widget('Select2', array(
                            'name' => '',
                            'value' => 2,
                            'data' => array(1 => '借', 2 => '贷'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-3">
                        <div>
                                <?php
                                $data = array();
                                for ($i = 1; $i < 200; $i++) {
                                    echo '<select id="test"><option value="'. $i.' " >提取未到期责任准备金<!--tqwd--></option></select>';
                                }
                                ?>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <?php

                        $data = array();
                        for ($i = 1; $i < 200; $i++) {
                            echo '<select id="test"><option value="'. $i.' " >提取未到期责任准备金<!--tqwd--></option></select>';
                        }
                        ?></div>
                    <div class="col-md-4">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<h1><i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<div></div>
