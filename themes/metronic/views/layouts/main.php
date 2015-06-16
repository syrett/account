<?php
	if (Yii::app()->user->isGuest) {
		// Guest users
		// Redirect to the main website
		header("location: http://www.sorcerer.com.cn");
		exit; 
	}
	Yii::app()->clientScript->scriptMap=array(
        'jquery.js'=>false,
        'jquery.min.js'=>false,
        );
	$baseUrl = Yii::app()->theme->baseUrl; 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>老法师 -- 云端财务管理系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="适合小微企业的在线财务管理系统" name="description"/>
<meta content="老法师（上海）财务咨询有限公司" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.useso.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="<?php echo $baseUrl;?>/assets/global/css/components-md.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $baseUrl;?>/assets/admin/layout/css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo $baseUrl;?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<!-- Fav and Touch and touch icons -->
<link rel="shortcut icon" href="<?php echo $baseUrl;?>/assets/img/icons/favicon.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/assets/img/icons/apple-touch-icon-57-precomposed.png">
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-md page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo Yii::app()->homeUrl; ?>">
			<img src="<?php echo $baseUrl;?>/assets/admin/layout/img/laofashigroup-logo-inverse.png" class="laofashi-logo" alt="logo" />
			</a>
			<div class="menu-toggler sidebar-toggler">
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->
		<!-- BEGIN PAGE ACTIONS -->
		<!-- DOC: Remove "hide" class to enable the page header actions -->
		<div class="page-actions">
			<div class="btn-group">
				<button type="button" class="btn btn-circle green-haze dropdown-toggle" data-toggle="dropdown">
				<i class="glyphicon glyphicon-plus"></i>&nbsp;<span class="hidden-sm hidden-xs">新建&nbsp;</span>&nbsp;<i class="fa fa-angle-down"></i>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li>
						<a href="<?= $this->createUrl('Transition/create') ?>">
						<i class="icon-notebook"></i> 凭证</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="<?= $this->createUrl('client/create') ?>">
						<i class="icon-user-following"></i> 客户</a>
					</li>
					<li>
						<a href="<?= $this->createUrl('vendor/create') ?>">
						<i class="icon-basket-loaded"></i> 供应商 </a>
					</li>
					<li>
						<a href="<?= $this->createUrl('project/create') ?>">
						<i class="icon-rocket"></i> 项目</a>
					</li>
					<li>
						<a href="<?= $this->createUrl('employee/create') ?>">
						<i class="icon-user"></i> 员工</a>
					</li>
					<li>
						<a href="<?= $this->createUrl('department/create') ?>">
						<i class="icon-users"></i> 部门</a>
					</li>
					<li class="divider">
					</li>
					<li>
						<a href="<?= $this->createUrl('subjects/create') ?>">
						<i class="icon-note"></i> 会计科目</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- END PAGE ACTIONS -->
		<!-- BEGIN PAGE TOP -->
		<div class="page-top">
			<!-- BEGIN HEADER SEARCH BOX -->
			<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
			<form class="search-form search-form-expanded" action="extra_search.html" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="输入凭证字号..." name="query">
					<span class="input-group-btn">
					<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
					</span>
				</div>
			</form>
			<!-- END HEADER SEARCH BOX -->
		
			<!-- BEGIN TOP NAVIGATION MENU -->
			<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<!-- BEGIN NOTIFICATION DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-extended dropdown-notification hide" id="header_notification_bar">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-bell"></i>
					<span class="badge badge-default">
					7 </span>
					</a>
					<ul class="dropdown-menu">
						<li class="external">
							<h3>消息 <span class="bold">12条未读</span></h3>
							<a href="extra_profile.html">查看全部</a>
						</li>
						<li>
							<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
								<li>
									<a href="javascript:;">
									<span class="time">刚才</span>
									<span class="details">
									<span class="label label-sm label-icon label-success">
									<i class="fa fa-plus"></i>
									</span>
									6月结账完成</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">3分钟前</span>
									<span class="details">
									<span class="label label-sm label-icon label-danger">
									<i class="fa fa-bolt"></i>
									</span>
									凭证审核未通过</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">10分钟前</span>
									<span class="details">
									<span class="label label-sm label-icon label-warning">
									<i class="fa fa-bell-o"></i>
									</span>
									反结账失败</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">14小时前</span>
									<span class="details">
									<span class="label label-sm label-icon label-info">
									<i class="fa fa-bullhorn"></i>
									</span>
									系统升级通知</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">2天前</span>
									<span class="details">
									<span class="label label-sm label-icon label-danger">
									<i class="fa fa-bolt"></i>
									</span>
									系统升级通知</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">3天前</span>
									<span class="details">
									<span class="label label-sm label-icon label-danger">
									<i class="fa fa-bolt"></i>
									</span>
									登录失败</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">4天前</span>
									<span class="details">
									<span class="label label-sm label-icon label-warning">
									<i class="fa fa-bell-o"></i>
									</span>
									登录失败</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">5天前</span>
									<span class="details">
									<span class="label label-sm label-icon label-info">
									<i class="fa fa-bullhorn"></i>
									</span>
									欢迎使用在线财务管理系统</span>
									</a>
								</li>
								<li>
									<a href="javascript:;">
									<span class="time">9天前</span>
									<span class="details">
									<span class="label label-sm label-icon label-danger">
									<i class="fa fa-bolt"></i>
									</span>
									注册成功</span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</li>
				<!-- END NOTIFICATION DROPDOWN -->
				<!-- BEGIN USER LOGIN DROPDOWN -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-extended">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="icon-settings"></i>
					<span class="username username-hide-on-mobile">
					公司名称 </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li class="external">
							<h3><span class="bold">基本设置</span></h3>
						</li>
						<li>
							<a href="<?= $this->createUrl('options/index') ?>">
							<i class="icon-info"></i> 公司信息</a>
						</li>
						<li>
							<a href="<?= $this->createUrl('department/admin') ?>">
							<i class="icon-grid"></i> 部门设置 </a>
						</li>
						<li>
							<a href="<?= $this->createUrl('project/admin') ?>">
							<i class="icon-rocket"></i> 项目列表</a>
						</li>
						<li>
							<a href="<?= $this->createUrl('employee/admin') ?>">
							<i class="icon-user"></i> 员工列表</a>
						</li>
						<li class="external">
							<h3><span class="bold">系统选项</span></h3>
						</li>
						<li>
							<a href="<?= $this->createUrl('site/logout')?>">
							<i class="icon-key"></i> 退出 </a>
						</li>
					</ul>
				</li>
				<!-- END USER LOGIN DROPDOWN -->
				<!-- BEGIN HELP PANEL -->
				<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
				<li class="dropdown dropdown-extended">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="glyphicon glyphicon-question-sign"></i>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li class="external">
							<h3><span class="bold">常见问题 FAQ</span></h3>
						</li>
						<li>
							<a href="extra_profile.html">
							<i class="icon-user"></i> 如何录入凭证？ </a>
						</li>
						<li>
							<a href="page_calendar.html">
							<i class="icon-calendar"></i> 更多内容</a>
						</li>
						<li class="external">
							<h3><span class="bold">专业培训</span></h3>
						</li>
						<li>
							<a href="http://www.sorcerer.com.cn/contact-us/" target="_blank">
							<i class="icon-call-out"></i> 服务热线 400-821-0913 </a>
						</li>
					</ul>
				</li>
				<!-- END QUICK SIDEBAR TOGGLER -->
			</ul>
		</div>
			<!-- END TOP NAVIGATION MENU -->
		</div>
		<!-- END PAGE TOP -->
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>

