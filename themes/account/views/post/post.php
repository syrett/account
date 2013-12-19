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


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
                     array(
                           'name'=>'entry_number',
                           'type'=>'raw',
                           'value'=>'$data->entry_num_prefix. $data->addZero($data->entry_num)'),
                     'entry_transaction',
                     'entry_amount',
                     'entry_editor',
                     'entry_reviewer',
                     'entry_reviewed',

	),
)); ?>

<div class="form-group buttons text-center">
              <?php echo CHtml::submitButton('过账', array('class' => 'btn btn-primary',)); ?>

</div>

