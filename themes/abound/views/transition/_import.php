<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

Yii::import('ext.select2.Select2');
Yii::app()->clientScript->registerCoreScript('jquery');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui.min.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/theme.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/import.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/filechoose.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/import_datepicker.js', CClientScript::POS_HEAD);
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
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
<div class="well well-sm head-button">
    <?php
    echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 银行交易', array('bank'), array('class' => 'btn btn-default'));
    echo "\n";
    echo CHtml::link('<span class="glyphicon glyphicon-plus"></span> 现金交易', array('cash'), array('class' => 'btn btn-default'));
    echo "\n";
    echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span> 手动录入', array('create'), array('class' => 'btn btn-default'));
    /*
     $this->widget('zii.widgets.CMenu', array(
        'encodeLabel'=>false,
        'items'=>$this->menu,
        'htmlOptions'=>array('class'=>'nav nav-pills'),
        ));
    */
    echo "\n";
    ?>
    <div class="right">
        <? echo CHtml::link('<span class="glyphicon glyphicon-search"></span> 已导入数据', array('/' . $type), array('class' => 'btn btn-default')); ?>

        <input type="hidden" id="dp_startdate" value="<?= Transition::getTransitionDate() ?>">
    </div>
</div>
<div class="panel-body">
    <?
    $select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
    ?>
    <div class="row">
        <div class="col-xs-9">
            <?php echo CHtml::beginForm('', 'post', ['enctype' => "multipart/form-data", 'id' => 'form']); ?>
            <div class="choose-file  choose-btn-group">
                <a href="/download/导入模板.xlsx" download>
                    <button type="button" class=" btn btn-default choose-btn">模板下载</button>
                </a>
            </div>
            <!--                <i class="fa fa-paperclip"></i> 上传Excel-->
            <div class="choose-file">
                <div class="input-group choose-btn-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                        选择文件<input name="attachment" type="file" accept=".xls,.xlsx">
                    </span>
                </span>
                    <input type="text" class="form-control btn-file"" id="import_file_name" readonly="">
                </div>
                <input type="checkbox" class="" name="first"/><label>第一行包含数据</label>
                <button type="submit" class="btn btn-default right btn-file">导入</button>
            </div>
            <div class="choose-file">
                <?
                $banks = Subjects::model()->list_sub(1002);
                $data = [];
                foreach ($banks as $item) {
                    $data[$item['sbj_number']] = $item['sbj_name'];
                }
                $this->widget('Select2', array(
                    'name' => 'sbj_bank',
                    'id' => 'sbj_bank',
                    'htmlOptions' => ['class'=>'choose-bank'],
                    'data' => $data,
                ));
                ?>
                <div class="choose-file">
                    <input id="bank_name" placeholder="银行名称" type="text" class="input_mid"/>
                </div>

                <div class="choose-file">
                    <button class="btn btn-default btn-file right" type="button" onclick="addBank()">添加</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row import-tab" id="abc">
        <div class="box">

            <?php
            echo CHtml::beginForm('', 'post', ['id' => 'form']);
            ?>

            <table class="table table-bordered dataTable">
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
                            <td><input type="text" id="tran_name_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_name]" placeholder="对方名称"
                                       value="<?= $item['entry_name'] ?>">
                            </td>
                            <td><input class="input_mid" type="text" id="tran_date_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_date]"
                                       value="<?= $item['entry_date'] ?>">
                            </td>
                            <td><input class="input_full" type="text" id="tran_memo_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_memo]"
                                       value="<?= $item['entry_memo'] ?>">
                            </td>
                            <td><input class="input_mid" onkeyup="checkInputAmount(this)" type="text"
                                       id="tran_amount_<?= $key ?>"
                                       name="lists[<?= $key ?>][Transition][entry_amount]"
                                       value="<?= $item['entry_amount'] ?>">
                        <span class="tip2">总金额：<label
                                id="amount_<?= $key ?>"><?= $item['entry_amount'] ?></label>
                        </span></td>
                            <td class="action">
                                <input type="hidden" id="did_<?= $key ?>" name="lists[<?= $key ?>][Transition][d_id]"
                                       value="<?= isset($item['d_id']) ? $item['d_id'] : '' ?>">
                                <input type="hidden" id="id_<?= $key ?>" value="<?= $key ?>">
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

                                <div class="btn-group btn-group-xs" role="group">
                                    <button type="button" class="btn btn-default" onclick="itemsetting(this)">记账
                                    </button>
                                    <button type="button" class="btn btn-default" onclick="itemsplit(this)">拆分</button>
                                    <button type="button" class="btn btn-default" onclick="itemclose(this)">删分</button>
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
                        <div id="itemSetting" title="记账设置" class="box">
                            <!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
                            <div>
                                <input id="type" type="hidden" value="<?= $this->createUrl(
                                    '/bank/type'
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

                    </td>
                </tr>
            </table>
            <input class="btn btn-block btn-success" type="button" onclick="save()" value="保存凭证">
            <?php echo CHtml::endForm(); ?>

        </div>
    </div>
</div>