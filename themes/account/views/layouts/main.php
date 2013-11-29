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

    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/main.css" rel="stylesheet">

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
                    Yii::app()->name,
                    $this->createUrl('site/index'),
                    array(
                        'class' => 'navbar-brand',
                    )
                ); ?>
            </div>
            <div class="collapse navbar-collapse" id="mainmenu">
                <!-- header -->

                <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => '凭证', 'url' => array('/site/index')),
                        array('label' => '审核', 'url' => array('/site/page', 'view' => 'about')),
                        array('label' => '过账', 'url' => array('/site/contact')),
                    ),
                    'htmlOptions' => array('class' => 'nav navbar-nav'),
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
