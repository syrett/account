<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="panel panel-default voucher form">

    <!-- Default panel contents -->
    <div class="panel-heading">&nbsp;</div>
    <div class="panel-body v-title">
    </div>
    <!-- search-form -->
    <div class="unit-group">
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/index') ?>">
                <div class="unit-icon">
                    凭证管理
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/index') ?>">
                <div class="unit-icon">
                    审核
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('/post/post&date='.date('Y').date('m')) ?>">
                <div class="unit-icon">
                    过账
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/settlement') ?>">
                <div class="unit-icon">
                    结账
                </div>
            </a>
        </div>
    </div>
    <div class="unit-group">
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/antiSettlement') ?>">
                <div class="unit-icon">
                    反结账
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/index') ?>">
                <div class="unit-icon">
                    审核
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('/post/post&date='.date('Y').date('m')) ?>">
                <div class="unit-icon">
                    过账
                </div>
            </a>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/settlement') ?>">
                <div class="unit-icon">
                    结账
                </div>
            </a>
        </div>
    </div>

</div>