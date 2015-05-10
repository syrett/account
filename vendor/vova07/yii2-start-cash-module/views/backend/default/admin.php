<?php

/**
 * cash list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \vova07\cash\models\backend\cashSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use vova07\themes\admin\widgets\Box;
use vova07\themes\admin\widgets\GridView;
use vova07\cash\Module;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Module::t('cash', 'BACKEND_INDEX_TITLE');
$this->registerJsFile('/backend/web/js/cash.js',['depends'=>[
        'yii\web\JqueryAsset',
        'yii\web\JqueryUIAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ]]);
$this->params['breadcrumbs'] = [
    $this->title
];
$gridId = 'bank-grid';
$select = '<option value=1 >日期</option><option value=2 >交易说明</option><option value=3 >金额</option>';
?>
<div class="row">
    <div class="col-xs-12">
        <?php ActiveForm::begin(['options' => ['enctype' => "multipart/form-data"]]); ?>
        <div class="btn btn-primary btn-file">
            <i class="fa fa-paperclip"></i> 上传Excel
            <input type="file" name="attachment">
        </div>
        <input type="submit" class="btn btn-primary" value="查看"/>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="row" id="abc">
    <div class="box">

        <?php ActiveForm::begin(); ?>
        <table class="table table-bordered table-hover dataTable">
            <tr>
                <th><input type="checkbox"></th>
                <th>交易方名称</th>
                <th><select id="selectItem1" name="selectItem1"><?=$select?></select></th>
                <th><select id="selectItem2" name="selectItem2"><?=$select?></select></th>
                <th><select id="selectItem3" name="selectItem3"><?=$select?></select></th>
                <th>操作</th>
            </tr>
            <?php
            if (!empty($sheetData)) {
                array_shift($sheetData);    //删除第一行表头，可优化为是否选择删除
                foreach ($sheetData as $key => $item) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name=""> </td>
                        <td><input type="text" name="name" placeholder="对方名称"></td>
                        <td><input type="text" name="date" value="<?=$item['A']?>" ></td>
                        <td><input type="text" name="description" value="<?=$item['B']?>" ></td>
                        <td><input type="text" name="amount" value="<?=$item['C']?>" ></td>
                        <td class="action">
                            <li class="fa fa-fw fa-plus-square" onclick="itemsplit(this)" ></li>
                            <li class="fa fa-fw fa-minus-square" onclick="itemclose(this)" ></li>
                            <li class="fa fa-fw fa-edit" onclick="itemsetting(this)" ></li>
                        </td>
                    </tr>
                <?php
                }
            }
            ?>

        </table>
        <?php ActiveForm::end(); ?>

    </div>
</div>
</head>

<body>
<div id="itemSetting" title="设置" class="box" style="">
<!--    <div class="modal-header bg-light-blue-active" >设置</div>-->
    <div>
        <input id="type" type="hidden" value="<?= Url::to([
            '/cash/default/type',
        ]) ?>" >

        <input id="option" type="hidden" value="<?= Url::to([
            '/cash/default/option',
        ]) ?>" >
        <input id="data" type="hidden" value="">
        <input id="subject" type="hidden" value="">
    </div>
    <div id="setting">
        <div class="options" >
            <button class="btn btn-primary" type="button" onclick="chooseType(this,1)" >支出</button><br />
            <button class="btn btn-primary" type="button" onclick="chooseType(this,2)" >收入</button>
        </div>
    </div>
    <div style="margin-top: 20px;text-align: center;">
        <button class="btn btn-success " type="button" onclick="itemSet(e)" >确定</button>
        <button class="btn btn-default" type="button" onclick="dialogClose()" >取消</button>
    </div>
</div>