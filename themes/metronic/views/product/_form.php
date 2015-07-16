<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$this->pageTitle = Yii::app()->name;
$type = 'purchase';
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
            ?>
            订单号：<? echo $item['order_no'] ?>
            <table class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input-xsmall">交易日期</th>
                    <th class="input-small">交易摘要</th>
                    <th class="input_mid">供应商</th>
                    <th class="input-xsmall">商品名称</th>
                    <th class="input_min">单价</th>
                    <th class="input_min">数量</th>
                    <th class="input_min">合计</th>
                    <th class="input-xsmall">税率</th>
                    <th class="input-small">采购用途</th>
                    <th class="input-xsmall">操作</th>
                    <th style="width: 10%">提示</th>
                </tr>
                <?php
                if (!empty($model)) {
                    $key = 1;
                    $clientArray = Client::model()->getClientArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('sale');
                    $arr = [6001];
                    $subjectArray = Transition::getSubjectArray($arr);
                    ?>
                    <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                   value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                        <td><input class="input-xsmall" type="text" id="tran_date_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_date]"
                                   value="<?= $item['entry_date'] ?>">
                        </td>
                        <td><textarea class="input-small" type="text" id="tran_memo_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_memo]"
                                   ><?= $item['entry_memo'] ?></textarea>
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

//                            $stockArray += ['劳务服务' => '劳务服务','缴纳税款' => '缴纳税款'];
//                            $this->widget('ext.select2.ESelect2', array(
//                                'name' => 'lists[' . $key . '][Transition][entry_name]',
//                                'id' => 'tran_entry_name_' . $key,
//                                'value' => $item['entry_name'],
//                                'data' => $stockArray,
//                                'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("stock",term,' . $key . ')}'),
//                                'htmlOptions' => array('class' => 'select-full',)
//                            ));
                            ?>
                            <input class="input-xsmall" type="text" id="tran_entry_name_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][entry_name]"
                                   value="<?= $item['entry_name'] ?>">
                        </td>
                        <td><input class="input_min" type="text" id="tran_price_<?= $key ?>" placeholder="单价"
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
                            //                                $data += ['商品采购' => '商品采购'];
                            $this->widget('ext.select2.ESelect2', array(
                                'name' => 'lists[' . $key . '][Transition][subject]',
                                'id' => 'tran_subject_' . $key,
                                'data' => $subjectArray,
                                'value' => $item['entry_subject'],
//                                    'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("subject",term,' . $key . ')}'),
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
                            <input type="hidden" id="client_id_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][client_id]"
                                   value="<?= $item['client_id'] ?>">
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

                                <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs"
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

                    ?>
                    <input type="hidden" id="rows" value="<?= $lines ?>">
                <?
                }
                ?>
                <tr id="trSetting" style="display: none">
                    <td colspan="100">
                        <div id="itemSetting" title="记账设置" class="box">
                            <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
                            <div id="setting">
                                <div class="options btn-group-xs">
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,1)"
                                            value="支出">支出
                                    </button>
                                    <br/>
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,2)"
                                            value="收入">收入
                                    </button>
                                </div>
                            </div>
                            <div class="actionSetting" style="margin-top: 20px;text-align: center;">
                                <button class="btn btn-success " type="button" onclick="itemSet()">确定</button>
                                <button class="btn btn-default" type="button" onclick="dialogClose()">取消</button>
                            </div>
                        </div>

                    </td>
                </tr>
            </table>
            <?
            if ($model->status_id == 1 && $item['entry_reviewed'] == 1) {
                ?>
                <span class="info-">该数据生成凭证已经审核，无法修改</span>
            <?
            } else {
                ?><div class="panel-footer">
                    <div class="form-group buttons text-center">
                        <input class="btn btn-primary btn-success" type="button" onclick="save()" value="保存凭证">

                    </div>
                </div>
            <?php
            }
            $this->endWidget();
            ?>

        </div>
    </div>

</div>