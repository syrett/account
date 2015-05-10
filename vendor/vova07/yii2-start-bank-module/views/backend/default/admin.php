<?php

/**
 * bank list view.
 *
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \vova07\bank\models\backend\BankSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use vova07\themes\admin\widgets\Box;
use vova07\themes\admin\widgets\GridView;
use vova07\bank\Module;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = Module::t('bank', 'BACKEND_INDEX_TITLE');
$this->registerJsFile('/backend/web/js/bank.js',['depends'=>[
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
    <div class="col-xs-9">
    </div>
    <div class="col-xs-3" >
        <a href="<?=Url::to(['/bank/default/admin',])?>" >
            <input type="button" class="btn btn-primary btn-history" value="历史数据" />
        </a>
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
                foreach ($sheetData as $key => $item) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name=""> </td>
                        <td><input type="text" name="name" placeholder="对方名称"></td>
                        <td><input type="text" name="date" value="<?=$item['date']?>" ></td>
                        <td><input type="text" name="memo" value="<?=$item['memo']?>" ></td>
                        <td><input type="text" name="amount" value="<?=$item['amount']?>" ></td>
                        <td class="action">
                            <a href="<?=Url::to(['/bank/default/update','id'=>$item['id']])?>" ><input type="button" class="btn btn-primary" value="修改" > </a>
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