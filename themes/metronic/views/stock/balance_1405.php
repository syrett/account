<?php
/* @var $this StockController */
/* @var $model Stock */

$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 库存商品期初明细');
$this->breadcrumbs = array(
    Yii::t('import', '库存商品期初明细'),
);

$baseUrl = Yii::app()->theme->baseUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/filechoose.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/balance_common.js');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'employee-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal',
        'enctype' => "multipart/form-data",),
));

$subject_array = Subjects::model()->listSubjects('1403');
$subject_array += Subjects::model()->listSubjects('1405');
$balance_1403 = Subjects::get_balance('1403');
$balance_1405 = Subjects::get_balance('1405');
?>
    <div class="portlet light">

        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="portlet-title">
            <div class="caption">
                <span class="font-green-sharp"><?= Yii::t('import', '库存商品期初余额明细') ?></span>
            </div>
            <div class="actions">
                <div class="actions">
                    <?php echo CHtml::link('<i class="glyphicon glyphicon-search"></i> '.Yii::t('import', '已导入数据'), array('/stock/balance','type'=>'1405'), array('class' => 'btn btn-circle btn-default')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="alert alert-info"><?= Yii::t('import', '提示：录入本模块前，请先完成总账期初余额设置。本模块必须一次性全部导入。') ?></div>
        </div>
        <div class="portlet-body">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <div class="input-group choose-btn-group">
                        <div class="input-icon">
                            <i class="fa fa-file fa-fw"></i>
                            <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                        </div>
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							<?= Yii::t('import', '选择文件') ?><input name="attachment" type="file" accept=".xls,.xlsx">
						</span>
					</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="btn-toolbar margin-bottom-10">
                    <button type="submit" class="btn btn-default btn-file"><?= Yii::t('import', '导入') ?></button>
                    <a download="" href="<?=$this->createUrl('/Stock/excel1405') ?>">
                        <button class="btn btn-default btn-file" type="button"><?= Yii::t('import', '模板下载') ?>
                        </button>
                    </a>
                </div>
            </div>
            <div class="row import-tab" id="abc">
                <div class="box">
                    <table id="data_import" class="table table-bordered dataTable">
                        <tr>
                            <th class="input_min"><input type="checkbox"></th>
                            <th class=""><?= $form->labelEx($sheetData[0][0], 'name', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0][0], 'model', array('class' => 'control-label')); ?></th>
                            <th class=""><?= CHtml::label(Yii::t('import', '数量'),'count',['class'=>'control-label'])?></th>
                            <th class=""><?= CHtml::label(Yii::t('import', '单价'),'count',['class'=>'control-label'])?></th>
                            <th class=""><?= $form->labelEx($sheetData[0][0], 'entry_subject', array('class' => 'control-label')); ?></th>
                        </tr>
                        <? foreach ($sheetData as $key => $row) {
                            $model = $row[0];
                            ?>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td><?= $form->textField($model, "[$key]name", array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]model", array('class' => 'form-control')); ?></td>
                                <td><?= CHtml::textField("Stock[$key][count]", $row['count'], array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]in_price", array('class' => 'form-control')); ?></td>
                                <td><?= $form->dropDownList($model, "[$key]entry_subject", $subject_array, array('class' => 'form-control')); ?></td>
                           </tr>
                        <?
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="form-group">
        <div class="col-sm-2">
            <span class=""><?= Yii::t('import', '库存商品期初余额') ?>:<label id="balance"><?= $balance_1405 ?></label></span>
            <span class=""><?= Yii::t('import', '合计') ?>:<label id="total"></label></span>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12 text-center">
            <?php echo CHtml::submitButton(Yii::t('import', '保 存'), array('class' => 'btn btn btn-primary',)); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>