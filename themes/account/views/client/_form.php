
<style>
#leftDiv
{
  float:left;
  width:7%;
}
#middleDiv
{
  float:left;
  width:30%;
}
#rightDiv
{
  float:right;
  width:50%;
}
</style>

<div class="form" >

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'department-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><small>带 <span class="required">*</span> 的必填.</small></p>

	<div class="form-group modal-open"  >
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'company'); ?>
      </div>
      <div id="middleDiv">
		<?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>200)); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'company'); ?>
      </div>
    </div>

	<div class="form-group modal-open"  >
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'vat'); ?>
      </div>
      <div id="middleDiv">
		<?php echo $form->textField($model,'vat',array('size'=>45,'maxlength'=>45)); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'vat'); ?>
      </div>
    </div>

	<div class="form-group modal-open"  >
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'phone'); ?>
      </div>
      <div id="middleDiv">
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'phone'); ?>
      </div>
    </div>

	<div class="form-group modal-open"  >
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'add'); ?>
      </div>
      <div id="middleDiv">
		<?php echo $form->textField($model,'add',array('size'=>60,'maxlength'=>100)); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'add'); ?>
      </div>
    </div>


	<div class="form-group modal-open">
    	<div id="leftDiv" >
		<?php echo $form->labelEx($model,'memo'); ?>
        </div>
        <div id="middleDiv" >
		<?php echo $form->textArea($model,'memo',array('rows'=>5,'cols'=>60)); ?>
        </div>
        <div id="rightDiv" >
		<?php echo $form->error($model,'memo'); ?>
       	</div>
  </div>
	<div id="middleDiv" class="form-group buttons text-center">
   <?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary',)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
