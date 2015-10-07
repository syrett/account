<?php
if (Yii::app()->user->isGuest) {
    // Guest users
    // Redirect to the main website
//    header("location: http://www.laofashigroup.com");
//    exit;
}
Yii::app()->clientScript->scriptMap = array(
    'jquery.js' => false,
    'jquery.min.js' => false,
);
$baseUrl = Yii::app()->theme->baseUrl;
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <title>老法师 -- 云端财务管理系统</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="适合小微企业的在线财务管理系统" name="description"/>
    <meta content="老法师（上海）财务咨询有限公司" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.useso.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
          rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="<?php echo $baseUrl; ?>/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $baseUrl; ?>/assets/admin/layout/css/themes/blue.css" rel="stylesheet" type="text/css"
          id="style_color"/>
    <link href="<?php echo $baseUrl; ?>/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>/assets/admin/layout/img/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="<?php echo $baseUrl; ?>/assets/admin/layout/img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="<?php echo $baseUrl; ?>/assets/admin/layout/img/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed"
          href="<?php echo $baseUrl; ?>/assets/admin/layout/img/apple-touch-icon-57-precomposed.png">
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
<body
    class="page-md page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
<!-- BEGIN HEADER -->
<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?php echo Yii::app()->homeUrl; ?>">
                <img src="<?php echo $baseUrl; ?>/assets/admin/layout/img/laofashigroup-logo-inverse.png"
                     class="logo-default" alt="logo"/>
            </a>

            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top text-center">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="icon-settings"></i>
					<span class="username username-hide-on-mobile">
					<?= Condom::model()->getName() ?></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="external">
                                <h3><span class="bold">基本设置</span></h3>
                            </li>
                            <li>
                                <a href="<?= $this->createUrl('options/index') ?>">
                                    <i class="icon-info"></i> 账套信息</a>
                            </li>
                            <li>
                                <a href="<?= $this->createUrl('options/setting') ?>">
                                    <i class="icon-equalizer"></i> 参数设置</a>
                            </li>
                            <li>
                                <a href="<?= $this->createUrl('subjects/balance') ?>">
                                    <i class="icon-grid"></i> 期初余额 </a>
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
                                <a href="<?= LogoutURL ?>">
                                    <i class="icon-key"></i> 退出 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN HELP PANEL -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="glyphicon glyphicon-question-sign"></i>
                            <span class="username username-hide-on-mobile"> 帮助 </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="external">
                                <h3><span class="bold">常见问题 FAQ</span></h3>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-user"></i> 如何录入凭证？ </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-calendar"></i> 更多内容</a>
                            </li>
                            <li class="external">
                                <h3><span class="bold">专业培训</span></h3>
                            </li>
                            <li>
                                <a href="http://www.laofashigroup.com/contact-us/" target="_blank">
                                    <i class="icon-call-out"></i> 服务热线 400-821-0913 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
            <!-- BEGIN PAGE ACTIONS -->
            <div class="page-actions">
                <ul class="nav navbar-nav">
                    <li class="mega-menu-dropdown">
                        <a data-toggle="dropdown" href="javascript:;" class="btn blue-dark dropdown-toggle"
                           aria-expanded="false">
                            <i class="fa fa-search fa-2x"></i>
                        </a>

                        <div class="dropdown-menu dropdown-content input-large hold-on-click" role="menu">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">搜索凭证</div>
                                </div>
                                <div class="portlet-body">
                                    <form action="#">
                                        <div class="input-icon right">
                                            <i class="fa fa-search"></i>
                                            <input type="text" class="form-control" placeholder="输入凭证字号，日期，内容等...">
                                        </div>
                                    </form>
                                    <ul>
                                        <li>
                                            <a href="<?= $this->createUrl('Site/operation&operation=listTransition') ?>">逐月查询</a>
                                        </li>
                                        <li><a href="<?= $this->createUrl('transition/listreview') ?>">审核凭证</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="dropdown-menu-header"></div>
                        </div>
                    </li>
                    <li class="menu-dropdown mega-menu-dropdown">
                        <a data-toggle="dropdown" href="javascript:;"
                           class="btn blue-dark dropdown-toggle hover-initialized" aria-expanded="false">
                            <i class="fa fa-plus fa-2x"></i>
                        </a>

                        <div class="dropdown-menu dropdown-content input-xlarge hold-on-click" role="menu">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">新建</div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h4>组织</h4>
                                            <ul class="list-unstyled">
                                                <li><a href="<?= $this->createUrl('vendor/create') ?>">供应商</a></li>
                                                <li><a href="<?= $this->createUrl('client/create') ?>">客户</a></li>
                                                <li><a href="<?= $this->createUrl('department/create') ?>">部门</a></li>
                                                <li><a href="<?= $this->createUrl('employee/create') ?>">员工</a></li>
                                                <li><a href="<?= $this->createUrl('project/create') ?>">项目</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>凭证</h4>
                                            <ul class="list-unstyled">
                                                <? if (User2::model()->checkVIP()) {
                                                    ?>

                                                    <li>
                                                        <a href="<?= $this->createUrl('transition/purchase') ?>">采购交易</a>
                                                    </li>
                                                    <li><a href="<?= $this->createUrl('transition/sale') ?>">产品销售</a>
                                                    </li>
                                                <?
                                                }
                                                ?>
                                                <li><a href="<?= $this->createUrl('transition/bank') ?>">银行交易</a></li>
                                                <li><a href="<?= $this->createUrl('transition/cash') ?>">现金流水</a></li>
                                                <li><a href="<?= $this->createUrl('transition/create') ?>">手动输入</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>其它</h4>
                                            <ul class="list-unstyled">
                                                <li><a href="<?= $this->createUrl('subjects/create') ?>">会计科目</a></li>
