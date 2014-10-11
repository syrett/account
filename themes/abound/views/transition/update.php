<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'凭证管理',
);

?>
<div class="panel panel-default">
	<div class="panel-heading">
	<h2>会 计 凭 证</h2>	
	</div>
        <?php
//        if($model[0]->entry_settlement==1)
//            $this->renderPartial('_form_settle', array('model' => $model, 'action' => 'update'));
//        else
            $this->renderPartial('_form', array('model' => $model, 'action' => 'update'));
        ?>
</div>
