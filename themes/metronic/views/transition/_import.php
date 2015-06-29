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
$cs->registerScriptFile($baseUrl . '/assets/admin/layout/scripts/import.js');

$this->pageTitle = Yii::app()->name;
$sql = 'select date from transitiondate'; // 一级科目的为1001～9999$SQL="SQL Statemet"
$connection = Yii::app()->db;
$command = $connection->createCommand($sql);
$tranDate = $command->queryRow(); // execute a query SQL
/*if(!isset($model)){
  $model = array();
  $model[0]=new Transition();
  }*/
?>


<div class="dataTables_wrapper no-footer">
    <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form', 'class' => 'form-horizontal']); ?>
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
                <div class="btn-toolbar margin-bottom-10">
                    <i class="fa fa-file-excel-o"></i> <a href="/download/导入模板.xlsx">模板下载</a>
                    <input type="checkbox" class="" name="first" id="first"/><label for="first">第一行包含数据</label>
                    <button type="submit" class="btn btn-default btn-file btn-xs purple">导入</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-inline pull-right">
                    <div class="form-group">
                        <?php
                        if ($type == 'bank')
                            $sbj = 1002;
                        if ($type == 'cash')
                            $sbj = 1001;
                        $banks = Subjects::model()->list_sub($sbj);
                        $data = [];
                        $class = 'form-control';
                        if (empty($banks)) {
                            echo '<input type="hidden" name="subject_2" value="1001" /></div>';
                        } else {
                        foreach ($banks as $item) {
                            $data[$item['sbj_number']] = $item['sbj_name'];
                        }
                        $user = User::model()->find(Yii::app()->user->id);
                        $this->widget('ESelect2', array(
                            'name' => 'subject_2',
                            'id' => 'subject_2',
                            'value' => $user->bank,
                            'htmlOptions' => ['class' => $class,],
                            'data' => $data,
                        ));
                        ?>
                        <input id="bank_name" placeholder="银行名称" type="text" class="form-control"/>
                        <button class="btn btn-default btn-file" type="button" onclick="addBank()">添加</button>
                        <button class="btn btn-default btn-file" type="button" onclick="lockBank(this)" value="0">解锁银行
                        </button>
                    </div>
                </div>
                <?
                }
                ?>
            </div>
        </div>
    </div>
    <div class="import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered table-striped table-hover" id="import_table">
                <tr>
                    <th class="table_checkbox"><input type="checkbox" class="group-checkable"
                                                      data-set="#import_table .checkboxes"></th>
                    <th class="input_mid">交易方名称</th>
                    <th class="input_mid"><select id="selectItem1" name="selectItem1"><?= $select ?></select></th>
                    <th class="input_full"><select id="selectItem2" name="selectItem2"><?= $select ?></select></th>
                    <th class="input-large"><select id="selectItem3" name="selectItem3"><?= $select ?></select></th>
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
                            <td><input type="text" id="tran_name_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称"
                                       value="<?= $item['entry_name'] ?>" class="form-control input-small">
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
                                <input class="form-control input-small inline" onkeyup="checkInputAmount(this)"
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
                                <input type="hidden" id="status_id_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][status_id]"
                                       value="0">
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

                                <!--                                <div class="btn-group-vertical" role="group">-->
                                <div class="btn-group">
                                    <a class="btn btn-xs blue dropdown-toggle" data-toggle="modal" onclick="itemsetting(this)"
                                       href="#category-box">
                                        <button type="button" class="btn btn-xs blue"><i
                                                class="fa fa-file-o"></i> 记账
                                        </button>
                                    </a>
                                    <!-- button type="button" class="btn btn-xs blue" onclick="itemsetting(this)"><i class="fa fa-file-o"></i> 记账
                                    </button -->
                                    <button type="button" data-type="double" class="btn btn-xs"
                                            onclick="itemsplit(this)"><i
                                            class="fa fa-unlink"></i> 拆分
                                    </button>
                                    <button type="button" data-type="delete" id="btn_del_<?= $key ?>" class="btn btn-xs"
                                            onclick="itemclose(this)" disabled><i class="fa fa-times"></i>删分
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
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<div class="dataTables_wrapper no-footer">
    <div class="form-group buttons text-center">
        <input class="btn btn-primary btn-circle btn-success" type="button" onclick="save()" value="保存凭证">
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
                                <input id="type" type="hidden" value="<?= $this->createUrl(
                                    '/bank/type'
                                ) ?>">
                                <input id="user-bank" type="hidden" value="<?= $this->createUrl(
                                    '/user/savebank'
                                ) ?>">
                                <input id="option" type="hidden" value="<?= $this->createUrl(
                                    '/bank/option'
                                ) ?>">
                                <input id="employee" type="hidden" value="<?= $this->createUrl(
                                    '/employee/createemployee'
                                ) ?>">
                                <input id="new-url" type="hidden" value="<?= $this->createUrl(
                                    '/subjects/createsubject'
                                ) ?>">
                                <input id="data" type="hidden" value="">
                                <input id="subject" type="hidden" value="">
                                <input id="item_id" type="hidden" value="">

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
                <button class="btn btn-circle green" data-dismiss="modal" type="button" onclick="itemSet()">确定</button>
                <button class="btn btn-circle default" data-dismiss="modal" type="button"">取消
                </button>
            </div>
        </div>
        <!-- .modal-content -->
    </div>
    <!-- modal-dialog -->
</div><!-- #category-box -->