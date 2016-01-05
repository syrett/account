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
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import_vip.js');
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/bank.js');
$cs->registerScriptFile($baseUrl . '/assets/global/plugins/colResizable/js/colResizable.min.js');

$this->pageTitle = Yii::app()->name;
$tranDate = $this->getTransitionDate('post');
/*if(!isset($model)){
  $model = array();
  $model[0]=new Transition();
  }*/
?>


<div class="dataTables_wrapper no-footer">
    <?
    echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form', 'class' => 'form-horizontal']);

    $select = '<option value="target_name" >交易对方名称</option>
                <option value="date" >日期</option>
                <option value="memo" >交易摘要</option>
                <option value="amount" >金额</option>
                <option value="none" >无效的列</option>';
    ?>
    <div class="import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered table-striped table-hover" id="import_table">
                <tr>
                    <th class="table_checkbox"><input type="checkbox" class="group-checkable"
                                                      data-set="#import_table .checkboxes"></th>
                    <th class="input_mid">交易对方名称</th>
                    <th class="input_mid2">日期</th>
                    <th class="input_full">交易摘要</th>
                    <th class="input-large">金额</th>
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
                                       class="form-control input-small">
                            </td>
                            <td>
                                <input class="form-control form-control-inline input_mid2 " type="text"
                                       id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="form-control input-full" type="text" id="tran_memo_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                                <span class="info_warning"></span>
                            </td>
                            <td class="layout1">
                                <input class="form-control inline width-auto" onkeyup="checkInputAmount(this)"
                                       type="text" id="tran_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>"/>
                                <span class="help-block help-tip">总金额：<label
                                        id="amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
                                </span><br/>
                                <span class="label-warning"></span>
                            </td>
                            <td class="action">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
                                <data>
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
                                           name="lists[<?= $key ?>][Transition][invoice]"
                                           value="<?= $item['invoice'] ?>">
                                    <input type="hidden" id="withtax_<?= $key ?>"
                                           value="<?= $item['tax'] > 0 ? 1 : 0 ?>">
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
                                    <input type="hidden" id="last_<?= $key ?>"
                                           name="lists[<?= $key ?>][Transition][last]"
                                           value="<? isset($item['last']) ? $item['last'] : '' ?>">
                                    <input type="hidden" id="path_<?= $key ?>"
                                           name="lists[<?= $key ?>][Transition][path]"
                                           value="<?= $item['path'] ?>">
                                </data>

                                <!--                                <div class="btn-group-vertical" role="group">-->
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
                                       echo is_array($err) ? $err[0] : $err;
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
        <input type="hidden" name="subject_b" value="<?= $info['subject_b']?>">
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
                <span class="left-info" id="setting-info"></span>
                <button class="btn btn-default blue" data-dismiss="modal" type="button" onclick="itemSet()">确定</button>
                <button class="btn btn-default default" data-dismiss="modal" type="button">取消</button>
            </div>
        </div>
        <!-- .modal-content -->
    </div>
    <!-- modal-dialog -->
</div><!-- #category-box -->

<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" id="form_wizard_1">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">导入银行交易</h4>
            </div>

            <?
            echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form-import', 'class' => 'form-horizontal']);
            ?>
            <div class="modal-body import-bank form-wizard">
                <div class="stepwizard">
                    <ul class=" stepwizard-row">
                        <li class="stepwizard-step col-md-1 active stepwizard-step-left">
                            <a href="#tab_step_1" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">1</span>
                            </a>
                            <p>
                                选择银行
                            </p>
                        </li>
                        <li class="stepwizard-step col-md-11 stepwizard-step-right">
                            <a href="#tab_step_2" data-toggle="tab" class="btn btn-default btn-circle step">
                                <span class="number">2</span>
                            </a>
                            <p>
                                导入数据
                            </p>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_step_1">
                            <p><?
                                if ($type == 'bank')
                                    $sbj = 1002;
                                if ($type == 'cash')
                                    $sbj = 1001;
                                $banks = Subjects::model()->list_sub($sbj);
                                $data = [];
                                $class = 'form-control';
                                if (empty($banks)) {
                                    echo '<input type="hidden" name="subject_b" value="1001" />';
                                } else {
                                    foreach ($banks as $item) {
                                        $data[$item['sbj_number']] = $item['sbj_name'];
                                    }
                                    $user = User::model()->findByPk(Yii::app()->user->id);
                                    $this->widget('ESelect2', array(
                                        'name' => 'subject_b',
                                        'id' => 'subject_b',
                                        'value' => $user->bank,
                                        'htmlOptions' => ['class' => $class,],
                                        'data' => $data,
                                    ));
                                    ?>
                                <? } ?>

                            </p>

                        </div>
                        <div class="tab-pane stepwizard-step-center" id="tab_step_2">
                            <p>
                            <div class="input-group choose-btn-group">
                                <div class="input-icon">
                                    <i class="fa fa-file fa-fw"></i>
                                    <input type="text" class="form-control btn-file" id="import_file_name" readonly="">
                                </div>
                                <span class="input-group-btn">
                                    <span class="btn btn-default btn-file">
                                        选择文件<input onchange="readURL(this);" name="attachment" type="file"
                                                   accept=".xls,.xlsx,.jpg">
                                    </span>
                                </span>
                            </div>
                            <div class="alert alert-block alert-info fade in alert-link">
                                <p>支持jpg格式的图片，文件大小不超过500KB；也可通过<a download href="/download/银行交易_模板.xlsx" >excel模板</a>导入。</p>
                            </div>
                            </p>
                            <div id="show_image" class="hidden">
                                <div class="show_image_option">
                                    <div class="show_image_option_conf">
                                        <input type="checkbox" checked name="image_row1_type"> <span>图片第一行无需导入</span>
                                    </div>
                                    <div class="show_image_option_rows">
                                        <a class="btn btn-default btn-xs" id="delCol" onclick="delCol()" title="删除列" href="#" id="yt0">
                                            <span class="">删除列<i class="fa fa-hand-o-up"></i></span></a>
                                        <a class="btn btn-default btn-xs" id="addCol" onclick="addCol()"  title="添加列" href="#" id="yt0">
                                            <span class="">添加列<i class="fa fa-hand-o-down"></i></span></a>

                                    </div>
                                </div>
                                <div class="clear">&nbsp;</div>
                                <div>
                                    <table id="head_image" class="head_image">
                                        <thead>
                                        <tr>
                                            <th><select id="selectItem1" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem2" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem3" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                            <th><select id="selectItem4" name="selectItem[]"><?= $select ?></select>
                                                <input type="hidden" name="show_image_conf_w[]"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="submit_type" name="submit_type">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">取消</button>
                <a href="javascript:;" class="btn default button-previous">
                    <i class="m-icon-swapleft"></i> 上一步 </a>
                <a href="javascript:;" class="btn blue button-next">
                    下一步 <i class="m-icon-swapright m-icon-white"></i>
                </a>
                <a href="javascript:;" class="btn blue button-submit">
                    导入 <i class="m-icon-swapright m-icon-white"></i>
                </a>

            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<a id="first" href="#large" data-toggle="modal" value="<?= $option ?>"></a>