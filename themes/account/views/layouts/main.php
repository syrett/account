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
                    'htmlOptions' => array('class' => 'hasmenu nav navbar-nav dropdown dropdown-horizontal'),
                    'activeCssClass' => 'active',
                    'activateParents' => true,
                    'items' => array(
                        array('label' => '文件', 'url' => array(''),
                              'htmOptions' => array('class' => 'dir dropdown'),
                              'items' => array(
                                               array('label' => '导入'),
                                               array('label' => '导出'),
                                               array('label' => '打印'),
                                               array('label' => '备份'),
                                               array('label' => '恢复'),
                             )),
                        array('label' => '基础设置', 'url' => array(''),
                              'htmOptions' => array('class' => 'dir dropdown'),
                              'items' => array(
                                               array('label' => '公司信息'),
                                               array('label' => '项目', 'url' => array('/project/admin')),
                                               array('label' => '部门', 'url' => array('/department/admin')),
                                               array('label' => '员工', 'url' => array('/employee/admin')),
                                               array('label' => '供应商', 'url' => array('/vendor/admin')),
                                               array('label' => '客户', 'url' => array('/client/admin')),
                                               array('label' => '管理员'),
                             )),
                        array('label' => '总账', 'url' => array(''),
                              'htmOptions' => array('class' => 'dir dropdown'),
                              'active' => menuIsActive(array('listSettlement', 'listPost'),'options4', $this->id),
                              'items' => array(
                                               array('label' => '查询'),
                                               array('label' => '科目表', 'url' => array('/subjects/admin'),), //Subjects下所有操作高亮
                                               array('label' => '期初余额'),
                                               array('label' => '结账', 'url' => array('/Site/operation&operation='. 'listSettlement')),
                                               array('label' => '反结账', 'url' => array('/transition/antisettlement')),
                                               array('label' => '过账', 'url' => array('/Site/operation&operation='. 'listPost')),
                                               array('label' => '账套打印'),
                             )),
                        array('label' => '凭证', 'url' => array(''),
                              'htmOptions' => array('class' => 'dir dropdown'),
                              'items' => array(
                                               array('label' => '查询凭证', 'url' => array('/transition/index'), 'active'=>$this->id=='transition'?true:false),
                                               array('label' => '填制凭证', 'url' => array('/transition/create')),
                                               array('label' => '审核凭证', 'url' => array('/transition/listreview')),
                                               array('label' => '整理凭证', 'url' => array('/Site/operation&operation='. 'listReorganise')),
                                               array('label' => '打印凭证'),
                             )),
                        array('label' => '报表', 'url' => array(''),
                              'htmOptions' => array('class' => 'dir dropdown'),
                              'items' => array(
                                               array('label' => '资产负债表', 'url' => array('report/balance')),
                                               array('label' => '损益表', 'url' => array('report/profit')),
                                               array('label' => '现金流量表'),
                                               array('label' => '供应商表'),
                                               array('label' => '客户表', 'url' => array('report/client')),
                                               array('label' => '项目表'),
                                               array('label' => '部门表'),
                                               array('label' => '项目与部门核算表'),
                             )),
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
