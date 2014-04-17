<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="适合小微企业的在线财务管理系统">
    <meta name="author" content="http://www.hitec.org.cn">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>我嘉 -- 财务管理系统</title>
    
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>

	<!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/assets/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-57-precomposed.png">
    <!-- Bootstrap core CSS -->
	<?php  $cs->registerCssFile($baseUrl.'/assets/css/bootstrap.min.css'); ?>
	<!-- Documentation extras -->
	<?php
	  $cs->registerCssFile($baseUrl.'/assets/css/abound.css');
	  //$cs->registerCssFile($baseUrl.'/css/style-blue.css');
	  ?>
      <!-- styles for style switcher -->
      	<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl;?>/assets/css/style-blue.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style2" href="<?php echo $baseUrl;?>/assets/css/style-brown.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style3" href="<?php echo $baseUrl;?>/assets/css/style-green.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style4" href="<?php echo $baseUrl;?>/assets/css/style-grey.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style5" href="<?php echo $baseUrl;?>/assets/css/style-orange.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style6" href="<?php echo $baseUrl;?>/assets/css/style-purple.css" />
        <link rel="alternate stylesheet" type="text/css" media="screen" title="style7" href="<?php echo $baseUrl;?>/assets/css/style-red.css" />
	  <?php
	  $cs->registerScriptFile($baseUrl.'/assets/js/bootstrap.min.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/plugins/jquery.sparkline.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/plugins/jquery.flot.min.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/charts.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/plugins/jquery.knob.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/plugins/jquery.masonry.min.js');
	  $cs->registerScriptFile($baseUrl.'/assets/js/styleswitcher.js');
	?>
  </head>

<body>

<!-- Require the navigation -->
<?php require_once('tpl_navigation.php')?>
    
<div class="container" role="main">
    <div class="container-fluid">
            <!-- Include content pages -->
            <?php echo $content; ?>
    </div>
</div>

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>

  </body>
</html>
