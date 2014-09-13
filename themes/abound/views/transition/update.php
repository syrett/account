<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'凭证管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加凭证',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 凭证列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-update')
		  ),	
);

?>
<div class="operations">
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
			));
			?>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
	<h2>会 计 凭 证</h2>	
	</div>
        <?php
        if($model[0]->entry_settlement==1)
            $this->renderPartial('_form_settle', array('model' => $model, 'action' => 'update'));
        else
            $this->renderPartial('_form', array('model' => $model, 'action' => 'update'));
        ?>
</div>
