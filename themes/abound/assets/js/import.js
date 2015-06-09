/**
 * Created by pdwjun on 2015/3/4.
 */
$(document).ready(function () {
    $("#selectItem2").val(2);
    $("#selectItem3").val(3);
    $("#dialog").hide();
    $("div").on('blur', "input[id*='tran_amount']", function (e) {
        sumAmount(this.parentNode.parentNode)
    })
    $("div").delegate("#new-invoice", "change", function () {
        $("select[name='new-category']").hide();
        //if ($("#new-category-" + this.value).children().length > 1)
        $("#new-category-" + this.value).show();
        //可以重新考虑后台设置此处的显示规则
        if (this.value == 2)   //和发票有关
            $("#new-category-3").show();
    })
    $("div").delegate("#droplist", "change", function () {
        chooseOption(this)
    })
})
$(window).bind("load", function() {
    $("#subject_2").select2("readonly",true);
    // code here
});
function itemsplit(e) {

    //直接复制  需要重新设置item 和 id
    $(e.parentNode.parentNode.parentNode).after($(e.parentNode.parentNode.parentNode).clone());
    //$(e.parentNode.parentNode.nextSibling.lastChild.previousSibling.previousSibling));
    $(e.parentNode.parentNode.parentNode.nextSibling).find("input[name*='amount']").val(0);
    $(e.parentNode.parentNode.parentNode.nextSibling).find("span[class*='tip']").remove();

    //设置id 条目 的name属性 lists[<?= $key ?>][Transition][entry_subject]
    var id = (parseInt($("#rows").val()) + 1).toString();
    $.each($(e.parentNode.parentNode.parentNode.nextSibling).find("input[name^='lists']"), function (key, value) {
        var name = $(value).attr("name");
        if (name != "" && name) {
            name = name.replace(/\[\d*\]/, "[" + id + "]");
            $(value).attr("name", name);
        }
    })
    $.each($(e.parentNode.parentNode.parentNode.nextSibling).find("[id*='_']"), function (key, value) {
        var item_id = $(value).attr("id");
        if (item_id.substr(0, 3) == 'id_')
            $(value).val(id)
        if (item_id != "" && item_id) {
            item_id = item_id.replace(/_\d+/, "_" + id);
            $(value).attr("id", item_id);
        }
        if (item_id.substr(0, 7) == "btn_del") {
            $(value).removeAttr("disabled");
        }
    })
    $("#rows").val(id);
}

