<?
/*#批量审核
?资产负债表股东权益合计
批量导入员工,固定资产期初余额,选文件后，不显示文件名
供应商商 客户页面，搜索框给出提示
员工工资 搜索框无效
凭证查询 ，区间,文字搜索
报表默认日期，资产负债表，现金流量表，上月31号，科目余额表 本年1月至今，明细表，1001 本年1月至今
客户，供应商报表功能变更
在建工程添加成功后的提示
在建工程，长期待摊 显示未开工项目
部门报表 没有数据
科目余额表，无数据时，导出excel为乱码
银行转账，收入的情况，不生成凭证
普及版 标准版 专业版
供应商 客户管理界面 及报表，预付款金额计入本年已付，预收款计入本年已收
*/
/*
长期资产期初明细，包含在建工程
银行现金导入UI
预付款订单号应该显示银行或现金订单号
采购销售 金额合计没有自动算出来
修改过账结账流程
第一版，过账结账，
第二版，过账 -》 期末结转（结转凭证） -》 过账 -》结账
银行现金，供应商采购，订单过多，添加鼠标悬浮提示订单信息的地方，否则只有订单号无法分辨
*/
/* 2015年12月28日10:16:15
银行 现金，数据导入的步骤修改；
银行现金图片导入时，图片过大，预览会出现大小不匹配的问题；
商品采购UI优化；
大众版，银行现金不需要选择客户或供应商；
员工报销界面优化；
导入时，文件损坏检测；
权限控制（大更新）；
部分报表问题；
*/

/* 2016年1月14日19:53:38
明细表，可以选择一级科目，选择一级科目时列出所有子科目明细；
明细表，余额计算的问题，往来调整时涉及费用和收入类，如果计入贷方，结转凭证过账时没有将金额计算进来；
数据库更新 固定资产计提折旧，月份的计提次数重新判断；
权限完善修复；
下次更新激活码和激活码购买提交订单的功能；
*/
/*
2016年1月25日9:20:16
激活码激活及订单支付功能；
反结账时，显示月份按最近日期往前排列，如果直接反结账的话，直接就到账套起始日期了；
后台界面UI优化；
*/

/*
2016年2月25日14:23:57
后台界面及功能优化；
销售时添加自己的销售单号，数据库加字段；
销售模板，添加一列，客户自己的单号，重新检测匹配；
临时删除坏账处理功能，等功能开发好之后再重新启用；
多凭证保存时，修复后面的凭证会只生成借方或贷方的问题；
客户页面，添加账期账龄的显示；
*/

/*
2016年3月1日14:20:02
资产负债表2015年的期末和2016年期初不相等，报表过账功能完善；
无法生成Excel，仅本地服务器有问题，服务器无须更新;
快速查询搜索凭证功能；
余额表，科目排序规则优化；

*/

/*
2016年3月8日13:53:29

英文版；

*/


/*
2016年3月9日16:00:00

员工报销导入时，如果员工不在员工列表里，要提示；        done::林强
导入生成的凭证在查看时，由于凭证不能选择银行现金科目，导致凭证查看时科目不准确；    done::林强

*/

/* 2016年3月11日15:55:37
 * 后台页面优化
 * 结转时，如果是当年12月，多生成一条凭证，借本年利润，贷利润分配/未分配利润，反结转时自动删除；
 *
 */


/* 2016年3月14日
 * 查询凭证的结果导出时乱码，excel_export.js；
 * 过账、结账、结转、反结账，都以弹出的形式；
 * ilaofashi.com QQ登录；
 * 客户，供应商 账龄重新计算；
 * 银行交易模板大众版和标准版不匹配的问题；
 *
 */

/*
 * 2016年3月22日11:23:57
 * 标准版 客户->坏账处理；
 * 添加行政支出选项，显示管理费用除工资社保外的所有子科目；
 * 标准版，支出->工资社保，分为两项：工资与奖金 、社保公积金，都计入应付职工薪酬下；
 * 结账时检查前期是否已经结账；
 * 大众版，销售收入添加5%的营业税；
 * 整理凭证后，日期只显示整理过的那个月；
 * 销售批量删除功能修复；
 *
 */

/*
 * 员工报销时，分批次报销金额等于剩余金额时，科目应该计入其他应付？？？未找到bug重现情况
 * 客户，供应商 账龄的权限控制；
 * 账号申请加入同一个组；
 * 固定资产无形资产 总账期初余额和明细的计算，把已经折旧的金额也计算在内；
 * 银行现金记账时，没有找到匹配时，仍然没有显示所有选项；
 * 权限控制时，检测被编辑用户是否和当前登录用户在同一个组；
 * 账号权限全部取消并保存后，认为拥有所有权限；
 * 权限，总账期初余额，可以查看，客户和供应商类似；
 * 审核凭证没有权限时，没有提示；
 * 删除银行现金时，如果没有权限，不显示403数字，只显示中文；
 * 错误页UI；
 * 报表默认日期，为有账的最后一个月，当前日期可能还没做账，所以不一定是当月，比如：余额表；
 * 账套没有权限时，账套首页也不能查看；
 * 年终奖的设置；
 *
 * 现金流量表，利息收入单独放在其他经营性支出；
 * 现金流量表，主营业务成本从其他经营活动转入劳务支付的现金；
 * 结转凭证过账时，对是否有新凭证生成，需要重新过账的判断；

*/







