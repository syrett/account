<div class="panel panel-default voucher form">

   <!-- Default panel contents -->
   <div class="panel-heading">过账
   <div class="actions">

   <?
   $this->beginWidget('zii.widgets.CPortlet', array(
                                                    'title'=>'',
                                                    ));
$this->widget('zii.widgets.CMenu', array(
                                         'items'=>array(
                                                        array('label' => '未过账', 'url' => array('unposted'),),
                                                        ),
                                         'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
                                         ));
$this->endWidget();
?>
</div>
</div>
</div>


<div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'post-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
)); ?>
<?php 
$balance=0;

$this->widget('zii.widgets.grid.CGridView', array(
                                                        'id'=>'post-grid',
                                                        'dataProvider'=> $model->search(),
                                                        'rowCssClass'=>array('row-odd','row-even'),
                                                        'columns'=>array(
                                                                         array(
                                                                               'name'=>'entry_number',
                                                                               'type'=>'raw',
                                                                               'value'=>'$data->entry_num_prefix. $data->addZero($data->entry_num)'),
                                                                         array(
                                                                               'name'=>'entry_transaction',
                                                                               'type'=>'shortText',
                                                                               'value'=>'$data->transaction($data->entry_transaction)',
                                                                               'htmlOptions'=>array('style'=>'width:30px','width'=>'30px'),
                                                                               'headerHtmlOptions'=>array('width'=>'30px'),
                                                                               ),
                                                                         'entry_amount',
                                                                         array(
                                                                               'name' => '余额',
                                                                               'value' => '0',
                                                                               ),
                                                                         'entry_editor',
                                                                         'entry_reviewer',

                                                                         array('name'=>'entry_appendix','type'=>'shortText'),
                                                                         array('name'=>'entry_date',
                                                                               'value'=>'date("Y/m/d",$data->entry_date)'),

                                                                         ),
                                                        )); ?>
<?php $this->endWidget(); ?>
<div class="form-group buttons text-center">
<?php echo CHtml::beginForm(); ?>

  <input type="hidden" name="subject" value='<?php echo $_GET['subject'] ?>' />
  <input type="hidden" name="date" value='<?php echo $_GET['date'] ?>' />
  <?php echo CHtml::submitButton('过账', array('class' => 'btn btn-primary',)); ?>

  <?php echo CHtml::endForm(); ?>
</div>
</div>