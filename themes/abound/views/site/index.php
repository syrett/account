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
        	<a href="<?= $this->createUrl('Transition/bank') ?>" class="thumbnail">
<!--                <a href="backend/web/index.php?r=bank/default/index" class="thumbnail">-->
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzlr.gif','填制凭证');
                ?>
        	<span class="caption">1. 录入凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('transition/listreview') ?>" class="thumbnail">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzsh.gif','审核凭证');
                ?>
        	<span class="caption">2. 审核凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listTransition')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzcz.gif','查询凭证');
                ?>
        	<span class="caption">3. 查询凭证</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listPost')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/pzdz.gif','凭证过账');
                ?>
        	<span class="caption">4. 凭证过账</span>
        	</a>
        </div>
        <div class="col-md-index">
        	<a href="<?= $this->createUrl('Site/operation', array('operation'=>'listSettlement')) ?>" class="thumbnail">
                <?php
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/qmjz.gif','期末结账');
                ?>
            <span class="caption">5. 期末结账</span>
        	</a>
        </div>
    </div><!-- .row -->
    </div><!-- .panel-body -->
    <div class="panel-footer">
    <p>系统消息：如有任何意见及建议，请联系400-821-0913</p>
    </div>
</div><!-- .panel -->
