<?php
require_once(dirname(__FILE__).'/../viewfunctions.php');

/* @var $this SubjectsController */
/* @var $model Subjects */
/* @var $form CActiveForm */

CHtml::$afterRequiredLabel = '';   //   remove * from required labelEx();
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subjects-form',
	'htmlOptions'=>array('class'=>'form-horizontal','role'=>'form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
	)); 
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }?>
	<div class="alert alert-info"><?= Yii::t('import', '注意：新建科目为所选科目“子科目”') ?></div>
    <?php
    if($model->getIsNewRecord()) {
    ?>
<!--        <div class="form-group form-group-lg">-->
<!--            <label class="col-sm-2 control-label">科目级别</label>-->
<!---->
<!--            <div class="col-sm-10">-->
<!--                --><?php
//                $model->getIsNewRecord();
//                $data = array(1 => '同级科目', 2 => '子科目');
//                if(isset($_REQUEST['sbj_type']))
//                    $value = $_REQUEST['sbj_type'];
//                else
//                    $value = 2;
//                $this->widget('Select2', array(
//                    'name' => 'sbj_type',
//                    'value' => $value,
//                    'data' => $data,
//                ));
//
//                ?>
<!--                一级科目无法添加同级科目-->
<!--            </div>-->
<!--        </div>-->
	<div class="form-group form-group-lg">
<!--		--><?php //echo $form->label($model,'sbj_name', array('class'=>'col-sm-2 control-label')); ?>
        <label class="col-sm-2 control-label" ><?= Yii::t('import', '选择科目') ?></label>
        <div class="col-sm-10 control-label-2">
            <?php
            $data = Subjects::model()->listSubjects();

            $this->widget('ext.select2.ESelect2', array(
                'model' => $model,
                'attribute' => 'sbj_number',
                'value' => 1,
                'data' => $data,
                'htmlOptions' => array('class'=>'control-form v-subject'),
            ));
            ?>
		</div>
    </div>

    <?php
    }
    else{
        ?>
        <div class="form-group form-group-lg">
            <?php echo $form->label($model,'sbj_number', array('class'=>'col-sm-2 control-label')); ?>
            <div class="col-sm-10">
                <?php
                echo $form->textField($model,'sbj_number',array('class'=>'form-control input-size','readOnly'=>'true'));
                ?>
            </div>
        </div>
    <?php
    }
    ?>

	<div class="form-group form-group-lg">
		<?php echo $form->labelEx($model,'sbj_name',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10" id="sbj_name_div">
		<?php echo $form->textField($model,'sbj_name',array('class'=>'form-control','size'=>20,'maxlength'=>512)); ?>
		<?php echo $form->error($model,'sbj_name',array('id'=>'sbj_name_msg')); ?>
            </div>
	</div>
    <div class="form-group form-group-lg">
        <?php echo $form->labelEx($model,'sbj_name_en',array('class'=>'col-sm-2 control-label')); ?>
        <div class="col-sm-10" id="sbj_name_en_div">
            <?php echo $form->textField($model,'sbj_name_en',array('class'=>'form-control','size'=>20,'maxlength'=>512)); ?>
            <?php echo $form->error($model,'sbj_name_en',array('id'=>'sbj_name_en_msg')); ?>
        </div>
    </div>
    <?php
    if($model->hasErrors()){
        echo '<div class="alert alert-danger text-left">';
        echo CHtml::errorSummary($model);
        echo '</div>';
    }
    ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('import', '添加') : Yii::t('import', '保存'), array('class'=>'btn btn-circle btn-primary',)); ?>
			<?php echo BtnBack(); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
