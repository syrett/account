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
    });
    $("input[name$='\[entry_date\]']").attr('readonly', true);
    $('body').on('focus', "input[name$='\[entry_date\]']", function () {
        $(this).datepicker({
            autoclose: true,
            format: "yyyymmdd",
            startDate: getDate()

        });
    });

    $('body').on('keyup', "input[name$='\[entry_memo\]']", function () {
        $(this).nextAll("span[class*='label-warning']").html("");
    })

})
$(window).bind("load", function () {
    $("#subject_2").select2("readonly", true);
});
function itemsplit(e) {

    //直接复制  需要重新设置item 和 id
    $(e.parentNode.parentNode.parentNode).after($(e.parentNode.parentNode.parentNode).clone());
    //$(e.parentNode.parentNode.nextSibling.lastChild.previousSibling.previousSibling));
    $(e.parentNode.parentNode.parentNode.nextSibling).find("input[name*='amount']").val(0);
    $(e.parentNode.parentNode.parentNode.nextSibling).find("span[class*='tip']").remove();

    //设置id 条目 的name属性 lists[<?= $key ?>][Transition][entry_subject]
    var id = (parseInt($("#rows").val()) + 1).toString();
    $.each($(e.parentNode.parentNode.parentNode.nextSibling).find("[name^='lists[']"), function (key, value) {
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
        //if (item_id.substr(0, 7) == "btn_del") {
        //    $(value).removeAttr("disabled");
        //}
    })
    $("#rows").val(id);
}

