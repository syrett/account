/**
 * Created by dell on 2015/7/1.
 */

var form = $('#submit_form');
var error = $('.alert-danger', form);
var success = $('.alert-success', form);

var handleTitle = function(tab, navigation, index) {
    var total = navigation.find('li').length;
    var current = index + 1;
    // set wizard title
    $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
    // set done steps
    jQuery('li', $('#form_wizard_1')).removeClass("done");
    var li_list = navigation.find('li');
    for (var i = 0; i < index; i++) {
        jQuery(li_list[i]).addClass("done");
    }

    if (current == 1) {
        $('#form_wizard_1').find('.button-previous').hide();
    } else {
        $('#form_wizard_1').find('.button-previous').show();
    }

    if (current >= total) {
        $('#form_wizard_1').find('.button-next').hide();
        $('#form_wizard_1').find('.button-submit').show();
    } else {
        $('#form_wizard_1').find('.button-next').show();
        $('#form_wizard_1').find('.button-submit').hide();
    }
    Metronic.scrollTo($('.page-title'));
}
$(document).ready(function () {
    $('#form_wizard_1').bootstrapWizard({
        'nextSelector': '.button-next',
        'previousSelector': '.button-previous',
        onTabClick: function (tab, navigation, index, clickedIndex) {
            return false;
            /*
             success.hide();
             error.hide();
             if (form.valid() == false) {
             return false;
             }
             handleTitle(tab, navigation, clickedIndex);
             */
        },
        onNext: function (tab, navigation, index) {
            success.hide();
            error.hide();

            handleTitle(tab, navigation, index);
        },
        onPrevious: function (tab, navigation, index) {
            success.hide();
            error.hide();

            handleTitle(tab, navigation, index);
        },
        onTabShow: function (tab, navigation, index) {
            var total = navigation.find('li').length;
            var current = index + 1;
            var $percent = (current / total) * 100;
            $('#form_wizard_1').find('.progress-bar').css({
                width: $percent + '%'
            });
        }
    });

    $('#form_wizard_1').find('.button-previous').hide();
    $('#form_wizard_1').find('.button-submit').hide();
    $('#form_wizard_1 .button-submit').click(function () {
        $('#submit_type').val('import');$('#form-import').submit();
    }).hide();

});
//日期选择器的起始日期
function getDate() {
    var startDate = $("#dp_startdate").val();
    var year = startDate.substring(0, 4);
    var month = startDate.substring(4, 6);
    var date = new Date(year, month - 1, 1);
    date.setMonth(date.getMonth() + 1);
    return date;
}
//支出或收入
function getType() {
    if ($("#setting").children(":first").find("button[class*='active']").val().trim() == "支出")
        return 1;
    else
        return 2;
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
//设置按钮宽度
function setWidth(e) {
    /*
     var width = Math.max.apply(Math, $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').map(function () {
     return $(this).width();
     }).get());
     $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').width(width);
     $(e.parentNode.nextSibling.nextSibling).find('input[class*="new-"]:visible').width(width);
     */
}

//设置交易方名称
function setTarget(id) {
    var target = $("div.target > button.active").html();
    if (target != undefined && $("#tran_name_" + id).val() == "")
        $("#tran_name_" + id).val(removePath(target));
}
//去除路径，只保留交易方名称abc ，路径格式为 ***/**/abc
function removePath(path) {
    //正则匹配
    path = $('<div>' + path + '</div>').text().trim();
    var reg = /[^/]([^\x00-\xff]|\w)+(<i>|$)/;
    if (reg.test(path)) {
        path = path.match(reg)
        reg = /[^<i>]*/;
        return path[0].match(reg);
    }
    else
        return path;
}
//设置凭证 借贷
function setTransaction(id) {
    $("#transaction_" + id).val(1);
    var type = $(".options:first > button.active").val();
    var action = $("#action").val();
    switch (action) {
        case 'product':
            $("#transaction_" + id).val(2);
            break;
        case 'purchase':
            $("#transaction_" + id).val(1);
            break;
        default :
            if (type == '支出')
                $("#transaction_" + id).val(1)
            if (type == '收入') {
                $("#transaction_" + id).val(2)
            }
    }

    if ($("#subject").val() == 660302)    //利息费用
        $("#transaction_" + id).val(1)
    //设置是否需要生成凭证，例：银行互转，收入方不需要
    var option = $(".options:nth-of-type(3) > button.active").val();
    if (option == '银行转账')
        $("#status_id_" + id).val("2")   //这种状态不需要生成凭证
    else if ($("#status_id_" + id).val() != '0')
        $("#status_id_" + id).val("1")

}
//消除数据，设置前先消除
function unset(id) {
    var sbj = $("[name^='lists\[" + id + "\]\[Transition\]\[subject\]']").val();
    var sbja = $("[name^='lists\[" + id + "\]\[Transition\]\[entry_transaction\]']").val();
    $("data input[name^='lists\[" + id + "\]\[Transition\]'][type='hidden']").val("");
    //如果选择了项目，才消除 已经存在的科目编号
    $("[name^='lists\[" + id + "\]\[Transition\]\[entry_subject\]']").val(sbj);
    $("[name^='lists\[" + id + "\]\[Transition\]\[entry_transaction\]']").val(sbja);
}
//清除科目选择里面的数据，否则直接点确定的话，subject里面有上一次的科目编号
function unsetting() {
    $("#subject").val('')
}
function createSubject(data) {
    var url = $("#new-url").val();
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
function createVendor(data) {
    var url = $("#new-vendor").val();
    var result = 0;
    $.ajax({
        async: false,
        type: "POST",
        url: url,
        data: data,
        success: function (data) {
            result = data;
        },
        error: function (msg) {
            result = msg;
        }
    })
    return result;
}
function createClient(data) {
    var url = $("#new-client").val();
    var result = 0;
    $.ajax({
        async: false,
        type: "POST",
        url: url,
        data: data,
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
    var name = $("#bank_name").val();
    var data = {
        name: name,
        subject: 1002
    }
    var msg = createSubject(data);
    if (msg > 0 && $("#subject_b > option[value='" + msg + "']").length == 0) {
        $("#subject_b").append(new Option(name, msg));
    }
    $("#subject_b option").each(function () {
        this.selected = (this.value == msg);
    });
    $("#subject_b").select2();
}

/*
 解锁，锁定银行
 */
function lockBank(e) {
    var url = $("#user-bank").val();
    $.ajax({
        type: "POST",
        url: url,
        data: {"bank": $("#subject_b").val()}
    })
    //if (e.value == 1) {
    //    var url = $("#user-bank").val();
    //    $.ajax({
    //        type: "POST",
    //        url: url,
    //        data: {"bank": $("#subject_b").val()}
    //    })
    //    $("#subject_b").select2("readonly", true);
    //    $(e).html("解锁银行");
    //}
    //else {
    //    $("#subject_b").select2("readonly", false);
    //    $(e).html("锁定银行");
    //}
    //e.value = e.value == 0 ? 1 : 0;
}

function active(e) {
    //$(e).append('<i>已选择</i>')
}

function checkBank() {
    if ($("select[id='subject_b']").length > 0 && $("#subject_b").attr("readonly") == undefined)
        alert("请锁定银行")
    else
        return true;
}
//删除行
function itemclose(e) {
    var line = $(e.parentNode.parentNode.parentNode).attr("line");
    e.parentNode.parentNode.parentNode.remove();
    sumAmount($("#data_import").find("tr[line=" + line + "]:first").find("[id*='tran_amount_']"));
}
//作废
var oldStatus = 1;
function itemInvalid(e) {
    var id = $(e.parentNode.parentNode).find("input[id^='id_']")[0].value;
    if ($("#status_id_" + id).val() != "0") {
        oldStatus = $("status_id_" + id).val();
        $("#status_id_" + id).val("0");
        $(e.parentNode.parentNode.parentNode).addClass('label-danger');
    } else {
        $("#status_id_" + id).val(oldStatus);
        $(e.parentNode.parentNode.parentNode).removeClass('label-danger');
    }
}

function sumAmount2(ob) {
    var counts = $(ob).parent().parent().find("[name*='[Transition][stocks_count]']").val();
    var prices = $(ob).parent().parent().find("[name*='[Transition][stocks_price]']").val();
    counts = counts.split(",");
    prices = prices.split(",");
    var amount = 0;
    for (var index = counts.length - 1; index >= 0; --index) {
        amount += counts[index] * prices[index];
    }
    $(ob).parent().parent().find("[id*='tran_amount_']").html(toAmount(amount));
    $(ob).parent().parent().find("[id*='entry_amount_']").val(toAmount(amount));
}

function toAmount(price) {
    if (price > 0) {
        price = price + 0.000001;
    } else if (price < 0)
        price = price - 0.000001;

    price = price * 100;
    price = parseInt(price);
    return price / 100;
}

function genPOrder(type) {

}