<?php
/* @var $this TransitionController */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/function_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/salary.js');
$this->pageTitle = Yii::app()->name;

?>
<div class="dataTables_wrapper no-footer">
    <?
    $select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
    ?>
    <div class="row">
        <a id="first" href="#large" data-toggle="modal" value="<?= $option ?>"></a>
        <?
        $this->renderPartial('_import_navigate', array('type' => $type));
        ?>
    </div>
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
    <div class="row import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"   ><input type="checkbox"></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '姓名') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '部门') ?></th>
                    <th class="input_min"   ><?= Yii::t('import', '基本工资') ?></th>
<!--                    <th class="input_min"   ><?= Yii::t('import', '社保基数') ?></th>-->
                    <th class="input_mmin"  ><?= Yii::t('import', '奖金') ?></th>
                    <th class="input_min"   ><?= Yii::t('import', '应付工资') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '其他(福利等)') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '社保个人部分') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '公积金个人部分') ?></th>
                    <th class="input_min"   ><?= Yii::t('import', '税前工资') ?></th>
                    <th class="input_min"   ><?= Yii::t('import', '个人所得税') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '税后工资') ?></th>
                    <th class="input_min"   ><?= Yii::t('import', '社保公司部分') ?></th>
                    <th class="input_mmin"  ><?= Yii::t('import', '公积金公司部分') ?></th>
<!--                    <th class="input_min"><?= Yii::t('import', '操作') ?></th>-->
                    <th style="width: 10%"><?= Yii::t('import', '提示') ?></th>
                </tr>
                <?php

                $this->widget('ext.select2.ESelect2', array(
                    'name' => '',
                    'htmlOptions' => array('class' => 'hidden',)
                ));
                if (!empty($sheetData)) {
                    $clientArray = Client::model()->getClientArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('sale');
                    $arr = [6001,6301,6051];
                    $subjectArray = Transition::getSubjectArray($arr,['type'=>2]);
                    $date = $sheetData[0]['entry_date'];
                    echo $date!=''?convertDate($date, 'Y年m月'). " 工资":"";
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_employee_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][employee_name]"
                                       value="<?= $item['employee_name'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_department_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][department_name]"
                                       value="<?= $item['department_name'] ?>">
                            </td>
                            <td><input class="form-control input_min" type="text" id="tran_salary_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][salary_amount]"
                                       value="<?= $item['salary_amount'] ?>">
                            </td>
                            <td><input class="form-control input_mmin" type="text" id="tran_bonus_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][bonus_amount]"
                                       value="<?= $item['bonus_amount'] ?>">
                            </td>
                            <td><input readonly="true" class="form-control input_min" type="text" id="tran_total_amount_<?= $key ?>"
                                       value="<?= round2($item['salary_amount']+$item['bonus_amount']) ?>">
                            </td>
                            <td><input class="form-control input_mmin" type="text" id="tran_benefit_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][benefit_amount]"
                                       value="<?= $item['benefit_amount'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_social_personal_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][social_personal]"
                                       value="<?= $item['social_personal'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_provident_personal_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][provident_personal]"
                                       value="<?= $item['provident_personal'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_min" type="text" id="tran_before_tax_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][before_tax]"
                                       value="<?= $item['before_tax'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_min" type="text" id="tran_personal_tax_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][personal_tax]"
                                       value="<?= $item['personal_tax'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_min" type="text" id="tran_after_tax_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][after_tax]"
                                       value="<?= $item['after_tax'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_social_company_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][social_company]"
                                       value="<?= $item['social_company'] ?>">
                            </td>
                            <td><input readonly="readonly" class="form-control input_mmin" type="text" id="tran_provident_company_<?= $key ?>"
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
                                <input type="hidden" id="base_2_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][base_2_amount]"
                                       value="<?= $item['base_2_amount'] ?>">
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
                                           value="<?= $item['entry_amount'] ?>">
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
                                            onclick=""></i><?= Yii::t('import', '删除') ?>
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
                    }
                    ?>
                    <input type="hidden" id="rows" value="<?= $lines ?>">
                <?
                }
                ?>

            </table>

            <div class="transition_action">
            </div>

        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<div class="panel-footer">
    <div class="text-center">
        <button class="btn btn-warning" onclick="javascript:$('#first').click();"><span class="glyphicon glyphicon-repeat"></span> <?= Yii::t('import', '重新导入') ?>
        </button>
        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> <?= Yii::t('import', '保存凭证') ?></button>
    </div>
</div>
<script>
    function Not_Found(type, term, line) {
        var $not_found = '<div class="nomatch"><a href="#" onclick="return create(\'' + type + '\',\'' + term + '\', \'' + line + '\')">' + term + '  <span>新建</span></a></div>';
        return $not_found;
    }
    function create(type, term, line) {
        if (type == "client") {
            var data = {
                name: term
            }
            var client = createClient(data);
            if (client != '0' && $("select[id*='tran_appendix_id_'] option[value='" + client + "']").length == 0) {
                $("select[id*='tran_appendix_id_']").append($("<option></option>").attr("value", client).text(term));
                $("select[id*='tran_appendix_id_']").select2("updateResults");
            }
            $("select[id*='tran_appendix_id_']").select2("close");
            $("select[id*='tran_appendix_id_" + line + "']").select2("val", client);
        } else if (type == "stock") {
            $("select[id*='tran_entry_name_']").append($("<option></option>").attr("value", term).text(term));
            $("select[id*='tran_entry_name_']").select2("updateResults");
            $("select[id*='tran_entry_name_']").select2("close");
            $("select[id*='tran_entry_name_" + line + "']").select2("val", term);
        } else if (type == "subject") {
            var data = {
                name: term,
                subject: 1122
            }
            var subject = createSubject(data);
            if (subject != '0' && $("select[id*='tran_subject_'] option[value='" + subject + "']").length == 0) {
                $("select[id*='tran_subject_']").append($("<option></option>").attr("value", subject).text(term));
                $("select[id*='tran_subject_']").select2("updateResults");
            }
            $("select[id*='tran_appendix_id_']").select2("close");
            $("select[id*='tran_appendix_id_" + line + "']").select2("val", subject);

        }
    }
</script>