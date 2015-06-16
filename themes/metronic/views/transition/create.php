<?php
require_once(dirname(__FILE__) . '/../viewfunctions.php');

//Yii::app()->clientScript->registerCoreScript('jquery');
//Yii::import('ext.select2.Select2');
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.js', CClientScript::POS_HEAD);
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/select2/select2.css');
//
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/jquery-ui.min.css');
//$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/css/theme.css');
$cs->registerCssFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css');
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/transition.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/admin/layout/scripts/checkinput.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
$this->pageTitle=Yii::app()->name . ' - 会计凭证管理';
$this->breadcrumbs=array(
	'录入凭证',
	'添加'
);

?>

<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
		<i class="fa fa-edit"></i>录入凭证
		</div>
	</div>
	<div class="portlet-body">
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
    </div>
</div>
<script>
        jQuery(document).ready(function() {       
           // initiate layout and plugins
           ComponentsPickers.init();
        }); 
</script>
