<?php

/**
 * cash form view.
 *
 * @var \yii\base\View $this View
 * @var \yii\widgets\ActiveForm $form Form
 * @var \vova07\cash\models\backend\cash $model Model
 * @var \vova07\themes\admin\widgets\Box $box Box widget instance
 * @var array $statusArray Statuses array
 */

use vova07\cash\Module;
use vova07\fileapi\Widget as FileAPI;
use vova07\imperavi\Widget as Imperavi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin(); ?>
<?php $box->beginBody(); ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'title') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'alias') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'status_id')->dropDownList($statusArray) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'createdAtJui')->widget(
                DatePicker::className(),
                [
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'clientOptions' => [
                        'dateFormat' => 'dd.mm.yy',
                        'changeMonth' => true,
                        'changeYear' => true
                    ]
                ]
            ); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'updatedAtJui')->widget(
                DatePicker::className(),
                [
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'clientOptions' => [
                        'dateFormat' => 'dd.mm.yy',
                        'changeMonth' => true,
                        'changeYear' => true
                    ]
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'preview_url')->widget(
                FileAPI::className(),
                [
                    'settings' => [
                        'url' => ['/cash/default/fileapi-upload']
                    ]
                ]
            ) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'image_url')->widget(
                FileAPI::className(),
                [
                    'settings' => [
                        'url' => ['/cash/default/fileapi-upload']
                    ]
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'snippet')->widget(
                Imperavi::className(),
                [
                    'settings' => [
                        'minHeight' => 200,
                        'imageGetJson' => Url::to(['/cash/default/imperavi-get']),
                        'imageUpload' => Url::to(['/cash/default/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/cash/default/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'content')->widget(
                Imperavi::className(),
                [
                    'settings' => [
                        'minHeight' => 300,
                        'imageGetJson' => Url::to(['/cash/default/imperavi-get']),
                        'imageUpload' => Url::to(['/cash/default/imperavi-image-upload']),
                        'fileUpload' => Url::to(['/cash/default/imperavi-file-upload'])
                    ]
                ]
            ) ?>
        </div>
    </div>
<?php $box->endBody(); ?>
<?php $box->beginFooter(); ?>
<?= Html::submitButton(
    $model->isNewRecord ? Module::t('cash', 'BACKEND_CREATE_SUBMIT') : Module::t(
        'cash',
        'BACKEND_UPDATE_SUBMIT'
    ),
    [
        'class' => $model->isNewRecord ? 'btn btn-primary btn-large' : 'btn btn-success btn-large'
    ]
) ?>
<?php $box->endFooter(); ?>
<?php ActiveForm::end(); ?>