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
            <a href="<?= $this->createUrl('Transition/create') ?>">
                <?
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/transition.ico','填制凭证',array('class'=>'unit-icon'));
                ?>
                填制凭证
            </a>
        </div>
        <div class="unit-arrow">
            <?
            echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/arrow.png','',array('class'=>''));
            ?>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/index') ?>">
                <?
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/review.ico','审核',array('class'=>'unit-icon'));
                ?>
                    审核
            </a>
        </div>
        <div class="unit-arrow">
            <?
            echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/arrow.png','',array('class'=>''));
            ?>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/index') ?>">
                <?
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/trans.ico','凭证管理',array('class'=>'unit-icon'));
                ?>
                    凭证管理
            </a>
        </div>
        <div class="unit-arrow">
            <?
            echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/arrow.png','',array('class'=>''));
            ?>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('/post/post&date='.date('Y').date('m')) ?>">
                <?
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/posting.ico','过账',array('class'=>'unit-icon'));
                ?>
                    过账
            </a>
        </div>
        <div class="unit-arrow">
            <?
            echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/arrow.png','',array('class'=>''));
            ?>
        </div>
        <div class="unit-item">
            <a href="<?= $this->createUrl('Transition/settlement') ?>">
                <?
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/settle.ico','结账',array('class'=>'unit-icon'));
                ?>
                    结账
            </a>
        </div>
    </div>
<!--    <div class="unit-group"><div class='long'>--><?//
//        echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/long.png','',array('class'=>''));
//        ?>
<!--    </div>-->
    </div>

</div>