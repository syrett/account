<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/jquery-ui-1.10.4.custom.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui-1.10.4.custom.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/transition.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/checkinput.js', CClientScript::POS_HEAD);
$this->pageTitle = Yii::app()->name;
$sql = 'select date from transitionDate'; // 一级科目的为1001～9999$SQL="SQL Statemet"
$connection = Yii::app()->db;
$command = $connection->createCommand($sql);
$tranDate = $command->queryRow(); // execute a query SQL
/*if(!isset($model)){
  $model = array();
  $model[0]=new Transition();
  }*/
?>

<?php echo CHtml::beginForm(); ?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'transition-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
));

    if(isset($_REQUEST['id'])){
        $_REQUEST[0]['id'] = $_REQUEST['id'];
    }
    if(isset($_REQUEST[0]['id'])){
        $_REQUEST['id'] = $_REQUEST[0]['id'];
    }

?>
    <div class="row">
        <div class="col-md-4">
            <h5>
                凭证号:<input type="text" id='tranNumber' readonly value="<?
                echo (isset($_REQUEST[0]['id']) && $_REQUEST[0]['id'] != "")
                    ? $model[0]->entry_num_prefix . substr(strval($model[0]->entry_num + 10000), 1, 4)
                    : $this->tranNumber()
                ?>">

            </h5>
        </div>
        <div class="col-md-4" id="transition_date"><h5>日期:
                <input type="text" name="entry_date" class="span2" value="<?
                echo isset($model[0]->entry_num_prefix)
                    ?date('Ymd', strtotime($model[0]->entry_date))
                    : date('Ymd');?>" id="dp1" readonly/>
            </h5>
            <input type="hidden" id="entry_num_pre"
                   value="<? echo Yii::app()->createAbsoluteUrl("transition/GetTranSuffix") ?>"/></div>
        <div class="col-md-4"><h5></h5></div>
    </div>
    <!-- Table -->
    <table class="table">
        <tr>
            <td>
                <div class="row">
                    <div class="col-md-3">凭证摘要</div>
                    <div class="col-md-3">科目</div>
                    <div class="col-md-1">借/贷</div>
                    <div class="col-md-1">金额</div>
                    <div class="col-md-4">附加</div>
                </div>
                <div id="transitionRows">
                    <?
                    $count = count($model) > 5 ? count($model) : 5; //此凭证多于5条记录
                    $number = 0;
                    foreach ($model as $i => $item) {
                        ?>
                        <div id="row_<?= $i ?>" class="row v-detail">
                            <div class="col-md-3">
                                <?php echo CHtml::activeTextField($item, "[$i]entry_memo", array('class' => 'form-control input-size')); ?>
                                <?php echo $form->error($item, '[$i]_entry_memo'); ?>
                            </div>
                            <div class="col-md-3">
                                <? echo CHtml::activeDropDownList($item, "[$i]entry_subject",Transition::model()->listSubjects(), array('class'=>'v-subject')); ?>
                                <input type="hidden" value="<?= $i ?>"/>
                            </div>
                            <div class="col-md-1">
                                <? echo CHtml::activeDropDownList($item, "[$i]entry_transaction",array(1=>'借',2=>'贷')); ?>
                            </div>
                            <div class="col-md-1">
                                <?php echo CHtml::activeTextField($item, "[$i]entry_amount", array('class' => 'form-control input-size', 'onkeyup'=>'checkInputAmount(this)',)); ?>
                            </div>
                            <div class="col-md-4">
                                <span id="appendix_<?= $i; ?>" style="<? if($item['entry_appendix_type']==""||$item['entry_appendix_type']==0){ ?>display: none; <?}?>float: left">
                                    <?
                                    $data = $this->appendixList($item['entry_appendix_type']);
                                    $item->entry_appendix_id = $item['entry_appendix_id'];
                                    echo CHtml::activeDropDownList($item, "[$i]entry_appendix_id",$data, array('class'=>'v-appendix')); ?>
                                </span>
                                <button type="button" class="close" aria-hidden="true" name="<?= $i ?>"
                                        onclick="rmRow(this)">&times;</button>
                            </div>
                            <?php echo CHtml::activeHiddenField($item, "[$i]id"); ?>
                            <?php echo CHtml::activeHiddenField($item, "[$i]entry_appendix_type"); ?>
                        </div>
                    <?$number++;} ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <div>
                    <div class="row">
                        <?php
                        if(isset($_REQUEST['id']) && $model[0]->entry_memo!='结转凭证' && $model[0]->entry_reviewed!=1 && $model[0]->entry_closing!=1)
                        echo CHtml::button(($model[0]->entry_deleted==0)?'删除凭证':'恢复凭证', array(
                            'submit' => array('transition/delete', array('id'=>$_REQUEST['id'],'action'=>$model[0]->entry_deleted)),
                                'style' => 'float: left',
                                'name' => 'btnDelete',
                                'class' => 'btn btn-danger',
                                'confirm' => ($model[0]->entry_deleted==1)?'确定要恢复该凭证？':'确定要删除该凭证下所有条目？',
                            )
                        );

                        echo CHtml::button('继续添加', array(
                                'style' => 'float: right',
                                'name' => 'btnAdd',
                                'class' => 'btn btn-info',
                                'onclick' => "addRow()",
                            )
                        );
                        ?>
                    </div>
                    <div class="row table-buttom">
                        <?
                            if($model[0]->entry_reviewed==1)
                            {
                                $user = User::model()->findByPk(array('id'=>$model[0]->entry_reviewer));
                                echo '审核人员:'. $user->email;
                            }
                        ?>
                        <!--无需选择审核人员<strong>审核人员</strong>
                        <?
                        $data = $this->getUserlist();
