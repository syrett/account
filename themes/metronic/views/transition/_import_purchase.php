<?php
/* @var $this PurchaseController */
/* @var $model Purchase */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/purchase.js');
$this->pageTitle = Yii::app()->name;
?>
<div class="dataTables_wrapper no-footer">
    <div class="row">
        <a id="first" href="#large" data-toggle="modal" value="<?= $option ?>"></a>
        <?
        $this->renderPartial('_import_navigate', array('type' => $type));
        ?>
    </div>
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
    <?
    $select = '<option value=1 >'.Yii::t('import', '日期').'</option><option value=2 >'.Yii::t('import', '交易说明').'</option><option value=3 >'.Yii::t('import', '金额').'</option>';
    ?>
    <div class="row import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered dataTable min">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_min"><?= Yii::t('import', '交易日期') ?></th>
                    <th class="input_min"><?= Yii::t('import', '交易摘要') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '供应商名称') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '商品') ?>/<?= Yii::t('import', '服务名称') ?></th>
                    <th class="input_mmmin"><?= Yii::t('import', '型号') ?></th>
                    <th class="input_mmin"><?= Yii::t('import', '单价') ?></th>
                    <th class="input_mmmin"><?= Yii::t('import', '数量') ?></th>
                    <th class="input_min"><?= Yii::t('import', '合计') ?></th>
                    <th class="input-small"><?= Yii::t('import', '税率') ?></th>
                    <th class="input-small"><?= Yii::t('import', '采购用途') ?></th>
                    <th class="input_mid hidden" id="department_id_th" ><?= Yii::t('import', '部门') ?></th>
                    <th class="input-small porder"><?= Yii::t('import', '预付款') ?></th>
                    <th class="input-small"><?= Yii::t('import', '操作') ?></th>
                    <th style="width: 10%"><?= Yii::t('import', '提示') ?></th>
                </tr>
                <?php
                if (!empty($sheetData)) {
                    $vendorArray = [Yii::t('import', '供应商选择')] + Vendor::model()->getVendorArray();
                    $stockArray = [Yii::t('import', '选择或新建')] + Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('purchase');
                    $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
                    $subjectArray = Transition::getSubjectArray($arr);
                    $subjectArray += ProjectB::model()->getProject();
                    $subjectArray += ProjectLong::model()->getProject();
                    $departmentArray = Department::model()->getDepartmentArray();
//                    $preOrder = Preparation::getOrderArray($type);
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input class="input_min" type="text" id="tran_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="input_min" type="text" id="tran_memo_<?= $key ?>" placeholder="<?= Yii::t('import', '摘要') ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                            </td>
                            <td><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][entry_appendix_id]',
                                    'id' => 'tran_appendix_id_' . $key,
                                    'value' => $item['entry_appendix_id'],
                                    'data' => $vendorArray,
                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("vendor",term,' . $key . ')}'),
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td><?
                                if ($item['entry_name']!='' && !in_array($item['entry_name'], $stockArray)) {
                                    $stockArray += [$item['entry_name'] => $item['entry_name']];
                                }
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][entry_name]',
                                    'id' => 'tran_entry_name_' . $key,
                                    'value' => $item['entry_name'],
                                    'data' => $stockArray,
                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("stock",term,' . $key . ')}'),
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td><input class="input_mmin" type="text" id="tran_model_<?= $key ?>" placeholder="<?= Yii::t('import', '型号') ?>"
                                       name="lists[<?= $key ?>][Transition][model]" value="<?= $item['model'] ?>">
                            </td>
                            <td><input class="input_mmin" type="text" id="tran_price_<?= $key ?>" placeholder="<?= Yii::t('import', '单价') ?>"
                                       name="lists[<?= $key ?>][Transition][price]" onkeyup="checkinput1(this)"
                                       onblur="checkinput1(this)" value="<?= is_numeric($item['price']) ? $item['price'] : ''; ?>">
                            </td>
                            <td><input class="input_mmmin" type="number" min="1" id="tran_count_<?= $key ?>"
                                       placeholder="<?= Yii::t('import', '数量') ?>"
                                       name="lists[<?= $key ?>][Transition][count]" onkeyup="checkinput2(this)"
                                       onblur="checkinput1(this)" value="<?= $item['count'] ?>">
                            </td>
                            <td>
                                <label id="tran_amount_<?= $key ?>"><?= $item['price'] * $item['count'] ?></label>
                            </td>
                            <td><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][tax]',
                                    'id' => 'tran_tax_' . $key,
                                    'value' => $item['tax'],
                                    'data' => $taxArray,
                                    'htmlOptions' => array('class' => 'select-full')
                                ));
                                ?>
                            </td>
                            <td><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][subject]',
                                    'id' => 'tran_subject_' . $key,
                                    'data' => $subjectArray,
                                    'value' => $item['entry_subject'],
                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("subject",term,' . $key . ')}'),
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td class="hidden" id="department_id_td"><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][department_id]',
                                    'id' => 'department_id_' . $key,
                                    'data' => $departmentArray,
                                    'value' => $item['department_id'],
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td class="porder">
                                <select id="preOrder_<?=$key?>" name = 'lists[<?= $key ?>][Transition][preOrder][]' multiple="multiple"
                                        class="select-full psorder" ></select>
                            </td>
                            <td class="action">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="order_no_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][order_no]"
                                       value="<?= $item['order_no'] ?>">
                                <data class="hidden">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="<?= $item['status_id'] ?>">
                                <input type="hidden" id="subject_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_subject]"
                                       value="<?= $item['entry_subject'] ?>">
                                <input type="hidden" id="entry_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>">
                                <input type="hidden" id="subject_2_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][subject_2]"
                                       value="<?= $item['subject_2'] ?>">
                                <input type="hidden" id="vendor_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][vendor_id]"
                                       value="<?= $item['vendor_id'] ?>">
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
                                            onclick="itemSetDefault(this, '<?= $type ?>')"><?= Yii::t('import', '确认') ?>
                                    </button>

                                    <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" disabled
                                            onclick="itemclose(this)"><i class="fa fa-times"></i><?= Yii::t('import', '删除') ?>
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
                <p>
                    <button class="btn btn-default btn-sm" id="btnAdd" name="btnAdd" type="button"
                            onclick="addPurchase()"><span
                            class="glyphicon glyphicon-add"></span> <?= Yii::t('import', '插入新行') ?>
                    </button>
                </p>
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
