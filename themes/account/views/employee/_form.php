
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


<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'employee-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><small>带 <span class="required">*</span> 的必填.</small></p>

	<div class="form-group modal-open">
      <div id="leftDiv">
      </div>
      <div id="middleDiv">
      </div>
      <div id="rightDiv" >
      </div>
    </div>

	<div class="form-group modal-open">
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'name'); ?>
      </div>
      <div id="middleDiv">
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>100)); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'name'); ?>
      </div>
    </div>




	<div class="form-group modal-open">
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'department_id'); ?>
      </div>
      <div id="middleDiv">
        <?php echo $form->dropDownList($model,'department_id', $department_array); ?>
      </div>
      <div id="rightDiv" >
		<?php echo $form->error($model,'department_id'); ?>
      </div>
    </div>


	<div class="form-group modal-open">
      <div id="leftDiv">
		<?php echo $form->labelEx($model,'memo'); ?>
      </div>
      <div id="middleDiv">
  <?php echo $form->textArea($model,'memo',array('rows'=> 5, 'cols'=>60)); ?>
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