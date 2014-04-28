<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<p>&nbsp;</p>
<div class="panel panel-default">

    <!-- Default panel contents -->
    <div class="panel-heading"><h2>系统总流程</h2></div>
    <div class="panel-body v-title">
    <!-- search-form -->
    <div class="row">
        <div class="col-sm-4 col-md-2">
        	<div class="thumbnail">
        	<a href="<?= $this->createUrl('Transition/create') ?>">
                <?php
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/transition.ico','填制凭证');
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
                 echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/review.ico','审核');
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
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/trans.ico','凭证管理',array('data-src'=>'holder.js/100%x80'));
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
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/posting.ico','过账',array('data-src'=>'holder.js/100%x80'));
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
                echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/settle.ico','结账',array('data-src'=>'holder.js/100%x80'));
                ?>
                </a>
                <div class="caption">
                	<h4>5. 结账</h4>
                </div>
        	</div>
        </div>

<!--    <div class="unit-group"><div class='long'>--><?//
//        echo CHtml::image(Yii::app()->theme->baseUrl. '/assets/img/long.png','',array('class'=>''));
//        ?>
<!--    </div>-->
    </div>
    </div>
    </div>
</div>