<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="start active">
					<a href="<?php echo Yii::app()->homeUrl; ?>">
					<i class="icon-home"></i>
					<span class="title">首页</span>
					<span class="selected"></span>
					</a>
				</li>
				<li>
					<a href="javascript:;">
					<i class="icon-layers"></i>
					<span class="title">总账</span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<li>
							<a href="<?= $this->createUrl('subjects/admin') ?>">
							<i class="glyphicon glyphicon-list-alt"></i>
							科目表</a>
						</li>
						<li>
							<a href="<?= $this->createUrl('subjects/balance') ?>">
							<i class="glyphicon glyphicon-usd"></i>
							期初余额</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="<?= $this->createUrl('Site/operation&operation=listSettlement') ?>">
							<i class="glyphicon glyphicon-check"></i>
							结账</a>
						</li>
						<li>
							<a href="<?= $this->createUrl('transition/antisettlement') ?>">
							<i class="glyphicon glyphicon-repeat"></i>
							反结账</a>
						</li>
						<li>
							<a href="<?= $this->createUrl('Site/operation&operation=listPost') ?>">
							<i class="glyphicon glyphicon-import"></i>
							过账</a>
						</li>
					</ul>
				</li>
				<li class="last">
					<a href="<?= $this->createUrl('report/admin') ?>">
					<i class="icon-bar-chart"></i>
					<span class="title">报表</span>
					</a>
				</li>
				<li>
					<a href="<?= $this->createUrl('client/admin') ?>">
					<i class="icon-wallet"></i>
					<span class="title">客户</span>
					</a>
				</li>
				<li>
					<a href="<?= $this->createUrl('vendor/admin') ?>">
					<i class="icon-basket-loaded"></i>
					<span class="title">供应商</span>
					</a>
				</li>
				<li>
					<a href="<?= $this->createUrl('employee/admin') ?>">
					<i class="icon-users"></i>
					<span class="title">员工</span>
					</a>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">    
			<?php echo $content; ?>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2015 &copy; <a href="http://www.sorcerer.com.cn" target="_blank">老法师（上海）财务咨询有限公司 版权所有</a>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/respond.min.js"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo $baseUrl;?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl;?>/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php 
	$cs = Yii::app()->clientScript;
	$cs->registerScript('MetronicInit','Metronic.init();', CClientScript::POS_READY);
	$cs->registerScript('LayoutInit','Layout.init();', CClientScript::POS_READY);
?>