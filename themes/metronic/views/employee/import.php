<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle = Yii::app()->name . Yii::t('import', ' - 员工管理');
$this->breadcrumbs = array(
    Yii::t('import', '员工列表'),
    Yii::t('import', '添加员工')
);

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/filechoose.js', CClientScript::POS_END);
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

$department_array = Employee::model()->listDepartment();
?>
    <div class="portlet light">

        <?php
        foreach (Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        }
        ?>
        <div class="portlet-title">
            <div class="caption">
                <span class="font-green-sharp"><?= Yii::t('import', '批量添加员工') ?></span>
            </div>
            <div class="actions">
                <?php
                echo CHtml::link('<i class="fa fa-bars"></i> '.Yii::t('import', '员工列表'), array('admin'), array('class' => 'btn btn-circle btn-primary btn-sm'));
                ?>
                <a href="javascript:;" class="btn btn-circle btn-default btn-icon-only fullscreen"
                   data-original-title=""
                   data-original-title title="<?= Yii::t('import', '全屏') ?>"></a>
            </div>
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
                    <a download="" href="/download/员工导入.xlsx">
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
                            <th class=""><?= $form->labelEx($sheetData[0], 'name', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0], 'department.name', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0], 'base', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0], 'base_2', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0], 'position', array('class' => 'control-label')); ?></th>
                            <th class=""><?= $form->labelEx($sheetData[0], 'memo', array('class' => 'control-label')); ?></th>
                            <th><?=Yii::t('import', '提示') ?></th>
                        </tr>
                        <? foreach ($sheetData as $key => $model) {
                            ?>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td><?= $form->textField($model, "[$key]name", array('class' => 'form-control')); ?></td>
                                <td><?= $form->dropDownList($model, "[$key]department_id", $department_array, array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]base", array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]base_2", array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]position", array('class' => 'form-control')); ?></td>
                                <td><?= $form->textField($model, "[$key]memo", array('class' => 'form-control')); ?></td>
                                <td><?
                                    echo $form->error($model, "[$key]name");
                                    ?></td>
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
        <div class="col-sm-offset-2 col-sm-10 text-center">
            <?php echo CHtml::submitButton(Yii::t('import', '保存'), array('class' => 'btn btn-circle btn-primary',)); ?>
        </div>
    </div>
<?php $this->endWidget(); ?>