<!--                                                <li><a href="--><?//= $this->createUrl('project/create') ?><!--">工程项目</a>-->
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-menu-header"></div>
                        </div>
                    </li>
                    <li class="mega-menu-dropdown">
                        <a data-toggle="dropdown" href="javascript:;" class="btn btn-lg blue-dark dropdown-toggle"
                           aria-expanded="false">
                            <i class="fa fa-history fa-2x"></i>
                        </a>

                        <div class="dropdown-menu dropdown-content input-xlarge hold-on-click" role="menu">
                            <div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">最新凭证操作日志</div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <table class="table table-condensed table-hover table-no-border">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    支付
                                                </td>
                                                <td>
                                                    2015/6/15
                                                </td>
                                                <td>
                                                    RMB2000.00
                                                </td>
                                                <td>
                                                    刘德华
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    支票支付-票号1
                                                </td>
                                                <td>
                                                    2015/6/14
                                                </td>
                                                <td>
                                                    RMB35000.00
                                                </td>
                                                <td>
                                                    李宗盛
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    新建发票#20150613
                                                </td>
                                                <td>
                                                    2015/6/13
                                                </td>
                                                <td>
                                                    RMB1200.00
                                                </td>
                                                <td>
                                                    张学友
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    应收账款
                                                </td>
                                                <td>
                                                    2015/6/10
                                                </td>
                                                <td>
                                                    RMB200000.00
                                                </td>
                                                <td>
                                                    乔布斯
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p><a href="#">更多...</a></p>
                                </div>
                            </div>
                            <div class="dropdown-menu-header"></div>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- END PAGE ACTIONS -->
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
            <ul class="page-sidebar-menu page-sidebar-menu-hover-submenu " data-keep-expanded="false"
                data-auto-scroll="true" data-slide-speed="200">
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
                        <li>
                            <a href="<?= $this->createUrl('Site/operation&operation=listReorganise') ?>">
                                <i class="glyphicon glyphicon-list"></i>
                                整理凭证</a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('transition/printp') ?>">
                                <i class="glyphicon glyphicon-print"></i>
                                打印凭证</a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('Site/operation&operation=listPost') ?>">
                                <i class="glyphicon glyphicon-import"></i>
                                过账</a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('Site/operation&operation=listSettlement') ?>">
                                <i class="glyphicon glyphicon-check"></i>
                                结账</a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('Site/operation&operation=listAntiSettlement') ?>">
                                <i class="glyphicon glyphicon-repeat"></i>
                                反结账</a>
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
                    <a href="javascript:;">
                        <i class="icon-drawer"></i>
                        <span class="title">库存商品</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= $this->createUrl('stock/admin') ?>">
                                <i class="icon-drawer"></i>
                                <span class="title">库存商品</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('product/stock') ?>">
                                <i class="icon-calculator"></i>
                                <span class="title">成本结转</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('stock/balance_1405') ?>">
                                <i class="icon-calculator"></i>
                                <span class="title">库存期初</span>
                            </a>
                        </li>
                    </ul>

                </li>
                <li>
                    <a href="javascript:;">
                        <i class="icon-drawer"></i>
                        <span class="title">固定资产</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= $this->createUrl('Site/operation&operation=listAssets') ?>">
                                <i class="icon-diamond"></i>
                                <span class="title">固定资产</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('stock/balance_1601') ?>">
                                <i class="icon-calculator"></i>
                                <span class="title">期初余额</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?= $this->createUrl('employee/admin') ?>">
                        <i class="icon-users"></i>
                        <span class="title">员工</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= $this->createUrl('employee/admin') ?>">
                                <i class="icon-users"></i>
                                <span class="title">员工列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('transition/salary') ?>">
                                <i class="icon-calculator"></i>
                                <span class="title">员工工资</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('transition/reimburse') ?>">
                                <i class="icon-calculator"></i>
                                <span class="title">员工报销</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $this->createUrl('department/admin') ?>">
                                <i class="icon-drawer"></i>
                                <span class="title">部门管理</span>
                            </a>
                        </li>
                    </ul>
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
        2015 &copy; <a href="http://www.laofashigroup.com" target="_blank">老法师（上海）财务咨询有限公司 版权所有</a>
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
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo $baseUrl; ?>/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo $baseUrl; ?>/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScript('MetronicInit', 'Metronic.init();', CClientScript::POS_READY);
$cs->registerScript('LayoutInit', 'Layout.init();', CClientScript::POS_READY);
?>
