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
$this->pageTitle = Yii::app()->name;
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
                    <th class="input_mid">交易摘要</th>
                    <th class="input_mid">供应商名称</th>
                    <th class="input_mid">商品/服务名称</th>
                    <th class="input_mid">单价</th>
                    <th class="input_min">数量</th>
                    <th class="input_min">合计</th>
                    <th class="input-small">税率</th>
                    <th class="input-small">采购用途</th>
                    <th class="input_mid hidden" id="department_id_th" >部门</th>
                    <th class="input-small">操作</th>
                    <th style="width: 10%">提示</th>
                </tr>
                <?php
                if (!empty($sheetData)) {
                    $vendorArray = Vendor::model()->getVendorArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('purchase');
                    $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701, 1604, 1801];
                    $subjectArray = Transition::getSubjectArray($arr);
                    $departmentArray = Department::model()->getDepartmentArray();
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="input_mid" type="text" id="tran_memo_<?= $key ?>"
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
                            onclick="addRow()"><span
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
        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> 保存凭证</button>
    </div>
</div>
<script>
    function Not_Found(type, term, line) {
        var $not_found = '<div class="nomatch"><a href="#" onclick="return create(\'' + type + '\',\'' + term + '\', \'' + line + '\')">' + term + '  <span>新建</span></a></div>';
        return $not_found;
    }
    function create(type, term, line) {
        if (type == "vendor") {
            var data = {
                name: term
            }
            var vendor = createVendor(data);
            if (vendor != '0' && $("select[id*='tran_appendix_id_'] option[value='" + vendor + "']").length == 0) {
                $("select[id*='tran_appendix_id_']").append($("<option></option>").attr("value", vendor).text(term));
                $("select[id*='tran_appendix_id_']").select2("updateResults");
            }
            $("select[id*='tran_appendix_id_']").select2("close");
            $("select[id*='tran_appendix_id_" + line + "']").select2("val", vendor);
        } else if (type == "stock") {
            $("select[id*='tran_entry_name_']").append($("<option></option>").attr("value", term).text(term));
            $("select[id*='tran_entry_name_']").select2("updateResults");
            $("select[id*='tran_entry_name_']").select2("close");
            $("select[id*='tran_entry_name_" + line + "']").select2("val", term);
        } else if (type == "subject") {
            var data = {
                name: term,
                subject: 1405
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
    var arr = Array('1601', '1801', '1701');
    $(window).load(function() {
        //如果是固定资产，需要选择使用部门
        $("div").delegate("select[id*='tran_subject_']","change",function(){
            var department_id_show = false;
            $.each($("select[id*='tran_subject_']"),function(key,obj){
                var sbj = $(obj).val();
                var row = key;
                if(in_array(sbj.substr(1,4), arr)){
                    department_id_show = true;
                    $("select[id='department_id_"+row+"']").select2();
                }else
                    $("select[id='department_id_"+row+"']").select2("destroy").hide();
            })
            if(department_id_show){
                $("[id*='department_id_']").removeClass("hidden");
            }else
                $("[id*='department_id_']").addClass("hidden");
        });

        $.each($("select[id*='tran_subject_']"), function (key, obj) {
            var sbj = $(obj).val();
            var row = key;
            if (in_array(sbj.substr(1, 4), arr)) {
                $("[id*='department_id_']").removeClass("hidden");
                $("select[id='department_id_" + row + "']").select2();
            } else
                $("select[id='department_id_" + row + "']").select2("destroy").hide();
        })
    })
</script>