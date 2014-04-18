<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Forms';
$this->breadcrumbs=array(
	'Forms',
);
?>

<div class="page-header">
	<h1>Forms</h1>
</div>

<div class="row">
  <div class="col-sm-6">
  
<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Text fields",
	));
	
?>
<?php
echo(CHtml::beginForm());
echo '<div class="form-group">';
echo(CHtml::label('Normal field', 'name'));
echo(CHtml::textField('name','',array('class'=>'form-control')));
echo '</div>';

echo '<div class="form-group">';
echo(CHtml::label('Password input', 'name'));
echo(CHtml::passwordField('name','',array('class'=>'form-control')));
echo '</div>';

echo '<div class="form-group">';
echo(CHtml::label('With placeholder', 'name'));
echo(CHtml::textField('name', 'this is placeholder text',array('class'=>'form-control')));
echo '</div>';

echo '<div class="form-group">';
echo(CHtml::label('Read only field', 'name'));
echo(CHtml::textField('name','',array('class'=>'form-control','readonly'=>'readonly')));
echo '</div>';

echo '<div class="form-group">';
echo(CHtml::label('Disabled field', 'name'));
echo(CHtml::textField('name','',array('disabled'=>'disabled','class'=>'form-control')));
echo '</div>';

echo '<div class="form-group">';
echo(CHtml::label('Max lenght', 'name'));
echo(CHtml::textField('name','Max length is 10',array('class'=>'form-control','maxlength'=>'10')));
echo '</div>';

echo(CHtml::label('Prepended text', 'name'));
echo '<div class="input-group">';
echo '<span class="input-group-addon">$</span>';
echo(CHtml::textField('name','',array('class'=>'form-control')));
echo '</div>';

echo(CHtml::label('Append text', 'name'));
echo '<div class="input-group">';
echo(CHtml::textField('name','',array('class'=>'form-control')));
echo '<span class="input-group-addon">.00</span>';
echo '</div>';

echo(CHtml::endForm());
?>

<?php $this->endWidget();?>

    </div>
    <div class="col-sm-6">
    <?php
	$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>"Text fields",
		));
		
	?>
    <?php

	echo '<div class="form-group">';
    echo(CHtml::label('List box', 'name'));
	echo(CHtml::listBox('name','',array('1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five'),array('class'=>'form-control')));
	echo '</div>';

	echo '<div class="form-group">';	
	echo(CHtml::label('Text Area', 'name'));
	echo(CHtml::textArea('name','',array('class'=>'form-control')));
	echo '</div>';

	echo '<div class="form-group">';		
	echo(CHtml::label('File field', 'name'));
	echo(CHtml::fileField('name','',array('class'=>'form-control')));
	echo '</div>';

	echo '<div class="form-group">';	
	echo(CHtml::label('Radio button', 'name'));
	echo(CHtml::radioButton('name','',array('class'=>'form-control')));
	echo '</div>';
	
	echo '<div class="form-group">';		
	echo(CHtml::label('Check box', 'name'));
	echo(CHtml::checkBox('name','',array('class'=>'form-control')));
	echo '</div>';
	?>
    <?php $this->endWidget();?>
    </div>
</div>

<div class="row">
  	<div class="col-sm-12">
    <?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>"Control sizing - Block level inputs",
	));
	
	?>
    <p>
    Make any <code>&lt;input&gt;</code> or <code>&lt;textarea&gt;</code> element behave like a block level element.
    </p>
    <?php
	echo(CHtml::textField('name','.form-control',array('class'=>'form-control')));
	echo(CHtml::textArea('name','.form-control rows=>6',array('class'=>'form-control','rows'=>'6')));
	?>
    
    <?php $this->endWidget();?>
    </div>
</div>