function itemclose(e) {
    var line = $(e.parentNode.parentNode.parentNode).attr("line");
    e.parentNode.parentNode.parentNode.remove();
    sumAmount($("#data_import").find("tr[line="+line+"]:first"));
}
function itemsetting(e) {
    //$("#itemSetting").dialog({
    //    autoOpen: true,
    //    width: "80%",
    //    height: "500",
    //    show: "blind",
    //    hide: "explode",
    //    modal: true     //设置背景灰的
    //});
    //cleanDialog();
    //$("#itemSetting").dialog("open");
    if (!$("#trSetting").is(":visible")) {
        $(e.parentNode.parentNode.parentNode).after($("#trSetting"));
        $("#trSetting").show();
        $("#itemSetting").slideDown();
        var id = $(e.parentNode.parentNode).find("input[id^='id_']")[0].value;
        $("#item_id").val(id);
        $("#data").val(getInfo(e.parentNode));
        unsetting();
    } else
        dialogClose();
}
function chooseType(e, a) {
    $.ajax({
        type: 'POST',
        cache: false,
        url: $("#type").val(),
        data: {"type": a},
        success: function (data) {
            var data = JSON.parse(data);
            var str = '<div class="options-div"><span class="fa fa-angle-right flow-arrow"></span></div>' +
                '<div class="options btn-group-xs" >';
            $.each(data, function (key, value) {
                str += '<button class="btn btn-default" type="button" onclick="chooseOption(this)" value="' + key + '">' + value + '</button><br />'
            });
            str += '</div>';
            choosed(e);
            $(e).parent().nextAll().remove();
            $(e).parent().after(str);
            setWidth(e)
        },
        error: function (e) {
            //alert(e);
        }
    });
}
//按钮激活状态
function choosed(e) {
    $(e).parent().children('button').removeClass('active');
    $(e).parent().children('button').children('i').remove();
    $(e).addClass('active');
    active(e);
}
//选择子选项 p:父id，e当前id
function chooseOption(e) {
    id = $("#item_id").val()
    choosed(e);
    var options = "1";
    $.each(Array.prototype.reverse.call($(e).parent().prevAll('.options')), function (key, value) {
        options += "," + $(value).find("button[class*='active']").val()
    })
    options += "," + e.value;
    $.ajax({
        type: 'POST',
        url: $("#option").val(),
        data: {"type": getType(), "option": options, "data": $("#data").first().val()},
        success: function (msg) {
            var data = JSON.parse(msg);
            if (data.rule == 'end') {
                $("#subject").val(data.subject);
                $(e).parent().nextAll().remove();
                var str = '<div class="options-div"><span class="fa fa-angle-right flow-arrow"></span></div><div class="options alert alert-success alert-dismissable">';
                str += '<i class="icon fa fa-check"></i> 已选择 => <span id="sub_name">"' + data.sbj_name + '"</span>';
                if (data.option != 0) {
                    $.each(data.option, function (key, value) {
                        if (value[0] == 'text')
                            str += '<br ><input type="text" name="new-option" id="new-option" placeholder="' + value[1] + '" >'
                        if (value[0] == 'select') {

                        }
                        if (value[0] == 'checkbox') {
                            str += '<br ><input type="checkbox" name="new-option" id="new-option" >' + value[1] + '<br >'
                        }
                    })
                }
                str += '</div>';
                $(e).parent().after(str);

            }
            else if (data.rule == 'goon') {
                var str = '<div class="options-div"><span class="fa fa-angle-right flow-arrow"></span></div>' +
                    '<div class="options btn-group-xs" >';
                if (data.type == 'droplist') {
                    str += '<select id="droplist" class="selectSetting" ><option>请选择</option>';

                    $.each(data.data, function (key, value) {
                        if (IsNum(key.toString().substring(1))) //json.parse会把数组重新排序，所以key为数字数组，key前面都添加了下划线'_'
                            key = key.toString().substring(1)
                        str += '<option value="' + key + '">' + value + '</option>'
                    });
                    str += '</select>'
                } else
                    $.each(data.data, function (key, value) {
                        if (IsNum(key.toString().substring(1))) //json.parse会把数组重新排序，所以key为数字数组，key前面都添加了下划线'_'
                            key = key.toString().substring(1)
                        str += '<button class="btn btn-default" type="button" onclick="chooseOption(this)" value="' + key + '">' + value + '</button><br />'
                    });
                if (data.option != 0) {
                    $.each(data.option, function (key, value) {
                        if (value[0] == 'text')
                            str += '<input type="text" name="option-' + key + '" id="option-' + key + '" placeholder="' + value[1] + '" ><br >'
                        if (value[0] == 'select') {
                            str += '<select name="option-' + key + '" id="option-' + key + '">';
                            $.each(value[1], function (key, value) {
                                str += '<option value="' + key + '">' + value + '</option>';
                            })
                            str += '</select>';
                        }
                    })
                }
                if (data.new == 'allow') {
                    var newsbj, newsbjname = ''
                    if (data.newsbj != null && data.newsbj != '') {
                        newsbj = data.newsbj;
                        newsbjname = data.newsbjname;
                    }
                    str += '<input type="hidden" name="new-type" id="new-type" value="1">' +
                    '<input type="hidden" id="new-subject" name="new-subject" value="' + newsbj + '" > ' +
                    '<input type="hidden" id="new-sbjname" value="' + newsbjname + '" > ' +
                    '<input type="text" class="new-item" placeholder="手动填写" id="new-name" name="new-name" value="' + $("#tran_name_" + id).val() + '" >';

                    if (data.list != '') {
                        str += '<select id="new-invoice" name="new-invoice" data-placeholder="请选择">';
                        $.each(data.list, function (key, value) {
                            str += '<option value="' + key + '">' + value + '</option>';
                        })
                        str += '</select><br >';
                        $.each(data.select, function (key, value) {
                            str += '<select name="new-category" id="new-category-' + key + '"';
                            if (key != 1)
                                str += 'style="display: none" >';
                            else
                                str += ' >';
                            $.each(value, function (k, e) {
                                str += '<option value="' + k.toString().substring(1) + '">' + e + '</option>';
                            })
                            str += '</select>';
                        });
                    }
                    str += '<br ><button value="" type="button" id="button" onclick="chooseSubject(this)">新建</button>'
                }
                else if (data.new == 'employee') {
                    str += '<input type="hidden" name="new-type" id="new-type" value="2">' +
                    '<input type="text" class="new-item" placeholder="新员工姓名" id="new-name" name="new-name"  value="' + $("#tran_name_" + id).val() + '" >' +
                    '<br ><select id="new-department" name="new-department" data-placeholder="新员工所属部门">';
                    $.each(data.list, function (key, value) {
                        str += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
                    })
                    str += '</select><br ><input type="button" value="添加新员工" onclick="addNew(this)"> ';
                }
                str += '</div>';

                choosed(e);
                $(e).parent().nextAll().remove();
                $(e).parent().after(str);
                //$("#droplist").select2();
                //if (data.new == 'employee')
                //    $("#new-department").select2();
                if (data.target == true) {
                    $("div.options").removeClass("target");
                    $("div.options").last().addClass("target");
                }
            }
            setWidth(e);
        },
        error: function (msg) {
            //alert(msg);
        }
    })
}

