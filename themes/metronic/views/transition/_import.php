<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

Yii::import('ext.select2.ESelect2', true);
//Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$baseUrl = Yii::app()->theme->baseUrl;
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_common.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/bank.js');
$cs->registerScriptFile($baseUrl . '/assets/global/plugins/colResizable/js/colResizable.min.js');

$departmentArray = Department::model()->getDepartmentArray();
$clientArray = Client::model()->getClientArray();
$this->pageTitle = Yii::app()->name;
$tranDate = $this->getTransitionDate('post');
/*if(!isset($model)){
  $model = array();
  $model[0]=new Transition();
  }*/
?>


<div class="dataTables_wrapper no-footer">
    <div class="row">
        <a id="first" href="#large" data-toggle="modal" value="<?= $option ?>"></a>
        <?
        $this->renderPartial('_import_navigate'.($type=='bank'?'_bank':''), array('type' => $type));
        ?>
    </div>
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form', 'class' => 'form-horizontal']); ?>

    <div class="row">
        <div class="col-xs-12">
            <div class="col-md-4 col-sm-12">
            </div>
            <div class="col-md-3 col-sm-12">
            </div>

        </div>
    </div>
    <div class="import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered table-striped table-hover" id="import_table">
                <tr>
                    <th class="table_checkbox"><input type="checkbox" class="group-checkable"
                                                      data-set="#import_table .checkboxes"></th>
                    <th class="input_mid">交易对方名称</th>
                    <th class="input_full">商品/服务</th>
                    <th class="input_mid hidden" id="department_id_th">部门</th>
                    <th class="input_mid hidden" id="client_id_th">客户</th>
                    <th class="input_mid">日期</th>
                    <th class="input_full">摘要</th>
                    <th class="input_full">金额</th>
                    <th style="width: 200px">操作</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                <?php
                if (!empty($sheetData)) {
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr odd greadX"' : '' ?>>
                            <td><input type="checkbox" class="checkboxes" value="1" id="item_<?= $key ?>"
                                       name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input type="text" id="tran_target_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][target]" placeholder="对方名称"
                                       value="<?= isset($item['target']) ? $item['target'] : '' ?>"
                                       class="form-control input_mid2">
                            </td>
                            <td><input type="text" id="tran_name_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_name]" placeholder="名称"
                                       value="<?= $item['entry_name'] ?>" class="form-control input_mid">
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
                            <td class="hidden" id="client_id_td"><?
                                $this->widget('ext.select2.ESelect2', array(
                                    'name' => 'lists[' . $key . '][Transition][client_id]',
                                    'id' => 'client_id_' . $key,
                                    'data' => $clientArray,
                                    'value' => $item['client_id'],
                                    'htmlOptions' => array('class' => 'select-full',)
                                ));
                                ?>
                            </td>
                            <td>
                                <input class="form-control form-control-inline input_mid " type="text"
                                       id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="form-control input-full" type="text" id="tran_memo_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                                <span class="info_warning"></span>
                            </td>
                            <td class="layout1">
                                <input class="form-control input_mid inline" onkeyup="checkInputAmount(this)"
                                       type="text" id="tran_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>"/>
                                <span class="help-block help-tip">合计：<label
                                        id="amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
                                </span><br/>
                                <span class="label-warning"></span>
                            </td>
                            <td class="action">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="<?= $item['status_id'] ?>">
                                <input type="hidden" id="subject_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_subject]"
                                       value="<?= $item['entry_subject'] ?>">
                                <input type="hidden" id="transaction_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_transaction]"
                                       value="<?= $item['entry_transaction'] ?>">
                                <input type="hidden" id="invoice_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][invoice]" value="<?= $item['invoice'] ?>">
                                <input type="hidden" id="withtax_<?= $key ?>" value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
                                <input type="hidden" id="tax_<?= $key ?>" name="lists[<?= $key ?>][Transition][tax]"
                                       value="<?= $item['tax'] ?>">
                                <input type="hidden" id="overworth_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][overworth]"
                                       value="<?= $item['overworth'] ?>">
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
                                <input type="hidden" id="last_<?= $key ?>" name="lists[<?= $key ?>][Transition][last]"
                                       value="<? isset($item['last']) ? $item['last'] : '' ?>">
                                <input type="hidden" id="path_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][path]"
                                       value="<?= $item['path'] ?>">

                                <div class="btn-group">
                                    <a class="btn btn-xs blue dropdown-toggle" data-toggle="modal"
                                       onclick="itemsetting(this)"
                                       href="#category-box">
                                        <button type="button" class="btn btn-xs blue">记账
                                        </button>
                                    </a>
                                    <!-- button type="button" class="btn btn-xs blue" onclick="itemsetting(this)"><i class="fa fa-file-o"></i> 记账
                                    </button -->
                                    <button type="button" data-type="double" class="btn btn-xs"
                                            onclick="itemsplit(this)">拆分
                                    </button>
                                    <button type="button" data-type="delete" id="btn_del_<?= $key ?>" class="btn btn-xs"
                                            onclick="itemclose(this)" disabled>删分
                                    </button>
                                </div>
                                <!--                                </div>-->
                            </td>
                            <td>
                            <span id="info_<?= $key ?>" class="<?= !empty($item['error']) ? 'label-warning' : '' ?>">
                               <?
                               if (!empty($item['error'])) {
                                   foreach ($item['error'] as $err) {
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
        <input type="hidden" name="subject_b" value="<?= isset($info['subject_b'])?$info['subject_b']:''?>">
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<div class="dataTables_wrapper no-footer">
    <div class="text-center">
        <button class="btn btn-warning" onclick="javascript:$('#first').click();"><span
                class="glyphicon glyphicon-repeat"></span> 重新导入
        </button>
        <button class="btn btn-primary" onclick="save()"><span class="glyphicon glyphicon-floppy-disk"></span> 保存凭证
        </button>
    </div>
</div>

<div id="category-box" class="modal fade" tabindex="-1" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="dropdown-menu-header">
            </div>
            <div class="modal-body">
                <div class="simScrollDiv">
                    <div class="scroller" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="setting" class="itemsetting">
                                    <div class="options ">
                                        <button class="btn " type="button" onclick="chooseType(this,1)"
                                                value="支出">支出
                                        </button>
                                        <button class="btn " type="button" onclick="chooseType(this,2)"
                                                value="收入">收入
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- .row -->
                    </div>
                    <!-- .scroller -->
                </div>
                <!-- .simScrollDiv -->
            </div>
            <!-- .modal-body -->
            <div class="modal-footer">
                <button class="btn btn-default blue" data-dismiss="modal" type="button" onclick="itemSet()">确定</button>
                <button class="btn btn-default default" data-dismiss="modal" type="button"
                ">取消
                </button>
            </div>
        </div>
        <!-- .modal-content -->
    </div>
    <!-- modal-dialog -->
</div><!-- #category-box -->