<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<p>&nbsp;</p>
<div class="panel panel-default">

    <!-- Default panel contents -->
    <div class="panel-heading"><h3>系统总流程</h3></div>
    <div class="panel-body v-title">
    <!-- search-form -->
    <div class="row row-fluid">
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Transition/create') ?>" class="thumbnail">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzlr.png','填制凭证',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	<span class="caption">1. 录入凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listReview')) ?>" class="thumbnail">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzsh.png','审核凭证',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	<span class="caption">2. 审核凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listTransition')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzcz.png','查询凭证',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	<span class="caption">3. 查询凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listPost')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzdz.png','凭证过账',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	<span class="caption">4. 凭证过账</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listSettlement')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/qmjz.png','期末结账',array('style'=>'filter:alpha(opacity=0)'));
                ?>
            <span class="caption">5. 期末结账</span>
        	</a>
        </div>

<!--    <div class="unit-group"><div class='long'>--><?//
//        echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/long.png','',array('class'=>''));
//        ?>
<!--    </div>-->
    </div><!-- .row -->
    </div><!-- .panel-body -->
    <div class="panel-footer">
    <p>系统消息：当前为测试版本，如有任何意见及建议，请发送邮件至geek.michael@live.com</p>
    </div>
</div><!-- .panel -->
