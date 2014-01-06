
<div class="panel panel-default voucher">
    <!-- Default panel contents -->
    <div class="panel-heading">
  客户管理
        <div class="actions">
           <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'',
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>array(
                    array('label' => '添加客户', 'url' => array('create'),),
                ),
                'htmlOptions'=>array('class'=>'operations', 'style'=>'list-style: none',),
            ));
            $this->endWidget();

            ?>
        </div>
    </div>
              <?php $this->widget('zii.widgets.grid.CGridView', array(
                                                                      'id'=>'client-grid',
                                                                      'dataProvider'=>$model->search(),
                                                                      'itemsCssClass' => 'table',
                                                                      'columns'=>array(
                                                                                       'company',
                                                                                       'vat',
                                                                                       'phone',
                                                                                       'add',
                                                                                       'memo',
                                                                                       array(
                                                                                             'class'=>'CButtonColumn',
                                                                                             'template' => '{update} {delete}', 
                                                                                             ),
                                                                                       ),
                                                                      )); ?>
</div>
