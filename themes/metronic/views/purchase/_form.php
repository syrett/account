<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/purchase.js');
$this->pageTitle = Yii::app()->name;
$type = 'purchase';
$item = $sheetData[0]['data'];
$preOrder = Preparation::getPreOrder('vendor', $item['vendor_id']);
$item['preorder'] = Preparation::getOrderArray($type, $item['id']);
$preOrder = $item['preorder'] + $preOrder;
//{"purchase":"1"}
$relation = Bank::model()->findByAttributes([],"relation like '%\"$type\":\"$model->id\"%'");
?>
<div class="panel-body">
    <div class="row import-tab" id="abc">
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
            <table class="table table-bordered dataTable min">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_mid"><?= Yii::t('import', '交易日期') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '交易摘要') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '供应商名称') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '商品/服务名称') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '型号') ?></th>
                    <th class="input_min"><?= Yii::t('import', '单价') ?></th>
                    <th class="input_min"><?= Yii::t('import', '数量') ?></th>
                    <th class="input_mid"><?= Yii::t('import', '税率') ?></th>
                    <th class="input-small"><?= Yii::t('import', '采购用途') ?></th>
                    <th class="input_mid hidden" id="department_id_th" ><?= Yii::t('import', '部门') ?></th>
                    <?
                    if (!empty($preOrder)) {
                        echo '<th class="input-small">'.Yii::t('import', '预付款').'</th>';
                    }
                    ?>
                    <th style="width: 150px"><?= Yii::t('import', '操作') ?></th>
                    <th style="width: 10%"><?= Yii::t('import', '提示') ?></th>
                </tr>
                <?php
                if (!empty($model)) {
                    $key = 1;
                    $vendorArray = Vendor::model()->getVendorArray();
                    $stockArray = Stock::model()->getStockArray();
                    $taxArray = Transition::getTaxArray('purchase');
                    $arr = [1601, 1403, 1405, 6602, 6601, 6401, 1701];
                    $subjectArray = Transition::getSubjectArray($arr);
                    $subjectArray += ProjectB::model()->getProject();
                    $subjectArray += ProjectLong::model()->getProject();
                    $departmentArray = Department::model()->getDepartmentArray();
                    ?>
                    <tr line="<?= $key ?>" class="table-tr <?= $item['status_id']==1?'':'label-danger'?>">
                        <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                   value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                        <td><input class="input_mid date-picker" type="text" id="tran_date_<?= $key ?>"
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
                                'value' => $item['vendor_id'],
                                'data' => $vendorArray,
                                'options' => array('formatNoMatches' => 'js:function(term){return Not_Found("vendor",term,' . $key . ')}'),
                                'htmlOptions' => array('class' => 'select-full',)
                            ));
                            ?>
                        </td>
                        <td><?
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
                        <td><input class="input_mid" type="text" id="tran_model_<?= $key ?>" placeholder="<?= Yii::t('import', '型号') ?>"
                                   name="lists[<?= $key ?>][Transition][model]"
                                   value="<?= $item['model'] ?>">
                        </td>
                        <td><input class="input_min" type="text" id="tran_price_<?= $key ?>" placeholder="<?= Yii::t('import', '单价') ?>"
                                   name="lists[<?= $key ?>][Transition][price]"
                                   value="<?= $item['price'] ?>">
                        </td>
                        <td><input class="input_min" type="number" id="tran_count_<?= $key ?>" placeholder="<?= Yii::t('import', '数量') ?>"
                                   name="lists[<?= $key ?>][Transition][count]"
                                   value="<?= $item['count'] ?>">
                        </td>
                        <td><?
                            $this->widget('ext.select2.ESelect2', array(
                                'name' => 'lists[' . $key . '][Transition][tax]',
                                'id' => 'tran_tax_' . $key,
                                'value' => $item['tax'],
                                'data' => $taxArray,
                            ));
                            ?>
                        </td>
                        <td><?
                            $sbj = isset($item['subject'])?$item['entry_subject'] : Yii::t('import', '商品采购');
                            $this->widget('ext.select2.ESelect2', array(
                                'name' => 'lists[' . $key . '][Transition][subject]',
                                'id' => 'tran_subject_' . $key,
                                'data' => $subjectArray,
                                'value' => '_'. $sbj,
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
                        <?
                        if (!empty($preOrder)) {
                            //添加一项 不含预付款的选项
//                            $preOrder = ['非预付款' => '{"amount":0,"memo":"非预付款"}'] + $preOrder;
                            ?>
                            <td><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][preOrder]',
                                    'id' => 'preOrder_' . $key,
                                    'data' => $preOrder,
                                    'value' => array_keys($item['preorder']),
                                    'options' => array(
                                        'formatResult' => 'js:function(data){
                                            var order = JSON.parse(data.text);
                                            var markup = \'<div class="popovers" data-placement="left" data-container="body" data-trigger="hover" data-html="true"  data-original-title="\' + order.date +\'"\'
                                            + \'data-content="'.Yii::t('import', '余额:').'\' + order.amount + \''.Yii::t('import', '<br>摘要:').'\' + order.memo + \'">\' + data.id + \'</div><script>$(".popovers").popover();<\/script>\';
                                            return markup;
                                        }',
                                        'formatSelection' => 'js: function(order) {
                                            $("[id*=\'popover\']").remove()
                                            return order.id;
                                        }',
                                        'formatNoMatches' => ''
                                    ),
                                    'htmlOptions' => array('class' => 'select-full','multiple'=>'multiple',)
                                ));
                                ?>
                            </td>
                        <?
                        }
                        ?>
                        <td class="action">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="order_no_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][order_no]"
                                       value="<?= $item['order_no'] ?>">
                            <input type="hidden" id="hs_no_<?= $key ?>"
                                   name="lists[<?= $key ?>][Transition][hs_no]"
                                   value="<?= $item['hs_no'] ?>">
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="<?= $item['status_id'] ?>">
                            <data class="hidden">
                            <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
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

                                <button type="button" id="btn_confirm_<?= $key ?>" class="btn btn-default hidden"
                                        onclick="itemSetDefault(this, '<?= $type ?>')"><?= Yii::t('import', '确认') ?>
                                </button>
                                <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs"
                                        onclick="itemInvalid(this)"><i class="fa fa-times"></i><?= Yii::t('import', '作废') ?>
                                </button>
                            </div>
                        </td>
                        <td>
                            <span id="info_<?= $key ?>" class="<?= !empty($item['error']) ? 'info_warning' : '' ?>">
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
                        <div id="itemSetting" title="<?= Yii::t('import', '记账设置') ?>" class="box">
                            <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
                            <div id="setting">
                                <div class="options btn-group-xs">
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,1)"
                                            value="<?= Yii::t('import', '支出') ?>"><?= Yii::t('import', '支出') ?>
                                    </button>
                                    <br/>
                                    <button class="btn btn-default" type="button" onclick="chooseType(this,2)"
                                            value="<?= Yii::t('import', '收入') ?>"><?= Yii::t('import', '收入') ?>
                                    </button>
                                </div>
                            </div>
                            <div class="actionSetting" style="margin-top: 20px;text-align: center;">
                                <button class="btn btn-success " type="button" onclick="itemSet()"><?= Yii::t('import', '确定') ?></button>
                                <button class="btn btn-default" type="button" onclick="dialogClose()"><?= Yii::t('import', '取消') ?></button>
                            </div>
                        </div>

                    </td>
                </tr>
            </table>
            <?
            if (($model->status_id == 1 && $item['entry_reviewed'] == 1 )|| $relation != null) {
                ?>
                <span class="info-"><?= Yii::t('import', '该数据生成凭证已经审核，或和其他数据有关联，无法修改') ?></span>
            <?
            } else {
                ?><div class="panel-footer">
                    <div class="text-center">
                        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> <?= Yii::t('import', '保存凭证') ?></button>
                    </div>
                </div>
            <?php
            }
            $this->endWidget();
            ?>

        </div>
    </div>

</div>
<script>
    $(window).load(function () {
//如果是固定资产，需要选择使用部门
        var arr = Array('1601', '1801', '1701');
        $("div").delegate("select[id*='tran_subject_']", "change", function () {
            var department_id_show = false;
            $.each($("select[id*='tran_subject_']"), function (key, obj) {
                var sbj = $(obj).val();
                var row = key;
                if (in_array(sbj.substr(1, 4), arr)) {
                    department_id_show = true;
                    $("select[id='department_id_" + row + "']").select2();
                } else
                    $("select[id='department_id_" + row + "']").select2("destroy").hide();
            })
            if (department_id_show) {
                $("[id*='department_id_']").removeClass("hidden");
            } else
                $("[id*='department_id_']").addClass("hidden");
        })
        var sbj = $("select[id*='tran_subject_']").val();
        if (in_array(sbj.substr(1, 4), arr)) {
            $("select[id='department_id_0']").select2();
            $("[id*='department_id_']").removeClass("hidden");
        }


    })
</script>