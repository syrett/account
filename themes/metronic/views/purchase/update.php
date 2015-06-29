<?php
/* @var $this PurchaseController */
/* @var $model Purchase */
$this->pageTitle = Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs = array(
    '导入凭证',
);
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/filechoose.js', CClientScript::POS_END);

$cs->registerScript('ComponentsPickersInit', 'ComponentsPickers.init();', CClientScript::POS_READY);
$type = 'purchase';
?>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption">修改<?= Yii::t('import', strtoupper($type)) ?></div>
    </div>
    <div class="portlet-body">
        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <?php
                        echo CHtml::link('<i class="fa fa-bank"><i></i></i><div>导入银行交易</div>', array('bank'), array('class' => 'icon-btn'));
                        echo "\n";
                        echo CHtml::link('<i class="fa fa-money"><i></i></i><div>导入现金交易</div>', array('cash'), array('class' => 'icon-btn'));
                        echo "\n";
                        echo CHtml::link('<i class="fa fa-edit"><i></i></i><div>手动录入</div>', array('create'), array('class' => 'icon-btn'));

                        echo "\n";
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <? echo CHtml::link('<span class="glyphicon glyphicon-search"></span> 已导入数据', array('/' . $type), array('class' => 'btn btn-default')); ?>
                        <input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate() ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->renderPartial('_form', array('model' => $model, 'sheetData' => $sheetData));
        ?>
    </div>
</div>
