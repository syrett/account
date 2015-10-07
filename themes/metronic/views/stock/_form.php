<?php
/* @var $this StockController */
/* @var $model Stock */
/* @var $form CActiveForm */
require_once(dirname(__FILE__) . '/../viewfunctions.php');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'vendor-form',
// Please note: When you enable ajax validation, make sure the corresponding
// controller action is handling ajax validation correctly.
// There is a call to performAjaxValidation() commented in generated controller code.
// See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array('class' => 'form-horizontal',),
));

?>
<div class="well well-sm">
</div>

<div class="panel-body">
    <?
    $sbj = substr($model->entry_subject, 0, 4);
    if($sbj=='1601'||$sbj=='1701'||$sbj=='1801'){
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'hs_no', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'hs_no', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'hs_no'); ?>
    </div>
    <?
    }
    ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'order_no', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'order_no', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'order_no'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'model', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'model', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'model'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'vendor_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'vendor_id', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'vendor_id'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'in_date', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'in_date', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'in_date'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'in_price', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'in_price', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'in_price'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'out_date', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'out_date', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'out_date'); ?>
    </div>

<!--    <div class="form-group">-->
<!--        --><?php //echo $form->labelEx($model, 'out_price', array('class' => 'col-sm-2 control-label')); ?>
<!--        <div class="col-sm-10">-->
<!--            --><?php //echo $form->textField($model, 'out_price', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
<!--        </div>-->
<!--        --><?php //echo $form->error($model, 'out_price'); ?>
<!--    </div>-->

    <div class="form-group">
        <?php echo $form->labelEx($model, 'create_time', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
            <?php echo $form->textField($model, 'create_time', array('size' => 60, 'maxlength' => 64, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model, 'create_time'); ?>
    </div>

</div><!-- form -->
<?php $this->endWidget(); ?>
