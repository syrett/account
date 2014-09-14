
<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 会计科目管理';
$this->breadcrumbs=array(
	'会计科目管理',
);

$this->menu=array(
	array('label'=>'<span class="glyphicon glyphicon-th-list"></span> 会计科目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),	
		array('label'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加科目',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-inverse')
		  ),
	array('label'=>'<span class="glyphicon glyphicon-edit"></span> 修改科目',
		  'url'=>array('update', 'id'=>$model->id),
		  'linkOptions'=>array('class'=>'btn btn-inverse'),
		  ),	
	array('label'=>'<span class="glyphicon glyphicon-remove"></span> 删除科目',
		  'url'=>'#',
		  'linkOptions'=>array('class' => 'btn btn-inverse','submit' => array('delete', 'id' => $model->id), 'confirm' => '确定删除科目?'),
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
		<h2>科目编号 #<?php echo $model->sbj_number; ?></h2>
	</div>
	<div class="panel-body">
		<p class="alert alert-success"><strong>修改成功！</strong></p>
	</div>
	<?php $this->widget('zii.widgets.CDetailView', array(
		'data' => $model,
		'attributes' => array(
			'科目编号'=>'sbj_number',
			'科目名称'=>'sbj_name',
			'科目分类'=>'sbj_cat',
			'科目报表'=>'sbj_table',
		),
	));
	?>
</div>

