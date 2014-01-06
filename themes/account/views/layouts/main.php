<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->
    <?php
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/assets/js/select2/select2.js', CClientScript::POS_HEAD);
    ?>
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/dropdown.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/dropdown.vertical.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/helper.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/main.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/select2/select2.css" rel="stylesheet">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="page-container">
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container" id="page">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo CHtml::link(
                    '首页',
                    $this->createUrl('site/index'),
                    array(
                        'class' => 'navbar-brand',
                    )
                ); ?>
            </div>
            <div class="collapse navbar-collapse" id="mainmenu">
                <!-- header -->

          
                <?php $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array('class' => 'nav navbar-nav dropdown dropdown-horizontal'),
                    'activeCssClass' => 'active',
                    'activateParents' => true,
                    'items' => array(
                        array('label' => '凭证', 'url' => array('/transition/index'), 'active'=>$this->id=='transition'?true:false),
                        array('label' => '科目表', 'url' => array('/subjects/admin'), 'active'=>$this->id=='subjects'?true:false),     //Subjects下所有操作高亮
                        array('label' => '审核', 'url' => array('/site/page', 'view' => 'about')),
                        array('label' => '过账', 'url' => array('/site/contact')),
                        array('label' => '凭证整理', 'url' => array('/transition/reorganise')),
                        array('label' => '过账', 'url' => array('/post/post&date='.date('Y').date('m'))),
                        array('label' => '管理', 
                              'url' => array('/department/admin'),
                              'htmlOptions' => array('class' => 'dir'),
                              'items' => array(
                                               array('label' => '项目', 'url' => array('/project/admin')),
                                               array('label' => '部门', 'url' => array('/department/admin')),
                                               array('label' => '员工', 'url' => array('/employee/admin')),
                                               array('label' => '客户', 'url' => array('/client/admin')))),
                    ),

                )); ?>

                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                    'htmlOptions' => array('class' => 'nav navbar-nav navbar-right'),
                )); ?>
            </div>
        </div>
    </div>
    <!-- mainmenu -->

    <div class="content container" id="page">

        <?php if (isset($this->breadcrumbs)): ?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
        <?php endif ?>
        <?php echo $content; ?>

    </div>

</div>
<div class="clear"></div>

<div id="footer">
    <div class="container" id="page">
        Copyright &copy; <?php echo date('Y') . ' by ' . Yii::app()->name; ?> <br/>
    </div>
</div>
<!-- footer -->

<!-- page -->

</body>
</html>
