<?php
/* @var $this TransitionController */
/* @var $model Transition */
/* @var $form CActiveForm */
/* @var $action string */
require_once(dirname(__FILE__) . '/../viewfunctions.php');
$this->pageTitle = Yii::app()->name;
$sql = 'select date from transitiondate'; // 一级科目的为1001～9999$SQL="SQL Statemet"
$connection = Yii::app()->db;
$command = $connection->createCommand($sql);
$tranDate = $command->queryRow(); // execute a query SQL
/*if(!isset($model)){
  $model = array();
  $model[0]=new Transition();
  }*/
$subjects = Transition::model()->listSubjectsGrouped();

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

if (isset($_REQUEST['id'])) {
    $_REQUEST[0]['id'] = $_REQUEST['id'];
}
if (isset($_REQUEST[0]['id'])) {
    $_REQUEST['id'] = $_REQUEST[0]['id'];
}

$transition_number = (isset($_REQUEST[0]['id']) && $_REQUEST[0]['id'] != "")
    ? $model[0]->entry_num_prefix . substr(strval($model[0]->entry_num + 10000), 1, 4)
    : $this->tranNumber();
$transition_date = isset($model[0]->entry_num_prefix) ? date('Y-m-d', strtotime($model[0]->entry_date)) : date('Y-m-d');
?>
<div class="dataTables_wrapper no-footer">
    <div class="transition_title">
        <h2>记 账 凭 证</h2>
    </div>
    <div class="col-md-4">
        凭证号：<span class="dotted" id="tranNumber_lable"><?php echo $transition_number; ?></span> 字
        <input type="hidden" name="transition_id" id="tranNumber" class="form-control" value="<?php
        echo $transition_number;
        ?>" readonly/>
    </div>
    <div class="col-md-4" id="transition_date">
    	<div class="form-group">
    		<label class="control-label col-md-4">制单日期：</label>
    		<div class="col-md-3">
				<div class="input-group input-small date date-picker" data-date-format="yyyymmdd" >
					<input type="text" name="entry_date" class="form-control" value="<?php
				        echo isset($model[0]->entry_num_prefix)
        			    ? date('Ymd', strtotime($model[0]->entry_date))
        			    : date('Ymd'); ?>" id="dp1" readonly />
					<span class="input-group-btn">
					<button class="btn default" type="button">
					<span class="md-click-circle md-click-animate" style="height: 47px; width: 47px; top: -7.5px; left: 2.25px;"></span>
					<i class="fa fa-calendar"></i>
					</button>
					</span>
					<input type="hidden" id="entry_num_pre" value="<?php echo Yii::app()->createAbsoluteUrl("transition/GetTranSuffix") ?>"/>
				</div>
			</div>
		</div>
    </div>
    <?php
    //        if(isset($_REQUEST['id'])&&accessReview($_REQUEST['id'])&&accessSettle($_REQUEST['id'])) {
    if ($model[0]->entry_reviewed == 1)
        echo '<div class="approved">已审核</div>';
    //        }
    ?>

