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
    <div class="row">
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        	<a href="<?= $this->createUrl('Transition/create') ?>">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzlr.png','填制凭证',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	</a>
        	<div class="caption">
        		<h4>1. 填制凭证</h4>
        	</div>
        	</div>
        </div>
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listReview')) ?>">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzsh.png','审核',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	</a>
        	<div class="caption">
        		<h4>2. 审核凭证</h4>
        	</div>
        	</div>
        </div>
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listTransition')) ?>">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzcz.png','凭证管理',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        	</a>
        	<div class="caption">
        		<h4>3. 凭证管理</h4>
        	</div>
        	</div>
        </div>
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        		<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listPost')) ?>">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzdz.png','过账',array('style'=>'filter:alpha(opacity=0)'));
                ?>
        		</a>
        		<div class="caption">
        			<h4>4. 过账</h4>
        		</div>
        	</div>
        </div>
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        		<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listSettlement')) ?>">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/qmjz.png','月末结账',array('style'=>'filter:alpha(opacity=0)'));
                ?>
                </a>
                <div class="caption">
                	<h4>5. 期末结账</h4>
                </div>
        	</div>
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