//                        $data = $this->getUserlist('id!=:userid',array(":userid"=>Yii::app()->user->id));
                        $arr = array();
                        foreach ($data as $row) {
                            $arr += array($row['id']=> $row['email']);
                        };
//                        echo CHtml::activeDropDownList($model[0], 'entry_reviewer',$arr);
                        $this->widget('Select2', array(
                            'name' => 'entry_reviewer',
                            'value' => $model[0]->entry_reviewer,
                            'data' => $arr,
                        ));
                        echo $form->error($item, 'entry_reviewer');
                        ?>-->
                    </div>
                    <div class="form-group buttons text-center">
                        <?php
                            echo $form->error($item,'entry_amount',array('id'=>'entry_amount_msg'));
                        if($model[0]->hasErrors()){
                            echo CHtml::errorSummary($model[0]);
                        }
                            if(isset($_REQUEST['id'])&&accessReview($_REQUEST['id']))
                            echo CHtml::button(($model[0]->entry_reviewed==1)?'取消审核':'审核通过', array(
                                    'submit' => array('transition/review', array('id'=>$_REQUEST['id'], 'action'=>$model[0]->entry_reviewed)),
                                    'name' => 'btnReview',
                                    'class' => 'btn btn-danger',
                                    'confirm' => ($model[0]->entry_reviewed==1)?'确认取消审核？':'确认通过审核？',
                                )
                            );
if($model[0]->entry_reviewed == 0){
                            echo CHtml::submitButton($item->isNewRecord ? '添加' : '保存', array('class' => 'btn btn-primary',));  
}


                            echo CHtml::button('返回', array(
                                    'name' => 'btnBack',
                                    'class' => 'btn btn-warning',
                                    'onclick' => "history.go(-1)",
                                )
                            );
                        ?>
                    </div>
                </div>
                <!-- form -->
            </td>
        </tr>
    </table>

    <input type="hidden" name="entry_num_prefix" id='entry_num_prefix' value="<? echo isset($_REQUEST['id'])==true?$model[0]['entry_num_prefix']:date('Ym', time()) ?>"/>
    <input type="hidden" name="entry_num" id='entry_num' value="<? echo isset($_REQUEST['id'])==true?$model[0]['entry_num']:$this->tranSuffix("") ?>"/>
    <input type="hidden" name="entry_editor" id='entry_editor' value="<?=Yii::app()->user->id?>"/>
    <input type="hidden" id="number" value="<?= $number ?>"/>
    <input type="hidden" id="transitionDate" value="<?= isset($tranDate['date'])?$tranDate['date']:Yii::app()->params['startDate']; ?>"/>
    <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("transition/Appendix") ?>" id="entry_appendix"/>
    <input type="hidden" value="<? echo Yii::app()->createAbsoluteUrl("transition/ajaxlistfirst") ?>"
           id="ajax_listfirst"/>
<?php $this->endWidget(); ?>
<?php echo CHtml::endForm(); ?>