function itemclose(e) {
    var line = $(e.parentNode.parentNode.parentNode).attr("line");
    e.parentNode.parentNode.parentNode.remove();
    sumAmount($("#data_import").find("tr[line=" + line + "]:first"));
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
    var sbj = $("#subject").val();
    var item_id = $("#item_id").val()
    unset(item_id);
    e = $("#info_" + item_id);
    e.removeClass();
    setTransaction(item_id);
    if (sbj != "") {
        $("#subject_" + item_id).val(sbj);
        e.attr('title', sbj);
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
//采购销售时的确认按钮
function itemSetDefault(e, type) {
    var id = $(e.parentNode.parentNode).find("input[id^='id_']")[0].value;
    if ($("#tran_subject_" + id).val() != '商品采购') {
        var sbj = $("#tran_subject_" + id).val();
    } else {
        var name = $("#tran_entry_name_" + id).val();
        var data = {
            name: name,
            subject: 1405
        }
        var sbj = createSubject(data);
    }
    unset(id);
    $("#subject_" + id).val(sbj);
    $("#transaction_" + id).val(1);
    //choose vendor
    //data = {name:name};
    //var vendor = createVendor(data);
    var did = $("#tran_appendix_id_" + id).val();

    setTransaction(id);
    $("#vendor_id_" + id).val(did);
    $("#client_id_" + id).val(did);
    name = $("#tran_appendix_id_" + id).find("option:selected").text();
    data = {
        name: name,
        subject: 2202
    }
    sbj = createSubject(data);
    $("#subject_2_" + id).val(sbj);
    if ($("#tran_tax_" + id).val() != 0)
        setTax(id, type);
    else
        removeTax(id, type);
    $("#info_" + id).html('已确认');
    $("#info_" + id).attr('class', 'label-success');
}
//保存凭证，此时再根据选择的科目计算一些数值
function save() {
    //判断银行是否锁定
    //if (!checkBank())
    //    return true;
    //if (!checkInput())
    //    return true;
    $("#abc table tr:first").nextAll('tr:visible[id!=trSetting]').each(function (key, value) {
        var item_id = $(value).find("input[id^='id_']").val();
        var sbj = $("#subject_" + item_id).val();
        $("#invoice_" + item_id).val($("#new-invoice").val() == 2 ? 1 : 0);
        //$("#tax_" + item_id).val($("#withtax_" + item_id).val() == 1 ? 3 : 0);

        //主营业务收入才计算税率
        if (sbj.substr(0, 4) == "6001" && $("#withtax_" + item_id).val() == 1)
            setTax(item_id);    //设置税
    })
    $("#abc table tr:first").nextAll('tr:visible[id!=trSetting]').find("[id*='btn_confirm_']").each(function (key, value) {
        $(value).click();
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

function setTax(item_id, type) {
    //设置相关参数值，现在默认最多2个参数，如果过多要重新写函数
    //设置税费，目前只设置税费
    var tax = $("#tran_tax_" + item_id).val();
    var sbj;
    var name = '';
    if (tax == 3)
        name = '销项';   //增值税

    if (tax == 6 || tax == 13 || tax == 17) {
        if (type == 'product')
            name = '销项';
        else if (type == 'purchase')
            name = '进项';
    }
    var data = {
        name: name,
        subject: 222101
    }
    if (tax == 5) //  5% 为营业税专有税率，借营业税金及附加/营业税，贷应交税金/营业税，不需要单独再计算税
        $("#withtax_" + item_id).val(0);
    else{
        $("#withtax_" + item_id).val(1);
        sbj = createSubject(data);
        $("#additional_sbj0_" + item_id).val(sbj);
        var price = 0;
        if ($("#tran_price_" + item_id != ''))
            price = parseFloat($("#tran_price_" + item_id).val());
        price = price * parseFloat($("#tran_count_" + item_id).val())
        var taxr = $("#tran_tax_" + item_id).val()    //税率
        var tax = price - price / (100 + parseFloat(taxr)) * 100;
        $("#entry_amount_" + item_id).val(price);
        $("#additional_amount0_" + item_id).val(tax);
    }
}
function removeTax(item_id, type) {
    $("#withtax_" + item_id).val(0);
    $("#additional_sbj0_" + item_id).val('');
    var price = parseFloat($("#tran_price_" + item_id).val()) * parseFloat($("#tran_count_" + item_id).val());
    $("#entry_amount_" + item_id).val(price);
}

function checkInput() {
    var check = true;
    $.each($("input[id*='tran_memo_']"), function (key, e) {
        if (e.value == '') {
            $(e).next("span[class*='label-warning']").html('不能为空');
            check = false;
        }
    })
    $.each($("input[id*='tran_amount_']"), function (key, e) {
        if (e.value == '') {
            $(e).nextAll("span[class*='label-warning']").html('金额不能为空');
            check = false;
        } else {
            var b = /-?[1-9]?\d*\.?\d?\d?|-?0\.\d?\d?/;
            if (e.value != b.exec(e.value)) {
                $(e).nextAll("span[class*='label-warning']").html('金额格式不正确');
                check = false;
            }
        }

    })
    return check;
}

//插入新行
function addRow() {
    //复制
    itemsplit($("#data_import tr[id!='trSetting']:last td div button")[0]);
    //删除值，去除复制后相关联的信息
    var e = $("#data_import tr[id!='trSetting']:last");
    var item = $("#data_import tr[id!='trSetting']:last input[id^='id_']").val();
    $(e).attr('line', item);
    if ($(e).attr("class") == "table-tr")
        $(e).removeClass();
    else
        $(e).addClass("table-tr");

    //去除select div,重新设置select2
    $("tr[line='" + item + "'] div[class*='select2-container']").remove();
    $("tr[line='" + item + "'] select").show();
    $("tr[line='" + item + "'] select").select2();

    $("#data_import tr[id!='trSetting']:last input[id!='id_" + item + "']").val("");
    //添加 总金额提示
    var html = '<span class="tip2">总金额：<label id="amount_' + item + '">' + 0 + '</label></span>'
    //$(e).find("[id^='tran_amount_']").after(html)
    $('body').on('focus', "input[name$='\[entry_date\]']", function () {
        $(this).datepicker({
            dateFormat: "yymmdd",
            minDate: getDate()

        });
    });
    //$(e).find("[id*='btn_del']").attr("disabled",true);
    $(e).children(':last-child').find("span").html('');
}