//确定按钮，设置 科目编号
function itemSet() {
    //如果有需要添加新元素，比如新员工 新的公司名字 新供应商等
    //addNew();
    $sbj = $("#subject").val();
    var item_id = $("#item_id").val()
    unset(item_id);
    e = $("#info_" + item_id);
    e.removeClass();
    setTransaction(item_id);
    if ($sbj != "") {
        $("#subject_" + item_id).val($sbj);
        e.attr('title', $sbj);
        //显示选择路径
        var str = "";
        $.each($(".options").find("button[class*='active']"), function (key, value) {
            if ($(value).html() == '选择') {
                str += "=>" + $(value).val();
            }
            else if ($(value).html() == '有溢价') {
                $("#additional_sbj0_" + item_id).val(4002);//溢价金额作为资本公积4002贷方
                amount = parseFloat($("#tran_amount_" + item_id).val())
                $("#additional_amount0_" + item_id).val(amount - parseFloat($("#new-option").val()));
            }
            else
                str += "=>" + removePath($(value).html());
        })
        //设置含税，简单版可以这样设置，复杂版要重新设计
        if ($("#new-option").is(":checked") == true)
            $("#withtax_" + item_id).val(1);
        else
            $("#withtax_" + item_id).val(0);
        e.html(str);
        e.addClass("path-success");
    }
    else {
        e.addClass("path-fail");
        e.html("未选择");
    }
    setTarget(item_id);
    dialogClose();
}
//保存凭证，此时再根据选择的科目计算一些数值
function save() {
    //判断银行是否锁定
    if (!checkBank())
        return true;
    if (!checkInput())
        return true;
    $("#abc table tr:first").nextAll('tr:visible[id!=trSetting]').each(function (key, value) {
        var item_id = $(value).find("input[id^='id_']").val();
        var sbj = $("#subject_" + item_id).val();
        $("#invoice_" + item_id).val($("#new-invoice").val() == 2 ? 1 : 0);
        $("#tax_" + item_id).val($("#withtax_" + item_id).val() == 1 ? 3 : 0);

        //主营业务收入才计算税率
        if (sbj.substr(0, 4) == "6001" && $("#withtax_" + item_id).val() == 1)
            setTax(item_id);    //设置税
    })
    $("#form").submit();
}

