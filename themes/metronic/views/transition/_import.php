<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

Yii::import('ext.select2.Select2');
//Yii::app()->clientScript->registerCoreScript('jquery');
//$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.js', CClientScript::POS_END);
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.css');
//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui.js', CClientScript::POS_HEAD);
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui.min.css');
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/theme.css');
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/custom.css');

//$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/import_datepicker.js', CClientScript::POS_END);
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
			<input type="checkbox" class="" name="first" id="first" /><label for="first">第一行包含数据</label>
			<button type="submit" class="btn btn-default btn-file btn-xs purple">导入</button>
			</div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="choose-bank-group">
                <?php
                if ($type == 'bank')
                    $sbj = 1002;
                if ($type == 'cash')
                    $sbj = 1001;
                $banks = Subjects::model()->list_sub($sbj);
                $data = [];
                $class = 'choose-bank';
                if (empty($banks)) {
                    echo '<input type="hidden" name="subject_2" value="1001" /></div>';
                } else {
                foreach ($banks as $item) {
                    $data[$item['sbj_number']] = $item['sbj_name'];
                }
                $user = User::model()->find(Yii::app()->user->id);
                $this->widget('Select2', array(
                    'name' => 'subject_2',
                    'id' => 'subject_2',
                    'value' => $user->bank,
                    'htmlOptions' => ['class' => $class, ],
                    'data' => $data,
                ));
                ?>
            </div>
            <input id="bank_name" placeholder="银行名称" type="text" class="input_mid"/>
            <button class="btn btn-default btn-file" type="button" onclick="addBank()">添加</button>
            <button class="btn btn-default btn-file" type="button" onclick="lockBank(this)" value="0">解锁银行</button>
            <?
            }
            ?>
        </div>
        </div>
    </div>
    <div class="import-tab" id="abc">
        <div class="box">
            <table id="data_import" class="table table-bordered dataTable">
                <tr>
                    <th class="input_checkbox"><input type="checkbox"></th>
                    <th class="input_mid">交易方名称</th>
                    <th class="input_mid"><select id="selectItem1" name="selectItem1"><?= $select ?></select></th>
                    <th><select id="selectItem2" name="selectItem2"><?= $select ?></select></th>
                    <th class="input_mid"><select id="selectItem3" name="selectItem3"><?= $select ?></select></th>
                    <th style="width: 150px">操作</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                <?php
                if (!empty($sheetData)) {
                    foreach ($sheetData as $key => $item) {
                        ?>
                        <tr line="<?= $key ?>" <?= $key % 2 == 1 ? 'class="table-tr"' : '' ?>>
                            <td><input type="checkbox" id="item_<?= $key ?>" name="lists[<?= $key ?>]"
                                       value="<?= isset($item['id']) ? $item['id'] : '' ?>"></td>
                            <td><input type="text" id="tran_name_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称" value="<?= $item['entry_name'] ?>" class="form-control input-small">
                            </td>
                            <td>
                            	<input class="form-control form-control-inline input-xsmall date-picker" type="text" id="tran_date_<?= $key ?>" name="lists[<?= $key ?>][Transition][entry_date]" value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="form-control input-small" type="text" id="tran_memo_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                            </td>
                            <td><input class="form-control input-small" onkeyup="checkInputAmount(this)" type="text"
                                       id="tran_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>">
                        <span class="help-block">总金额：<label
                                id="amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
                        </span></td>
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

                                <div class="btn-group-vertical" role="group">
                                    <div class="btn-group">
                                    <a class="btn btn-xs blue dropdown-toggle" data-toggle="modal" href="#category-box"><i class="fa fa-file-o"></i> 记-账
                                    </a>
									</div>
                                    <!-- button type="button" class="btn btn-xs blue" onclick="itemsetting(this)"><i class="fa fa-file-o"></i> 记账
                                    </button -->
                                    <button type="button" class="btn btn-xs" onclick="itemsplit(this)"><i class="fa fa-unlink"></i> 拆分</button>
                                    <button type="button" id="btn_del_<?= $key ?>" class="btn btn-xs" onclick="itemclose(this)" disabled><i class="fa fa-times"></i>删分</button>
                                </div>
                            </td>
                            <td>
                            <span id="info_<?= $key ?>" class="<?= !empty($item['error']) ? 'info_warning' : '' ?>">
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
                <tr id="trSetting" style="display: none">
                    <td colspan="100">
                    <!--
                        <div id="itemSetting" title="记账设置" class="box">
                            <div>
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
                                    '/bank/createemployee'
                                ) ?>">
                                <input id="new-url" type="hidden" value="<?= $this->createUrl(
                                    '/bank/createsubject'
                                ) ?>">

                                <input id="data" type="hidden" value="">
                                <input id="subject" type="hidden" value="">
                                <input id="item_id" type="hidden" value="">
                            </div>
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
					-->
                    </td>
                </tr>
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
        <input class="btn btn-primary btn-success" type="button" onclick="save()" value="保存凭证">
    </div>
</div>

<div id="category-box" class="modal fade" tabindex="-1" aria-hidden="true" style="display:none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">请选择分类</h4>
			</div>
			<div class="modal-body">
				<div class="simScrollDiv" style="postion:relative; overflow:hidden;width:auto;height:300px;">
					<div class="scroller" style="height:300px; overflow:hidden; width:auto;" data-always-visible="1" data-rail-visible1="1" data-initialized="1">
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
								'/bank/createemployee'
							) ?>">
							<input id="new-url" type="hidden" value="<?= $this->createUrl(
								'/bank/createsubject'
							) ?>">
							<input id="data" type="hidden" value="">
							<input id="subject" type="hidden" value="">
							<input id="item_id" type="hidden" value="">
							<div id="setting">
							    <div class="options btn-group-vertical margin-right-10">
									<button class="btn yellow" type="button" onclick="chooseType(this,1)"
											value="支出">支出
									</button>
									<button class="btn green" type="button" onclick="chooseType(this,2)"
											value="收入">收入
									</button>
								</div>
							</div>
						</div>
						</div><!-- .row -->
					</div><!-- .scroller -->
				</div><!-- .simScrollDiv -->
			</div><!-- .modal-body -->
			<div class="modal-footer">
				<button class="btn green" type="button" onclick="itemSet()">确定</button>
				<button class="btn default" data-dismiss="modal" type="button" onclick="dialogClose()">取消</button>
			</div>
		</div><!-- .modal-content -->
	</div><!-- modal-dialog -->
</div><!-- #category-box -->