/**
 * Created by dell on 2015/7/1.
 */

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
    var width = Math.max.apply(Math, $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').map(function () {
        return $(this).width();
    }).get());
    $(e.parentNode.nextSibling.nextSibling).find('button[class*="btn-"]').width(width);
    $(e.parentNode.nextSibling.nextSibling).find('input[class*="new-"]:visible').width(width);
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
    var type = $(".options:first > button.active").val();
    if (type == '支出')
        $("#transaction_" + id).val(1)
    if (type == '收入') {
        $("#transaction_" + id).val(2)
    }
    if ($("#subject").val() == 660302)    //利息费用
        $("#transaction_" + id).val(1)
    //设置是否需要生成凭证，例：银行互转，收入方不需要
    var option = $(".options:nth-of-type(3) > button.active").val();
    if (option == '银行转账')
        $("#status_id_" + id).val("2")   //这种状态不需要生成凭证
    else
        $("#status_id_" + id).val("1")
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
    var name = $("#bank_name").val();
    var data = {
        name: name,
        subject: 1002
    }
    var msg = createSubject(data);
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
function lockBank(e) {
    if (e.value == 1) {
        var url = $("#user-bank").val();
        $.ajax({
            type: "POST",
            url: url,
            data: {"bank": $("#subject_2").val()}
        })
        $("#subject_2").select2("readonly", true);
        $(e).html("解锁银行");
    }
    else {
        $("#subject_2").select2("readonly", false);
        $(e).html("锁定银行");
    }
    e.value = e.value == 0 ? 1 : 0;
}

function active(e) {
    $(e).append('<i>已选择</i>')
}

function checkBank() {
    if ($("select[id='subject_2']").length > 0 && $("#subject_2").attr("readonly") == undefined)
        alert("请锁定银行")
    else
        return true;
}
