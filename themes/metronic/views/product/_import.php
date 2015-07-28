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
$cs->registerScriptFile($baseUrl . '/assets/global/plugins/autosize/autosize.min.js');
$this->pageTitle = Yii::app()->name;
?>
<div class="dataTables_wrapper no-footer">
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
    <?
    $select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
    ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-md-4 col-sm-12">
                <div class="form-group">
                    <div class="input-group choose-btn-group">
                        <div class="input-icon">
                            <i class="fa fa-file fa-fw"></i>
                            <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                        </div>
					<span class="input-group-btn">
						<span class="btn btn-default btn-file">
							选择文件<input name="attachment" type="file" accept=".xls,.xlsx">
						</span>
					</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="btn-toolbar margin-bottom-10">
                    <button type="submit" class="btn btn-default btn-file">导入</button>
                    <a href="<?=$this->createUrl('/Stock/excel')?>">
                        <button class="btn btn-default btn-file" type="button"><strong>已生成的成本结转表下载</strong>
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="row import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered dataTable">
                <tr>
                    <th class="input_min"><input type="checkbox"></th>
                    <th class="input_mid">订单号</th>
                    <th class="input_mid">交易日期</th>
                    <th class="input_mid">名称</th>
                    <th class="input_min">包含物品</th>
                    <th class="input_min">对应数量</th>
                    <th class="input_mid">对应单价</th>
                    <th class="input_min">合计</th>
                    <th class="input-small">操作</th>
                    <th style="width: 10%">提示</th>
                </tr>
                <?php

                if (!empty($sheetData)) {
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>" readonly></td>
                            <td><input class="input_mid" type="text" value="<?= $item['order_no'] ?>" readonly></td>
                            <td><input class="input_mid no-dp" type="text" name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>" readonly></td>
                            <td><input class="input_mid" type="text" name="lists[<?= $key ?>][Transition][entry_name]"
                                       value="<?= $item['entry_name'] ?>" readonly></td>
                            <td>
                                <textarea class="input_min" name="lists[<?= $key ?>][Transition][stocks]" readonly><?= $item['stocks'] ?></textarea>
<!--                                <input class="input_min" type="text" name="lists[--><?//= $key ?><!--][Transition][stocks]"-->
<!--                                       value="--><?//= $item['stocks'] ?><!--">-->
                            </td>
                            <td>
                                <textarea class="input_min" name="lists[<?= $key ?>][Transition][stocks_count]" readonly><?= $item['stocks_count'] ?></textarea>
<!--                                <input class="input_min" type="text"name="lists[--><?//= $key ?><!--][Transition][stocks_count]"-->
<!--                                       value="--><?//= $item['stocks_count'] ?><!--" >-->
                            </td>
                            <td>
                                <textarea class="input_mid" name="lists[<?= $key ?>][Transition][stocks_price]" readonly><?= $item['stocks_price'] ?></textarea>
<!--                                <input class="input_min" type="text"name="lists[--><?//= $key ?><!--][Transition][stocks_price]"-->
<!--                                       value="--><?//= $item['stocks_price'] ?><!--">-->
                            </td>
                            <td>
                                <label id="tran_amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
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
                                            onclick="">确认
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
<!--                    <button class="btn btn-default btn-sm" id="btnAdd" name="btnAdd" type="button"-->
<!--                            onclick="addRow()"><span-->
<!--                            class="glyphicon glyphicon-add"></span> 插入新行-->
<!--                    </button>-->
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
//    $("div").delegate("[name*='stocks_count']", "blur", function () {
//        sumAmount2(this);
//    });
//    $("div").delegate("[name*='stocks_price']", "blur", function () {
//        sumAmount2(this);
//    });
    autosize($("textarea"));
</script>