<?php
/* @var $this TransitionController */
/* @var $model Transition */

$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'凭证管理',
);

$this->menu=array(
		array('label'=>'<i class="icon-plus-sign icon-white"></i> 添加凭证',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),
	array('label'=>'<i class="icon-list-alt icon-white"></i> 凭证列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
);
?>
<div class="row-fluid">
	<h2>凭证管理</h2>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-tabs'),
			));
			?>
</div>

<div class="row-fluid">
        <?php
        if($model[0]->entry_settlement==1)
            $this->renderPartial('_form_settle', array('model' => $model, 'action' => 'update'));
        else
            $this->renderPartial('_form', array('model' => $model, 'action' => 'update'));
        ?>
</div>