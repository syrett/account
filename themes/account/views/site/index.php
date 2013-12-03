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
    });
</script>
<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">凭证录入</div>
    <div class="panel-body v-title">
        <div class="row">
            <div class="col-md-4"><h5>凭证号: *****</h5></div>
            <div class="col-md-4"><h5>日期:
                    <input type="text" class="span2" value="<?php echo date("m/d/Y"); ?>" id="dp1" readonly />
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
                            'id' => 's1',
                            'value' => 1,
                            'data' => array(1 => '借', 2 => '贷'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $this->widget('Select2', array(
                            'name' => '',
                            'id' => 's1',
                            'value' => 1,
                            'data' => array(1 => '请选择'),
                        ));
                        ?>
                        </div>
                    <div class="col-md-1">.col-md-1

                        </div>
                    <div class="col-md-4">

                        <script language="javascript">
                            $("#").change(function(){
                                url = <? echo '"'. Yii::app()->createAbsoluteUrl("site/productlist"). '"'?>;
                                jQuery.ajax({
                                    'url':url,
                                    'type': "POST",
                                    'cache':false,
                                    'success':function(html){
                                        jQuery("#quote-of-the-day").html(html)
                                    }
                                });
                            });
                        </script>

                        <button type="button" class="close" aria-hidden="true">&times;</button>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>
<h1><i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<div></div>
