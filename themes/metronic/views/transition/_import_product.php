<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/product.js');
$this->pageTitle = Yii::app()->name;

$preOrder = Preparation::getOrderArray($type);
?>
<div class="dataTables_wrapper no-footer">
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
    <?
    $select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
    ?>
    <div class="row">
        <?
        $this->renderPartial('_import_navigate', array('type' => $type));
        ?>
    </div>
    <div class="row import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_mid">交易日期</th>
                    <th class="input-small">交易摘要</th>
                    <th class="input_mid">客户名称</th>
                    <th class="input_mid">商品/服务名称</th>
                    <th class="input_mid">单价</th>
                    <th class="input_min">数量</th>
                    <th class="input_min">合计</th>
                    <th class="input-small">税率</th>
                    <th class="input-small">销售类型</th>
                    <th class="input-small porder">预收款</th>
                    <th class="input-small">操作</th>
                    <th style="width: 10%">提示</th>
                </tr>
                <?php
                if (!empty($sheetData)) {
                    $clientArray = ['客户选择'] + Client::model()->getClientArray();
                    $stockArray = ['商品选择'] + Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('sale');
                    $arr = [6001];
                    $subjectArray = Transition::getSubjectArray($arr);
//                    $preOrder = ['PSO201501' => '{"amount":200,"memo":"说明1"}', 'PSO201502' => '{"amount":400,"memo":"说明2"}'];
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="input-small" type="text" id="tran_memo_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                            </td>
                            <td><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][entry_appendix_id]',
                                    'id' => 'tran_appendix_id_' . $key,
                                    'value' => $item['entry_appendix_id'],
                                    'data' => $clientArray,
                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("client",term,' . $key . ')}'),
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td><?

                                //                                $stockArray += ['劳务服务' => '劳务服务'];
                                //                                $this->widget('ext.select2.ESelect2', array(
                                //                                    'name' => 'lists[' . $key . '][Transition][entry_name]',
                                //                                    'id' => 'tran_entry_name_' . $key,
                                //                                    'value' => $item['entry_name'],
                                //                                    'data' => $stockArray,
                                //                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("stock",term,' . $key . ')}'),
                                //                                    'htmlOptions' => array('class' => 'select-full',)
                                //                                ));
                                ?>
                                <input class="input-small" type="text" id="tran_entry_name_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_name]"
                                       value="<?= $item['entry_name'] ?>">
                            </td>
                            <td><input class="input_mid" type="text" id="tran_price_<?= $key ?>" placeholder="单价"
                                       name="lists[<?= $key ?>][Transition][price]" onkeyup="checkinput1(this)"
                                       onblur="checkinput1(this)" value="<?= $item['price'] ?>">
                            </td>
                            <td><input class="input_min" type="number" min="1" id="tran_count_<?= $key ?>"
                                       placeholder="数量"
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
                                    <input type="hidden" id="client_id_<?= $key ?>"
                                           name="lists[<?= $key ?>][Transition][client_id]"
                                           value="<?= $item['client_id'] ?>">
                                    <input type="hidden" id="transaction_<?= $key ?>"
                                           name="lists[<?= $key ?>][Transition][entry_transaction]"
                                           value="<?= $item['entry_transaction'] ?>">
                                    <input type="hidden" id="invoice_<?= $key ?>"
                                           name="lists[<?= $key ?>][Transition][invoice]"
                                           value="<?= $item['invoice'] ?>">
                                    <input type="hidden" id="withtax_<?= $key ?>"
                                           value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
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
                                            onclick="itemSetDefault(this, '<?= $type ?>')">确认
                                    </button>

                                    <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" disabled
                                            onclick="itemclose(this)"><i class="fa fa-times"></i>删除
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
                            onclick="addProduct()"><span
                            class="glyphicon glyphicon-add"></span> 插入新行
                    </button>
                </p>
            </div>

        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<div class="panel-footer">
    <div class="text-center">
        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> 保存凭证
        </button>
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