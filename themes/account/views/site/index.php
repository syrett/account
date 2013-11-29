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
        $(document).ready(function() {
            $('#test').select2({
                minimumInputLength: 3,
                placeholder: 'Search',
                ajax: {
                    url: "http://www.weighttraining.com/sm/search",
                    dataType: 'jsonp',
                    quietMillis: 100,
                    data: function(term, page) {
                        return {
                            types: ["exercise"],
                            limit: -1,
                            term: term
                        };
                    },
                    results: function(data, page ) {
                        return { results: data.results.exercise }
                    }
                },
                formatResult: function(exercise) {
                    return "<div class='select2-user-result'>" + exercise.term + "</div>";
                },
                formatSelection: function(exercise) {
                    return exercise.term;
                },
                initSelection : function (element, callback) {
                    var elementText = $(element).attr('data-init-text');
                    callback({"term":elementText});
                }
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
                        'data' => array( 1=> '借', 2=> '贷'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        $data = array();
                        for($i=1; $i<200; $i++){
                            $data += array( $i => $i. '提取未到期责任准备金 '. $i);
                        }
                        $this->widget('Select2', array(
                            'name' => 'inputName',
                            'value' => 2,
                            'data' => $data,
                            'htmlOptions' => array('title'=>$i.'存放中央银行款项', 'class' => 'v-subject'),
                        ));
                        ?></div>
                    <div class="col-md-1">.col-md-4</div>
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
