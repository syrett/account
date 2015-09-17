<?php
/* @var $this TransitionController */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
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
<!--                    <th class="input_min"   ><input type="checkbox"></th>-->
                    <th class="input_mmin"  >姓名</th>
                    <th class="input_mmin"  >部门</th>
                    <th class="input_min"   >时间</th>
                    <th class="input_min"   >摘要</th>
                    <th class="input_mmmin" >差旅费</th>
                    <th class="input_mmmin" >福利费<br>餐费等</th>
                    <th class="input_mmmin" >交通费</th>
                    <th class="input_mmmin" >通讯费</th>
                    <th class="input_mmmin" >招待费</th>
                    <th class="input_mmmin" >办公费</th>
                    <th class="input_mmmin" >租金</th>
                    <th class="input_mmmin" >水电费</th>
                    <th class="input_mmmin" >培训费</th>
                    <th class="input_mmmin" >服务费</th>
                    <th class="input_mmmin" >印花税</th>
                    <?
                    if (!empty($preOrder)) {
                        echo '<th class="input-small">预支款</th>';
                    }
                    ?>
<!--                    <th class="input_min">操作</th>-->
                    <th style="width: 10%">提示</th>
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
//                    echo $date!=''?convertDate($date, 'Y年m月'). " 报销":"";
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
<!--                            <td><input class="" type="checkbox" id="item_--><?//= $key ?><!--" name="lists[--><?//= $key ?><!--]"-->
<!--                                       value="--><?//= isset($item['id']) ? $item['id'] : '' ?><!--"></td>-->
                            <td><input readonly="readonly" class="input_mmin" type="text" id="tran_employee_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][employee_name]"
                                       value="<?= $item['employee_name'] ?>">
                            </td>
                            <td><input readonly="readonly" class="input_mmin" type="text" id="tran_department_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][department_name]"
                                       value="<?= $item['department_name'] ?>">
                            </td>
                            <td><input class="input_min" type="text" id="tran_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="input_min" type="text" id="tran_memo_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_travel_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][travel_amount]"
                                       value="<?= $item['travel_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_benefit_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][benefit_amount]"
                                       value="<?= $item['benefit_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_traffic_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][traffic_amount]"
                                       value="<?= $item['traffic_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_phone_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][phone_amount]"
                                       value="<?= $item['phone_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_entertainment_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entertainment_amount]"
                                       value="<?= $item['entertainment_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_office_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][office_amount]"
                                       value="<?= $item['office_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_rent_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][rent_amount]"
                                       value="<?= $item['rent_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_watere_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][watere_amount]"
                                       value="<?= $item['watere_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_train_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][train_amount]"
                                       value="<?= $item['train_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_service_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][service_amount]"
                                       value="<?= $item['service_amount'] ?>">
                            </td>
                            <td><input class="input_mmmin" type="text" id="tran_stamping_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][stamping_amount]"
                                       value="<?= $item['stamping_amount'] ?>">
                            </td>
                            <?
                            if (!empty($preOrder)) {
                                ?>
                                <td><?
                                    $this->widget('ext.select2.ESelect2', array(
                                        'name' => 'lists[' . $key . '][Transition][preOrder]',
                                        'id' => 'preOrder_' . $key,
                                        'data' => $preOrder,
                                        'value' => $item['preOrder'],
                                        'options' => array(
                                            'formatResult' => 'js:function(data){
                                            var order = JSON.parse(data.text);
                                            var markup = \'<div class="popovers" data-placement="left" data-container="body" data-trigger="hover" data-html="true"  data-original-title="\' + order.date +\'"\'
                                            + \'data-content="余额:\' + order.amount + \'<br>摘要:\' + order.memo + \'">\' + data.id + \'</div><script>$(".popovers").popover();<\/script>\';
                                            return markup;
                                        }',
                                            'formatSelection' => 'js: function(order) {
                                            $("[id*=\'popover\']").remove()
                                            return order.id;
                                        }',
                                            'formatNoMatches' => ''
                                        ),
                                        'htmlOptions' => array('class' => 'select-full','multiple'=>'multiple')
                                    ));
                                    ?>
                                </td>
                            <?
                            }
                            ?>
                            <td class="action hidden">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="order_no_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][order_no]"
                                       value="<?= $item['order_no'] ?>">
                                <input type="hidden" id="base_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][base_amount]"
                                       value="<?= $item['base_amount'] ?>">
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
                                            onclick="">确认
                                    </button>

                                    <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" disabled
                                            onclick=""></i>删除
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
        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> 保存凭证</button>
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