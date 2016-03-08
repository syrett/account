<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . Yii::t('import',  ' - 会计科目管理');
$this->breadcrumbs=array(
    Yii::t('import',  '会计科目管理'),
);

$this->menu=array(
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span>'.Yii::t('import', '添加科目'),
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span>'.Yii::t('import', '科目列表'),
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
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
		<h2><?= Yii::t('import', '会计科目管理') ?></h2>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('_form', array('model' => $model)); ?>
	</div>
</div>