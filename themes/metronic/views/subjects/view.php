
<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . Yii::t('import',' - 会计科目管理');
$this->breadcrumbs=array(
    Yii::t('import','会计科目管理'),
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span>'.Yii::t('import', '会计科目列表'),
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),	
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span>'.Yii::t('import', '添加科目'),
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-edit"></span>'.Yii::t('import', '修改科目'),
		  'url'=>array('update', 'id'=>$model->id),
		  'linkOptions'=>array('class'=>'btn btn-inverse'),
		  ),	
//	array('label'=>'<span class="glyphicon glyphicon-remove"></span> 删除科目',
//		  'url'=>'#',
//		  'linkOptions'=>array('class' => 'btn btn-inverse','submit' => array('delete', 'id' => $model->id), 'confirm' => '确定删除科目?'),
//		  ),
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
		<h2><?= Yii::t('import', '科目编号') ?> #<?php echo $model->sbj_number; ?></h2>
	</div>
	<div class="panel-body">
		<p class="alert alert-success"><strong><?= Yii::t('import', '操作成功！') ?></strong></p>
	</div>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data' => $model,
		'attributes' => array(
            Yii::t('import','科目编号')=>'sbj_number',
            Yii::t('import','科目名称')=>'sbj_name',
            Yii::t('import','科目分类')=>'sbj_cat',
            Yii::t('import','科目报表')=>'sbj_table',
            Yii::t('import','是否已经设置期初余额')=>'balance_set',
		),
	));
	?>
</div>