//获取当前交易行的信息，1、日期 2、说明 3、金额，值的顺序根据getListTitle有所不同
function getInfo(e) {
    var items = $(e).parent().parent().find('input');
    var info = new Array();
    var turn = getListTitle();
    $.each(items, function (key, value) {
        //前2个是checkbox和交易方名称，不用修改顺序
        if (key < 2)
            info[key] = value.value;
        else
            info[parseInt(turn[key - 2]) + 1] = value.value;
    })
    info = info.join('|');
    return info;
}

//获取银行对账单的列名和顺序
function getListTitle() {
    return [$("#selectItem1").val(), $("#selectItem2").val(), $("#selectItem3").val()];
}

//支出或收入
function getType() {
    if ($("#setting").children(":first").find("button[class*='active']").val().trim() == "支出")
        return 1;
    else
        return 2;
}

function cleanDialog() {
    $("#subject").val("");
    $("#setting div:first-child").nextAll().remove();

}
function dialogClose() {

    $("#trSetting").hide('100');
    $("#itemSetting").hide();
}
//总金额
function sumAmount(e) {
    var l = $(e).attr("line");
    var amount = 0;
    $.each($("tr[line='" + l + "']"), function (key, value) {
        amount += parseFloat($(value).find("input[name*='amount']").val() != "" ? $(value).find("input[name*='amount']").val() : 0);
    })
    $($("#amount_" + l)[0]).html(amount);
}
function addNew(e) {
    var a = $(e).parent();
    if (a.children("input[name=new-name]").val() != "") {
        switch (a.children("input[name=new-type]").val()) {
            case "2"  :   //新员工
                //提示已经已经有员工叫该名字
                var name = $("#new-name").val();
                if (a.children("button:contains(" + name + ")").length !== 0) {
                    var r = confirm("已经存在员工名字包含： " + name + " ，是否继续添加");
                    if (!r)
                        return true;
                }
                $.ajax({
                    type: "POST",
                    url: $("#employee").val(),
                    data: {
                        name: a.children("input[name=new-name]").val(),
                        department: a.children("select[name=new-department]").val()
                    },
                    success: function (data) {
                        if (a.children("button[value=" + data + "]").length != 0) { //检测是否已经存在
                            a.children("button[value=" + data + "]")[0].click();
                        } else {
                            var str = '<button class="btn btn-default" type="button" onclick="chooseOption(this)" value="' +
                                data + '">' + a.children("select[name*=new-depart]")[0].selectedOptions[0].innerHTML + '/' + a.children("input[name=new-name]").val() + '</button><br />'
                            a.prepend(str);
                            a.children(":first-child").click();
                        }
                    },
                    error: function (msg) {
                        alert('添加员工失败');
                    }
                });
                break;
            case "1" :  //新子科目
                if (a.children("input[name=new-subject]").val() == "undefined") {
                    a.children("input[name=new-subject]").val($("#new-category-2").val());
                    $("#new-sbjname").val($("#new-category-2 option:selected").text());
                }
                $.ajax({
                    type: "POST",
                    url: $("#new-url").val(),
                    data: {
                        name: a.children("input[name=new-name]").val(),
                        subject: a.children("input[name=new-subject]").val()
                    },
                    success: function (msg) {
                        if (a.children("button[value=" + msg + "]").length != 0) { //检测是否已经存在
                            a.children("button[value=" + msg + "]")[0].click();
                        } else {
                            var str = '<button class="btn btn-default" type="button" onclick="chooseOption(this)" value="' +
                                msg + '">' + a.children("#new-sbjname").val() + '/' + a.children("input[name=new-name]").val() + '</button><br />'
                            a.prepend(str);
                            a.children(":first-child").click();
                        }

                    }
                })
                break;
            case "3" :  //

        }
    }
}
/*
 检查是否为数字
 */
