<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" href="<?php echo Yii::app()->homeUrl ?>">我嘉 <small>财务管理系统</small></a>
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
                    'encodeLabel'=>false,
                    'items'=>array(
                        //array('label'=>'首页', 'url'=>array('/site/index')),
                        array('label'=>'文件 <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-2"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label' => '导入', 'url'=>'#'),
                            array('label' => '导出', 'url'=>'#'),
                            array('label' => '打印', 'url'=>'#'),
                            array('label' => '备份', 'url'=>'#'),
                            array('label' => '恢复', 'url'=>'#'),
                        )),
                        array('label'=>'设置 <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-3"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                             array('label' => '公司信息', 'url'=>'#'),
                             array('label' => '项目', 'url' => array('/project/admin')),
                             array('label' => '部门', 'url' => array('/department/admin')),
                             array('label' => '员工', 'url' => array('/employee/admin')),
                             array('label' => '供应商', 'url' => array('/vendor/admin')),
                             array('label' => '客户', 'url' => array('/client/admin')),
                             array('label' => '管理员', 'url'=>'#'),
                             )),
                        array('label'=>'总账 <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-4"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                             array('label' => '查询', 'url'=>'#'),
                             array('label' => '科目表', 'url' => array('/subjects/admin'),), //Subjects下所有操作高亮
                             array('label' => '期初余额', 'url'=>'#'),
                             array('label' => '结账', 'url' => array('/Site/operation&operation='. 'listSettlement')),
                             array('label' => '反结账', 'url' => array('/transition/antisettlement')),
                             array('label' => '过账', 'url' => array('/Site/operation&operation='. 'listPost')),
                             array('label' => '账套打印', 'url'=>'#'),
                             )),
                        array('label'=>'凭证 <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-5"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                             array('label' => '查询凭证', 'url' => array('/transition/index'), 'active'=>$this->id=='transition'?true:false),
                             array('label' => '填制凭证', 'url' => array('/transition/create')),
                             array('label' => '审核凭证', 'url' => array('/transition/listreview')),
                             array('label' => '整理凭证', 'url' => array('/Site/operation&operation='. 'listReorganise')),
                             array('label' => '打印凭证', 'url'=>'#'),
                             )),
                        array('label'=>'报表 <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-6"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                             array('label' => '资产负债表', 'url' => array('report/balance')),
                             array('label' => '损益表', 'url' => array('report/profit')),
                             array('label' => '科目余额表', 'url' => array('report/subjects')),
                             array('label' => '明细表', 'url' => array('report/detail')),
                             array('label' => '现金流量表', 'url'=>'#'),
                             array('label' => '供应商表', 'url'=>'#'),
                             array('label' => '客户表', 'url' => array('report/client')),
                             array('label' => '项目表', 'url'=>'#'),
                             array('label' => '部门表', 'url'=>'#'),
                             array('label' => '项目与部门核算表', 'url'=>'#'),
                             )),                        
                        /*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/
                        array('label'=>'Templates <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-7"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'Graphs & Charts', 'url'=>array('/site/page', 'view'=>'graphs')),
                            array('label'=>'Forms', 'url'=>array('/site/page', 'view'=>'forms')),
                            array('label'=>'Tables', 'url'=>array('/site/page', 'view'=>'tables')),
                            array('label'=>'Interface', 'url'=>array('/site/page', 'view'=>'interface')),
                            array('label'=>'Typography', 'url'=>array('/site/page', 'view'=>'typography')),
                            array('label'=>'Grid', 'url'=>array('/site/page', 'view'=>'about')),
                            array('label'=>'Contact', 'url'=>array('/site/contact', 'view'=>'contact')),

                        )),
                        array('label'=>'登录', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array('label'=>'<i class="icon-user icon-white"></i> '.Yii::app()->user->name.' <span class="caret"></span>', 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest,'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-8"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array(
                            array('label'=>'系统信息 <span class="badge badge-warning pull-right">26</span>', 'url'=>'#'),
							array('label'=>'任务 <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
							array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
							array('label'=>'<div class="divider"></div>'),
	                        array('label'=>'退出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout')),
                        )),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">

			<div class="pull-left">
			<?php
			if (isset($this->breadcrumbs)): 
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'tagName'=>'ol',
				'activeLinkTemplate'=>'<li class="active"><a href="{url}">{label}</a></li>',
				'inactiveLinkTemplate'=>'<li>{label}</li>',
				'homeLink'=>'<li><a href="'.Yii::app()->homeUrl.'">首页</a></li>',
				'htmlOptions'=>array('class'=>'breadcrumb')
				)
			); 
			endif
			?>
			</div><!-- breadcrumbs Modified by Michael ZHANG-->
        	<div class="style-switcher pull-right">
                <a href="javascript:chooseStyle('none', 60)" checked="checked"><span class="style" style="background-color:#0088CC;"></span></a>
                <a href="javascript:chooseStyle('style2', 60)"><span class="style" style="background-color:#7c5706;"></span></a>
                <a href="javascript:chooseStyle('style3', 60)"><span class="style" style="background-color:#468847;"></span></a>
                <a href="javascript:chooseStyle('style4', 60)"><span class="style" style="background-color:#4e4e4e;"></span></a>
                <a href="javascript:chooseStyle('style5', 60)"><span class="style" style="background-color:#d85515;"></span></a>
                <a href="javascript:chooseStyle('style6', 60)"><span class="style" style="background-color:#a00a69;"></span></a>
                <a href="javascript:chooseStyle('style7', 60)"><span class="style" style="background-color:#a30c22;"></span></a>
          	</div>
          <!--
           <form class="navbar-search pull-right" action="">
           	 
           <input type="text" class="search-query span2" placeholder="Search">
           
           </form> -->
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->