<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Wojia',
    'theme'=>'account',
    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.models.reports.*',
        'application.components.*',
    ),

    'modules'=>array(
        // uncomment the following to enable the Gii tool

        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'development',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1','*'),
        ),

    ),

    // application components
    'components'=>array(
        'format'=>array('class'=>'YFormatter'),
        'user'=>array(
            // enable cookie-based authentication
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format
        /*
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        */
        // uncomment the following to use a MySQL database

        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=account',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),

        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('127.0.0.1','*'),
                    'levels'=>'error, warning',
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'levels' => 'profile',
                    'enabled' => true,
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        // custom CGridView widget style
        'widgetFactory'=>array(
            'widgets'=>array(
                'CGridView'=>array(
                    'cssFile' => '/css/gridview.css',
                ),
            )
        )
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
        'sbj_cat'=>array(1 =>  '资产类 ' ,2 =>  '负债类 ' ,3 =>  '权益类 ' ,4 =>  '收入类 ' ,5 =>  '费用类'),
        'startDate'=>'201312',
        'profitReport' => array(55,56,57,58,59,60,61,62,63,64,65,66,67,68,69),

        'balanceReport_sum'=>array(
                                   array("id"=>"flow_property", "name"=>"流动资产合计", "to"=>"property", "function"=>"sum"),
                                   array("id"=>"unflow_property", "name"=>"非流动资产合计", "to"=>"property", "function"=>"sum"),
                                   array("id"=>"property", "name"=>"资产合计"),
                                   array("id"=>"flow_debt", "name"=>"流动负债合计", "to"=>"debt", "function"=>"sum"),
                                   array("id"=>"unflow_debt", "name"=>"非流动负债合计", "to"=>"debt", "function"=>"sum"),
                                   array("id"=>"debt", "name"=>"负债合计", "to"=>"debt_owner", "function"=>"sum"),
                                   array("id"=>"parent_owner", "name"=>"归属于母公司股东权益(所有者权益)合计", "to"=>"owner", "function"=>"sum"),
                                   array("id"=>"owner", "name"=>"股东权益(所有者权益)合计", "to"=>"debt_owner", "function"=>"sum"),
                                   array("id"=>"debt_owner", "name"=>"负债及股东权益(所有者权益)合计"),
                                   ),
        'balanceReport'=>array(
                               array("id"=>1,"name"=>"货币资金","subjects"=>array(1001,1002,1003,1102,1021,1031), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>2 ,"name"=>"交易性金融资产","subjects"=>array(1101, 1121), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>3 ,"name"=>"应收票据","subjects"=>array(1121), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>4 ,"name"=>"应收账款","subjects"=>array(1122), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>5 ,"name"=>"预付账款","subjects"=>array(1123), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>6 ,"name"=>"应收股利","subjects"=>array(1131), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>7 ,"name"=>"应收利息","subjects"=>array(1132), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>8 ,"name"=>"其他应收款","subjects"=>array(1201,1211,1212,1221), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>9 ,"name"=>"减:坏账准备","subjects"=>array(1231), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>10 ,"name"=>"其他流动资产","subjects"=>array(1301,1302,1303,1304,1311,1321), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>11 ,"name"=>"存货","subjects"=>array(1401,1402,1403,1404,1405,1406,1407,1408,1411,1421,1431,1441,1451,1461), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>12 ,"name"=>"减:存货跌价准备","subjects"=>array(1471), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>13 ,"name"=>"持有至到期投资","subjects"=>array(1501), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>14 ,"name"=>"减:持有至到期投资减值准备","subjects"=>array(1502), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>15 ,"name"=>"可供出售金融资产","subjects"=>array(1503), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>16 ,"name"=>"长期股权投资","subjects"=>array(1511), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>17 ,"name"=>"减:长期股权投资减值准备","subjects"=>array(1512), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>18 ,"name"=>"投资性房地产","subjects"=>array(1521), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>19 ,"name"=>"长期应收款","subjects"=>array(1531)),
                               array("id"=>20 ,"name"=>"其它非流动资产","subjects"=>array(1532,1541,1611,1621,1622,1623,1631,1632,1821,1901), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>21 ,"name"=>"固定资产","subjects"=>array(1601), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>22 ,"name"=>"减:累计折旧","subjects"=>array(1602), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>23 ,"name"=>"减:固定资产减值准备","subjects"=>array(1603), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>24 ,"name"=>"在建工程","subjects"=>array(1604), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>25 ,"name"=>"工程物资","subjects"=>array(1605), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>26 ,"name"=>"无形资产","subjects"=>array(1701,1702), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>27 ,"name"=>"减:无形资产减值准备","subjects"=>array(1703), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>28 ,"name"=>"商誉","subjects"=>array(1711), "to"=>"flow_property", "function"=>"sum"),
                               array("id"=>29 ,"name"=>"长期待摊费用","subjects"=>array(1801), "to"=>"flow_property", "function"=>"minus"),
                               array("id"=>30 ,"name"=>"递延所得税资产","subjects"=>array(1811), "to"=>"flow_property", "function"=>"sum"),
                               //负债类
                               array("id"=>31 ,"name"=>"短期借款","subjects"=>array(2001,2002,2003,2204,2011,2012,2021), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>32 ,"name"=>"交易性金融负债","subjects"=>array(2101,2111), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>33 ,"name"=>"应付票据","subjects"=>array(2201), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>34 ,"name"=>"应付账款","subjects"=>array(2202), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>35 ,"name"=>"预收账款","subjects"=>array(2203), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>36 ,"name"=>"应付职工薪酬","subjects"=>array(2211), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>37 ,"name"=>"应交税费","subjects"=>array(2221), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>38 ,"name"=>"应付利息","subjects"=>array(2231), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>39 ,"name"=>"应付股利","subjects"=>array(2232), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>40 ,"name"=>"其他应付款","subjects"=>array(2241,2251,2261), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>41 ,"name"=>"其他流动负债","subjects"=>array(2311,2312,2313,2314,2401), "to"=>"flow_debt", "function"=>"sum"),
                               array("id"=>42 ,"name"=>"长期借款","subjects"=>array(2501), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>43 ,"name"=>"应付债券","subjects"=>array(2502), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>44 ,"name"=>"其他非流动负债","subjects"=>array(2601,2602,2611,2621), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>45 ,"name"=>"长期应付款","subjects"=>array(2701,2702), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>46 ,"name"=>"专项应付款","subjects"=>array(2711), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>47 ,"name"=>"预计负债","subjects"=>array(2801), "to"=>"unflow_debt", "function"=>"sum"),
                               array("id"=>48 ,"name"=>"递延所得税负债","subjects"=>array(2901), "to"=>"unflow_debt", "function"=>"sum"),

                               //权益类
                               array("id"=>50 ,"name"=>"股本(实收资本)","subjects"=>array(4001), "to"=>"parent_owner", "function"=>"sum"),
                               array("id"=>51 ,"name"=>"资本公积","subjects"=>array(4002), "to"=>"parent_owner", "function"=>"sum"),
                               array("id"=>52 ,"name"=>"盈余公积","subjects"=>array(4101,4102), "to"=>"parent_owner", "function"=>"sum"),
                               array("id"=>53 ,"name"=>"未分配利润","subjects"=>array(4103,4104), "to"=>"parent_owner", "function"=>"sum"),
                               array("id"=>54 ,"name"=>"减:库存股","subjects"=>array(4201), "to"=>"parent_owner", "function"=>"sum"),

                               //收入类
                               array("id"=>55 ,"name"=>"一、营业收入","subjects"=>array(6001,6011,6021,6031,6041,6051)),
                               array("id"=>56 ,"name"=>"财务费用","subjects"=>array(6061)),
                               array("id"=>57 ,"name"=>"加:公允价值变动收益","subjects"=>array(6101)),
                               array("id"=>58 ,"name"=>"投资收益","subjects"=>array(6111)),
                               array("id"=>59 ,"name"=>"财务费用","subjects"=>array(6201,6202,6203)),
                               array("id"=>60 ,"name"=>"加:营业外收入","subjects"=>array(6301)),

                               //费用类
                               array("id"=>61 ,"name"=>"减:营业成本","subjects"=>array(6401,6402)),
                               array("id"=>62 ,"name"=>"营业税金及附加","subjects"=>array(6403)),
                               array("id"=>63 ,"name"=>"财务费用","subjects"=>array(6411,6421,6501,6502,6511,6521,6531,6541,6542,6603)),
                               array("id"=>64 ,"name"=>"销售费用","subjects"=>array(6601)),
                               array("id"=>65 ,"name"=>"管理费用","subjects"=>array(6602,6604)),
                               array("id"=>66 ,"name"=>"资产减值损失","subjects"=>array(6701)),
                               array("id"=>67 ,"name"=>"减:营业外支出","subjects"=>array(6711)),
                               array("id"=>68 ,"name"=>"减:所得税费用","subjects"=>array(6801)),
                               array("id"=>69 ,"name"=>"未分配利润","subjects"=>array(6901)),
                               ),
    ),
);