function IsNum(s) {
    if (s != null && s != "") {
        return !isNaN(s);
    }
    return false;
}

/*
 * 选择科目，
 */
function chooseSubject(e) {
    if ($("#new-invoice").val() == 1) { //第一个下拉框，如果是否定的，才会新建子科目；比如 不是借款 无发票
        var sbj = $("select:visible[id*='new-category-']")[0].value;
        $("#new-subject").val(sbj);
        $("#new-sbjname").val($("select:visible[id*='new-category-']")[0].innerHTML);
        addNew(e);  //后台判断是否已经创建过该
        return true;
    }

    if ($("#new-subject").val() != "") { //new-subject已经有值，则可以新建
        addNew(e);  //后台判断是否已经创建过该
        return true;
    }
    chooseOption($("select:visible[id*='new-category-']")[0]);
    $("#button").val($("select:visible[id*='new-category-']")[0].selectedOptions[0].innerHTML)

    //}
    choosed($("#button"));
}
function setTax(item_id) {
    //设置相关参数值，现在默认最多2个参数，如果过多要重新写函数
    //设置税费，目前只设置税费
    //简单版，统一税率为3%
    //if($("#new-category-3").is(":visible")){
    $("#additional_sbj0_" + item_id).val(222102);//科目编号,应交税费2221的二级科目 进项（采购默认）参考gbl数据库
    var amount = 0;
    if ($("#tran_amount_" + item_id != ''))
        amount = parseFloat($("#tran_amount_" + item_id).val());
    //var tax = $("#new-category-3").val()    //税率
    var tax = 3;
    amount = amount - amount / (100 + parseFloat(tax)) * 100;

    $("#additional_amount0_" + item_id).val(amount);

    //}
}
//设置按钮宽度
function setWidth(e) {
    var width = Math.max.apply(Math, $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').map(function () {
        return $(this).width();
    }).get());
    $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').width(width);
    $(e.parentNode.nextSibling.nextSibling).find('input[class*="new-"]:visible').width(width);
}

//设置交易方名称
function setTarget(id) {
    var target = $("div.target > button.active").html();
    if (target != undefined && $("#tran_name_" + id).val()=="")
        $("#tran_name_" + id).val(removePath(target));
}

//去除路径，只保留交易方名称abc ，路径格式为 ***/**/abc
function removePath(path) {
    //正则匹配
    var reg = /[^/]([^\x00-\xff]|\w)+(<i>|$)/;
    if (reg.test(path)){
        path = path.match(reg)
        reg = /[^<i>]*/;
        return path[0].match(reg);
    }
    else
        return path;
}

//设置凭证 借贷
function setTransaction(id) {
    var type = $(".options:first > button.active").val();
    if (type == '支出')
        $("#transaction_" + id).val(1)
    if (type == '收入'){
        $("#transaction_" + id).val(2)
    }
    if ($("#subject").val()==660302)
        $("#transaction_" + id).val(1)
    //设置是否需要生成凭证，例：银行互转，收入方不需要
    var option = $(".options:nth-of-type(3) > button.active").val();
    if (option=='银行转账')
        $("#enable_"+ id).val("0")
    else
        $("#enable_"+ id).val("1")
}