</div><!-- .panel-body -->
<!-- Table -->
<table class="table table-bordered transition" id="transitionRows">
    <thead>
    <tr>
        <th class="col-md-3">摘要</th>
        <th class="col-md-3">科目名称</th>
        <th class="col-md-1">借/贷</th>
        <th class="col-md-2">金额</th>
        <th class="col-md-3">附加</th>
    </tr>
    </thead>
    <?php
    $count = count($model) > 5 ? count($model) : 5; //此凭证多于5条记录
    $number = 0;
    foreach ($model as $i => $item) {
        ?>
        <tr id="row_<?php echo $i; ?>">
            <td class="col-md-3">
                <?php echo CHtml::activeTextField($item, "[$i]entry_memo", array('class' => 'form-control')); ?>
                <?php echo $form->error($item, '[$i]_entry_memo'); ?>
            </td>
            <td class="col-md-3">
                <?php

                $this->widget('ext.select2.ESelect2', array(
                    'name' => "[$i]entry_subject",
                    'id' => "Transition_$i". "_entry_subject",
                    'value' => $item['entry_subject'],
                    'data' => $subjects,
                    'htmlOptions' => array('class' => 'form-control v-subject',)
                ));
//                CHtml::activeDropDownList($item, "[$i]entry_subject", $subjects, array('class' => 'form-control v-subject'));
                ?>
                <input type="hidden" value="<?= $i ?>"/>
            </td>
            <td class="col-md-1">
                <?php echo CHtml::activeDropDownList($item, "[$i]entry_transaction", array(1 => '借', 2 => '贷'), array('class' => 'form-control')); ?>
            </td>
            <td class="col-md-2">
                <?php echo CHtml::activeTextField($item, "[$i]entry_amount", array('class' => 'form-control', 'onkeyup' => 'checkInputAmount(this)',)); ?>
            </td>
            <td class="col-md-3">
                <span id="appendix_<?= $i; ?>"
                      style="<?php if ($item['entry_appendix_type'] == '' || $item['entry_appendix_type'] == 0) { echo 'display: none;'; } ?>float: left">
                                    <?php
                                    $data = $this->appendixList($item['entry_appendix_type']);
                                    $item->entry_appendix_id = $item['entry_appendix_id'];
                                    echo CHtml::activeDropDownList($item, "[$i]entry_appendix_id", $data, array('class' => 'v-appendix')); ?>
                </span>
                <button type="button" class="close" aria-hidden="true" name="<?php echo $i; ?>"
                        onclick="rmRow(this)">&times;</button>
                <?php echo CHtml::activeHiddenField($item, "[$i]id"); ?>
                <?php echo CHtml::activeHiddenField($item, "[$i]entry_appendix_type"); ?>
            </td>
        </tr>
        <?php $number++;
    } ?>
</table>
<div class="transition_role">
    <div class="col-md-3">记账：

    </div>
    <div class="col-md-3">审核：
        <?php

        if ($model[0]->entry_reviewed == 1) {
            $user = User::model()->findByPk(array('id' => $model[0]->entry_reviewer));
            echo $user->email;
        }
        ?>
    </div>
    <div class="col-md-3">出纳：

    </div>
    <div class="col-md-3">制单：
    </div>
</div>
<div class="transition_action">
    借贷方合计:<span id="sum" class="sum">0</span>

    <p>
        <?php
        if ($model[0]->entry_reviewed == 0 && $model[0]->entry_settlement == 0) {
            ?>
            <button class="btn btn-default btn-sm" id="btnAdd" name="btnAdd" type="button" onclick="addRow()"><span
                    class="glyphicon glyphicon-add"></span> 插入新行
            </button>
        <?php

        }
        //0为上一条，即更小的凭证
        $Min = $this->hasTransitionM(0, $model[0]->entry_num_prefix, $model[0]->entry_num);
        if ($Min == 1) {
            echo '<a href=' . $this->createUrl("transition/update&id=" . $this->getNextPrevious(0, $model[0]->entry_num_prefix, $model[0]->entry_num))
                . '><button class="btn btn-default btn-sm" id="btnPrevious" name="btnPrevious" type="button"><span class="glyphicon glyphicon-chevron-left"></span> 上一页</button></a>';

        }
        //1为下一条，即更大的凭证
        $Min = $this->hasTransitionM(1, $model[0]->entry_num_prefix, $model[0]->entry_num);
        if ($Min == 1) {
            echo '<a href=' . $this->createUrl("transition/update&id=" . $this->getNextPrevious(1, $model[0]->entry_num_prefix, $model[0]->entry_num))
                . '><button class="btn btn-default btn-sm" id="btnNext" name="btnNext" type="button">下一页<span class="glyphicon glyphicon-chevron-right"></span></button></a>';

        }

        if (isset($_REQUEST['id']) && $model[0]->entry_memo != '结转凭证' && $model[0]->entry_reviewed != 1 && $model[0]->entry_closing != 1)
            echo CHtml::htmlbutton(($model[0]->entry_deleted == 0) ? '<span class="glyphicon glyphicon-remove"></span> 删除凭证' : '<span class="glyphicon glyphicon-share-alt"></span> 恢复凭证', array(
                    'submit' => array('transition/delete', array('id' => $_REQUEST['id'], 'action' => $model[0]->entry_deleted)),
                    'style' => 'float: left',
                    'name' => 'btnDelete',
                    'class' => 'btn btn-default btn-sm',
                    'confirm' => ($model[0]->entry_deleted == 1) ? '确定要恢复该凭证？' : '确定要删除该凭证下所有条目？',
                )
            );
        echo "\n";
        if (isset($_REQUEST['id']) && accessReview($_REQUEST['id']) && accessSettle($_REQUEST['id'])) {
            echo CHtml::htmlbutton(($model[0]->entry_reviewed == 1) ? '<span class="glyphicon glyphicon-repeat"></span> 取消审核' : '<span class="glyphicon glyphicon-ok"></span> 审核通过', array(
                    'submit' => array('transition/review', array('id' => $_REQUEST['id'], 'action' => $model[0]->entry_reviewed)),
                    'name' => 'btnReview',
                    'class' => 'btn btn-default btn-sm',
                    'confirm' => ($model[0]->entry_reviewed == 1) ? '确认取消审核？' : '确认通过审核？',
                )
            );
        }
        ?>
    </p>
