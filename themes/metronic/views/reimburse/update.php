<?php
/* @var $this ReimburseController */
/* @var $model Reimburse */

$this->breadcrumbs=array(
	'Reimburses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$cs = Yii::app()->clientScript;

$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/pages/scripts/components-pickers.js', CClientScript::POS_END);
$cs->registerScript('ComponentsPickersInit', 'ComponentsPickers.init();', CClientScript::POS_READY);
$type = 'reimburse';
?>

<div class="portlet box blue">
    <div class="portlet-title">
        <div class="caption"><?= Yii::t('import', '修改') ?><?= Yii::t('import', strtoupper($type)) ?></div>
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
                    <?php
                    $this->renderPartial('/layouts/menu2');
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="btn-group pull-right">
                        <? echo CHtml::link('<span class="glyphicon glyphicon-search"></span>'.Yii::t('import', '已导入数据'), array('/' . $type), array('class' => 'btn btn-default')); ?>
                        <input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate('post') ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php
        $this->renderPartial('_form', array('model' => $model, 'sheetData' => $sheetData));
        ?>
    </div>
</div>
<input id="type" type="hidden" value="<?= $this->createUrl(
    '/bank/type'
) ?>">
<input id="user-bank" type="hidden" value="<?= $this->createUrl(
    '/user/savebank'
) ?>">
<input id="option" type="hidden" value="<?= $this->createUrl(
    '/bank/option'
) ?>">
<input id="employee" type="hidden" value="<?= $this->createUrl(
    '/employee/createemployee'
) ?>">
<input id="new-url" type="hidden" value="<?= $this->createUrl(
    '/subjects/createsubject'
) ?>">
<input id="get-porder" type="hidden" value="<?= $this->createUrl(
    '/preparation/getporder'
) ?>">
<input id="data" type="hidden" value="">
<input id="subject" type="hidden" value="">
<input id="item_id" type="hidden" value="">
<input id="action" type="hidden" value="<?=$type?>">