//消除数据，设置前先消除
function unset(id) {
    var sbj = $("input[name^='lists\[" + id + "\]\[Transition\]\[entry_subject\]']").val();
    var sbja = $("input[name^='lists\[" + id + "\]\[Transition\]\[entry_transaction\]']").val();
    $("input[name^='lists\[" + id + "\]\[Transition\]'][type='hidden'][id!='did_" + id + "']").val("");
    //如果选择了项目，才消除 已经存在的科目编号
    $("input[name^='lists\[" + id + "\]\[Transition\]\[entry_subject\]']").val(sbj);
    $("input[name^='lists\[" + id + "\]\[Transition\]\[entry_transaction\]']").val(sbja);
}
//清除科目选择里面的数据，否则直接点确定的话，subject里面有上一次的科目编号
function unsetting(){
    $("#subject").val('')
}

function checkInput() {
    var check = true;
    $.each($("input[id*='tran_memo_']"), function (key, e) {
        if (e.value == '') {
            $(e).after('<span class="info_warning" >不能为空</span>');
            check = false;
        }
    })
    $.each($("input[id*='tran_amount_']"), function (key, e) {
        if (e.value == '') {
            $(e).after('<span class="info_warning" >金额不能为空</span>');
            check = false;
        } else {
            var b = /-?[1-9]?\d*\.?\d?\d?|-?0\.\d?\d?/;
            if (e.value != b.exec(e.value)) {
                $(e).after('<span class="info_warning" >金额格式不正确</span>');
                check = false;
            }
        }

    })
    return check;
}

function checkBank(){
    if ($("#subject_2").attr("readonly")==undefined)
        alert("请锁定银行")
    else
        return true;
}

function createSubject(url, data) {
    var result = 0;
    $.ajax({
        async: false,
        type: "POST",
        url: url,
        data: data,
        //{
        //        name: a.children("input[name=new-name]").val(),
        //        subject: a.children("input[name=new-subject]").val()
        //    },
        success: function (data) {
            result = data;
        },
        error: function (msg) {
            result = msg;
        }
    })
    return result;
}

/*
 添加银行 银行存款二级科目
 */
function addBank() {
    var url = $("#new-url").val();
    var name = $("#bank_name").val();
    var data = {
        name: name,
        subject: 1002
    }
    var msg = createSubject(url, data);
    if (msg > 0 && $("#subject_2 > option[value='" + msg + "']").length == 0) {
        $("#subject_2").append(new Option(name, msg));
    }
    $("#subject_2 option").each(function () {
        this.selected = (this.value == msg);
    });
    $("#subject_2").select2();
}

/*
 解锁，锁定银行
 */
function lockBank(e){
    if(e.value==1)
    {
        var url = $("#user-bank").val();
        $.ajax({
            type: "POST",
            url: url,
            data: {"bank": $("#subject_2").val()}
        })
        $("#subject_2").select2("readonly", true);
        $(e).html("解锁银行");
    }
    else{
        $("#subject_2").select2("readonly", false);
        $(e).html("锁定银行");
    }
    e.value = e.value==0?1:0;
}

function active(e){
    $(e).append('<i>已选择</i>')
}

//插入新行
function addRow(){
    //复制
    itemsplit($("#data_import tr[id!='trSetting']:last td div button")[0]);
    //删除值，去除复制后相关联的信息
    var e = $("#data_import tr[id!='trSetting']:last");
    var item = $("#data_import tr[id!='trSetting']:last input[id^='id_']").val();
    $(e).attr('line',item);
    if($(e).attr("class")=="table-tr")
        $(e).removeClass();
    else
        $(e).addClass("table-tr");
    $("#data_import tr[id!='trSetting']:last input[id!='id_"+item+"']").val("");
    //添加 总金额提示
    var html = '<span class="tip2">总金额：<label id="amount_'+item+'">'+0+'</label></span>'
    $(e).find("[id^='tran_amount_']").after(html)
    $('body').on('focus',"input[name$='\[entry_date\]']", function(){
        $(this).datepicker({
            dateFormat: "yymmdd",
            minDate: getDate()

        });
    });
    $(e).find("[id*='btn_del']").attr("disabled",true);
    $(e).children(':last-child').find("span").html('');


}