<?php
/* @var $this SalaryController */
/* @var $model Salary */
/* @var $form CActiveForm */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/function_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/salary.js');
$this->pageTitle = Yii::app()->name;
$type = 'salary';
$item = $sheetData[0]['data'];
?>
<div class="panel-body">
    <div class="row" id="abc">
        <div class="box">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('class' => 'form-horizontal',),
//                'action'=>Laofashi. $this->createUrl('/bank/default/update', array('id'=>$_GET['id'])),
            ));
            $employee = Employee::model()->findByPk($item['employee_id']);
            ?>
            <?= Yii::t('import', '姓名：') ?><?= $employee->name ?>&nbsp;&nbsp;&nbsp;<?= Yii::t('import', '月份：') ?><?= convertDate($item['entry_date'], Yii::t('import', 'Y年m月'))?>&nbsp;&nbsp;&nbsp;<?= Yii::t('import', '部门：') ?><?= Department::model()->getName($employee->department_id) ?>
            <table class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_mid"><?= Yii::t('import', '基本工资') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '奖金') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '应付工资') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '其他(福利等)') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '社保个人') ?></th>
                    <th class="input_min"><?= Yii::t('import', '公积金个人') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '税前工资') ?></th>
                    <th class="input_min"><?= Yii::t('import', '个人所得税') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '税后工资') ?></th>
                    <th class="input_min"><?= Yii::t('import', '社保公司') ?></th>
                    <th class="input_min"><?= Yii::t('import', '公积金公司') ?></th>
                    <th class="input-small"><?= Yii::t('import', '操作') ?></th>
                    <th style="width: 10%"><?= Yii::t('import', '提示') ?></th>
                </tr>
                <?php

                if (!empty($model)) {
                    $key = 1;
                    $clientArray = Client::model()->getClientArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('sale');
                    $arr = [6001];
                    $subjectArray = Transition::getSubjectArray($arr);
                    $before_tax = round2($item['salary_amount'] + $item['bonus_amount'] + $item['benefit_amount'] - $item['social_personal'] - $item['provident_personal']);
                    $after_tax = round2($before_tax - $item['personal_tax']);
                    ?>
                    <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                   value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                        <td><input class="input_min" type="text" id="tran_salary_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][salary_amount]"
                                   value="<?= $item['salary_amount'] ?>">
                        </td>
                        <td><input class="input_mmin" type="text" id="tran_bonus_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][bonus_amount]"
                                   value="<?= $item['bonus_amount'] ?>">
                        </td>
                        <td><input readonly="true" class="input_min" type="text" id="tran_total_amount_<?= $key ?>"
                                   value="<?= round2($item['salary_amount']+$item['bonus_amount']) ?>">
                        </td>
                        <td><input class="input_mmin" type="text" id="tran_benefit_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][benefit_amount]"
                                   value="<?= $item['benefit_amount'] ?>">
                        </td>
                        <td><input readonly="readonly" class="input_mmin" type="text" id="tran_social_personal_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][social_personal]"
                                   value="<?= $item['social_personal'] ?>">
                        </td>
                        <td><input readonly="readonly" class="input_mmin" type="text" id="tran_provident_personal_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][provident_personal]"
                                   value="<?= $item['provident_personal'] ?>">
                        </td>
                        <td><input readonly="readonly" class="input_min" type="text" id="tran_before_tax_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][before_tax]"
                                   value="<?= $before_tax ?>">
                        </td>
                        <td><input readonly="readonly" class="input_min" type="text" id="tran_personal_tax_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][personal_tax]"
                                   value="<?= $item['personal_tax'] ?>">
                        </td>
                        <td><input readonly="readonly" class="input_min" type="text" id="tran_after_tax_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][after_tax]"
                                   value="<?= $after_tax ?>">
                        </td>
                        <td><input readonly="readonly" class="input_mmin" type="text" id="tran_social_company_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][social_company]"
                                   value="<?= $item['social_company'] ?>">
                        </td>
                        <td><input readonly="readonly" class="input_mmin" type="text" id="tran_provident_company_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][provident_company]"
                                   value="<?= $item['provident_company'] ?>">
                        </td>
                        <td class="action hidden">
                            <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                   value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                            <input type="hidden" id="order_no_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][order_no]"
                                   value="<?= $item['order_no'] ?>">
                            <input type="hidden" id="base_amount_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][base_amount]"
                                   value="<?= $item['base_amount'] ?>">
                            <input type="hidden" id="tran_employee_id_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][employee_name]"
                                   value="<?= $item['employee_name'] ?>">
                            <data class="hidden">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="<?= $item['status_id'] ?>">
                                <input type="hidden" id="subject_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_subject]"
                                       value="<?= $item['entry_subject'] ?>">
                                <input type="hidden" id="entry_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                                <input type="hidden" id="entry_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['salary_amount'] + $item['bonus_amount'] + $item['benefit_amount'] ?>">
                                <input type="hidden" id="subject_2_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][subject_2]"
                                       value="<?= $item['subject_2'] ?>">
                                <input type="hidden" id="transaction_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_transaction]"
                                       value="<?= $item['entry_transaction'] ?>">
                                <input type="hidden" id="invoice_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][invoice]" value="<?= $item['invoice'] ?>">
                                <input type="hidden" id="withtax_<?= $key ?>" value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
                                <input type="hidden" id="parent_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][parent]" value="<?= $item['parent'] ?>">
                                <input type="hidden" id="additional_sbj0_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][0][subject]"
                                       value="<?= $item['additional'][0]['subject'] ?>">
                                <input type="hidden" id="additional_amount0_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][0][amount]"
                                       value="<?= $item['additional'][0]['amount'] ?>">
                                <input type="hidden" id="additional_sbj1_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][1][subject]"
                                       value="<?= $item['additional'][1]['subject'] ?>">
                                <input type="hidden" id="additional_amount1_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][additional][1][amount]"
                                       value="<?= $item['additional'][1]['amount'] ?>">
                            </data>

                            <div>

                                <button type="button" id="btn_confirm_<?= $key ?>" class="hidden btn btn-default"
                                        onclick=""><?= Yii::t('import', '确认') ?>
                                </button>

                                <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" disabled
                                        onclick=""><?= Yii::t('import', '删除') ?>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span id="info_<?= $key ?>" class="<?= !empty($item['error']) ? 'label-warning' : '' ?>">
                               <?
                               if (!empty($item['error'])) {
                                   foreach ($item['error'] as $err) {
                                       if (is_array($err))
                                           echo $err[0];
                                       else
                                           echo $err;
                                   }
                               }
                               ?>
                            </span>
                        </td>
                    </tr>
                    <?php
                    $lines = $key;

                    ?>
                    <input type="hidden" id="rows" value="<?= $lines ?>">
                <?
                }
                ?>

            </table>
            <?
            if ($model->status_id == 1 && $item['entry_reviewed'] == 1) {
                ?>
                <span class="info-"><?= Yii::t('import', '该数据生成凭证已经审核，无法修改') ?></span>
            <?
            } else {
                ?>
                <div class="panel-footer">
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span><?= Yii::t('import', '保存凭证') ?></button>
                    </div>
                </div>
            <?php
            }
            $this->endWidget();
            ?>

        </div>
    </div>

</div>