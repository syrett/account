
<?php
/* @var $this SubjectController */
/* @var $dataProvider CActiveDataProvider */
$this->pageTitle=Yii::app()->name . ' - 会计科目管理';
$this->breadcrumbs=array(
	'会计科目管理',
);

$this->menu=array(
	array('label'=>'<i class="icon-list-alt icon-white"></i> 会计科目列表',
		  'url'=>array('admin'),
		  'linkOptions'=>array('class'=>'btn btn-primary')
		  ),	
		array('label'=>'<i class="icon-plus-sign icon-white"></i> 添加科目',
		  'url'=>array('create'),
		  'linkOptions'=>array('class'=>'btn btn-success')
		  ),
	array('label'=>'<i class="icon-pencil icon-white"></i> 修改科目',
		  'url'=>array('update', 'id'=>$model->id),
		  'linkOptions'=>array('class'=>'btn btn-info'),
		  ),	
	array('label'=>'<i class="icon-remove icon-white"></i> 删除科目',
		  'url'=>'#',
		  'linkOptions'=>array('class' => 'btn btn-danger','submit' => array('delete', 'id' => $model->id), 'confirm' => '确定删除科目?'),
		  ),	
);
?>
<div class="row-fluid">
	<h2>科目编号 #<?php echo $model->sbj_number; ?></h2>
	<p class="alert alert-success"><strong>操作成功！</strong>您还可以进行以下操作：</p>
		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'nav nav-pills navbar-right'),
			));
			?>
</div>

<div class="row-fluid">
            <?php
            /* @var $this SubjectsController */
            /* @var $model Subjects */

            ?>

            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    '科目编号'=>'sbj_number',
                    '科目名称'=>'sbj_name',
                    '科目分类'=>'sbj_cat',
                    '科目报表'=>'sbj_table',
                ),
            )); ?>
</div>