</div>
<div class="row">
    <div class="form-group buttons text-center">
        <?php
        echo $form->error($item, 'entry_amount', array('id' => 'entry_amount_msg'));
        if ($model[0]->hasErrors()) {
            echo '<div class="alert alert-danger text-left">';
            echo CHtml::errorSummary($model[0]);
            echo '</div>';
        }
        if ($model[0]->entry_reviewed == 0 && $model[0]->entry_settlement == 0) {
            echo CHtml::tag('button', array('encode' => false, 'class' => 'btn btn-circle btn-primary',), '<span class="glyphicon glyphicon-floppy-disk"></span> 保存凭证');
        }
        echo "&nbsp;&nbsp;";
        echo BtnBack();
        ?>
    </div>
    <!-- form -->

    <input type="hidden" name="entry_num_prefix" id='entry_num_prefix'
           value="<?php echo isset($_REQUEST['id']) == true ? $model[0]['entry_num_prefix'] : date('Ym', time()) ?>"/>
    <input type="hidden" name="entry_num_prefix_this" id='entry_num_prefix_this'
           value="<?php echo isset($_REQUEST['id']) == true ? $model[0]['entry_num_prefix'] : date('Ym', time()) ?>"/>
    <input type="hidden" name="entry_num" id='entry_num'
           value="<?php echo isset($_REQUEST['id']) == true ? $model[0]['entry_num'] : $this->tranSuffix("") ?>"/>
    <input type="hidden" name="entry_editor" id='entry_editor' value="<?= Yii::app()->user->id ?>"/>
    <input type="hidden" name="entry_creater" id='entry_creater'
           value="<?php echo isset($_REQUEST['id']) == true ? $model[0]['entry_creater'] : Yii::app()->user->id ?>"/>
    <input type="hidden" id="number" value="<?= $number ?>"/>
    <input type="hidden" id="startDate" value="<?= Condom::model()->getStartTime();?>"/>
    <input type="hidden" id="transitionDate" value="<?= $tranDate['date'] ?>"/>
    <input type="hidden" value="<?php echo Yii::app()->createAbsoluteUrl("transition/Appendix") ?>" id="entry_appendix"/>
    <input type="hidden" value="<?php echo Yii::app()->createAbsoluteUrl("transition/ajaxlistfirst") ?>"
           id="ajax_listfirst"/>
    <input type="hidden" value="<?= Yii::app()->createAbsoluteUrl("subjects/ajaxgetsubjects") ?>"
           id="url_get_subjects"/>
</div>
<?php $this->endWidget(); ?>
<?php echo CHtml::endForm(); ?>
