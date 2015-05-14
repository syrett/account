/**
 * Created by pdwjun on 2015/3/4.
 */
$(document).ready(function () {
    $("#selectItem2").val(2);
    $("#selectItem3").val(3);
    $("#dialog").hide();
    $("div").on('blur', 'input', function (e) {
        sumAmount(this.parentNode.parentNode)
    })
    $("div").delegate("#new-select", "change", function () {
        $("select[name='new-category']").hide();
        //if ($("#new-category-" + this.value).children().length > 1)
        $("#new-category-" + this.value).show();
        //可以重新考虑后台设置此处的显示规则
        if(this.value==2)   //和发票有关
        $("#new-category-3").show();

    })
})
function itemsplit(e) {

    //直接复制  需要重新设置item 和 id
    $(e.parentNode.parentNode).after($(e.parentNode.parentNode).clone());
    //$(e.parentNode.parentNode.nextSibling.lastChild.previousSibling.previousSibling));
    $(e.parentNode.parentNode.nextSibling).find("input[name*='amount']").val(0);
    $(e.parentNode.parentNode.nextSibling).find("span[class*='tip']").remove();

    //设置id 条目 的name属性 lists[<?= $key ?>][Transition][entry_subject]
    var id = (parseInt($("#rows").val()) + 1).toString();
    $.each($(e.parentNode.parentNode.nextSibling).find("input[name^='lists']"), function (key, value) {
        var name = $(value).attr("name");
        if (name != "" && name) {
            name = name.replace(/\[\d*\]/, "[" + id + "]");
            $(value).attr("name", name);
        }
    })
    $.each($(e.parentNode.parentNode.nextSibling).find("[id*='_']"), function (key, value) {
        var item_id = $(value).attr("id");
        if (item_id.substr(0, 3) == 'id_')
            $(value).val(id)
        if (item_id != "" && item_id) {
            item_id = item_id.replace(/_\d*/, "_" + id);
            $(value).attr("id", item_id);
        }
    })
    $("#rows").val(id);

}

function itemclose(e) {
    e.parentNode.parentNode.remove();
}
function itemsetting(e) {
    $("#itemSetting").dialog({
        autoOpen: true,
        width: "80%",
        height: "500",
        show: "blind",
        hide: "explode",
        modal: true     //设置背景灰的
    });
    cleanDialog();
    $("#itemSetting").dialog("open");
    var id = $(e.parentNode).find("input[id^='id_']")[0].value;
    $("#item_id").val(id);
    $("#data").val(getInfo(e));
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
                '<div class="options" >';
            $.each(data, function (key, value) {
                str += '<button class="btn btn-primary" type="button" onclick="chooseOption(this)" value="' + key + '">' + value + '</button><br />'
            });
            str += '</div>';
            choosed(e);
            $(e).parent().nextAll().remove();
            $(e).parent().after(str);
        }
    });
}
//按钮激活状态
function choosed(e) {
    $(e).parent().children('button').removeClass('active');
    $(e).addClass('active');
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
                var str = '<div class="options alert alert-success alert-dismissable">';
                if (data.option != 0) {
                    $.each(data.option, function (key, value) {
                        if (value[0] == 'text')
                            str += '<input type="text" name="new-option" id="new-option" placeholder="' + value[1] + '" ><br >'
                        if (value[0] == 'select') {

                        }
                    })
                }
                str += '<i class="icon fa fa-check"></i> 已选择 => <span id="sub_name">"' + data.sbj_name + '"</span></div>';
                $(e).parent().after(str);

            }
            else if (data.rule == 'goon') {
                var str = '<div class="options-div"><span class="fa fa-angle-right flow-arrow"></span></div>' +
                    '<div class="options" >';
                $.each(data.data, function (key, value) {
                    if (IsNum(key.toString().substring(1))) //json.parse会把数组重新排序，所以key为数字数组，key前面都添加了下划线'_'
                        key = key.toString().substring(1)
                    str += '<button class="btn btn-primary" type="button" onclick="chooseOption(this)" value="' + key + '">' + value + '</button><br />'
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
                    var newsbj = ''
                    if (data.newsbj != null && data.newsbj != '')
                        newsbj = data.newsbj;
                    str += '<input type="hidden" name="new-type" id="new-type" value="1"><input type="hidden" id="new-subject" name="new-subject" value="' + newsbj + '" > ' +
                    '<input type="text" class="new-item" placeholder="手动填写" id="new-name" name="new-name" value="' + $("#tran_name_" + id).val() + '" >';

                    if (data.list != '') {
                        str += '<select id="new-select" name="new-select" data-placeholder="请选择">';
                        $.each(data.list, function (key, value) {
                            str += '<option value="' + key + '">' + value + '</option>';
                        })
                        str += '</select><br >';
                        $.each(data.select, function (key, value) {
                            str += '<select name="new-category" id="new-category-' + key + '"';
                            if(key!=1)
                                str += 'style="display: none" >';
                            else
                                str += ' >';
                            $.each(value, function (k, e) {
                                str += '<option value="' + k + '">' + e + '</option>';
                            })
                            str += '</select>';
                        });
                    }
                    str += '<br ><button value="" id="button" onclick="chooseSubject(this)">选择</button>'
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
                $("#new-department").select2();
            }
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
    e = $("#info_" + item_id);
    e.removeClass();
    if ($sbj != "") {
        $("#subject_" + item_id).val($sbj);
        e.attr('title', $sbj);
        //显示选择路径
        var str = "";
        $.each($(".options").find("button[class*='active']"), function (key, value) {
            if($(value).html()=='选择')
            {
                str += "=>" + $(value).val();
                //设置相关参数值，现在默认最多2个参数，如果过多要重新写函数
                //设置税费，目前只设置税费
                if($("#new-category-3").is(":visible")){
                    $("#additional_sbj0_"+item_id).val(222102);//科目编号,应交税费2221的二级科目 进项（采购默认）参考gbl数据库
                    var amount = 0;
                    if($("#tran_amount_"+item_id!=''))
                        amount = parseFloat($("#tran_amount_"+item_id).val());
                    var tax = $("#new-category-3").val()    //税率
                    amount = amount - amount/(100+parseFloat(tax))*100;

                    $("#additional_amount0_"+item_id).val(amount);

                }
            }
            else if($(value).html()=='有溢价'){
                $("#additional_sbj0_"+item_id).val(4002);//溢价金额作为资本公积4002贷方
                $("#additional_amount0_"+item_id).val($("#new-option").val());
            }
            else
                str += "=>" + $(value).html();
        })
        //if($("#new-name").val()!=null && $("#new-name").val()!="")
        //    str += $("#new-name").val();
        e.html(str);
        e.addClass("path-success");
    }
    else {
        e.addClass("path-fail");
        e.html("未选择");
    }
    $("#itemSetting").dialog("close");
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
    if ($("#setting").children(":first").find("button[class*='active']").html() == "支出")
        return 1;
    else
        return 2;
}

function cleanDialog() {
    $("#subject").val("");
    $("#setting div:first-child").nextAll().remove();

}
function dialogClose() {
    $("#itemSetting").dialog("close");
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
                $.ajax({
                    type: "POST",
                    url: $("#employee").val(),
                    data: {
                        name: a.children("input[name=new-name]").val(),
                        department: a.children("input[name=new-department]").val()
                    },
                    success: function (data) {
                        var str = '<button class="btn btn-primary" type="button" onclick="chooseOption(this)" value="' +
                            data + '">' + a.children("input[name=new-name]").val() + '</button><br />'
                        a.prepend(str);
                        a.children(":first-child").click();
                    }
                });
                break;
            case "1" :  //新子科目
                $.ajax({
                    type: "POST",
                    url: $("#new-url").val(),
                    data: {
                        name: a.children("input[name=new-name]").val(),
                        subject: a.children("input[name=new-subject]").val()
                    },
                    success: function (msg) {
                        var str = '<button class="btn btn-primary" type="button" onclick="chooseOption(this)" value="' +
                            msg + '">' + a.children("input[name=new-name]").val() + '</button><br />'
                        a.prepend(str);
                        a.children(":first-child").click();

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
确认选择，
 */
function chooseSubject(e){
    //if($("select:visible[id*='new-category-']").length==0) //如果没有，那就是第一个
    //{
    //    chooseOption($("select[id*='new-category-']")[0]);
    //    $("#button").val($("select[id*='new-category-']")[0].selectedOptions[0].innerHTML)
    //}
    //else{
    if ($("#new-select").val()==1){ //第一个下拉框，如果是否定的，才会新建子科目；比如 不是借款 无发票
        var sbj = $("select:visible[id*='new-category-']")[0].value;
        $("#new-subject").val(sbj);
        addNew(e);  //后台判断是否已经创建过该
        return true;
    }
        chooseOption($("select:visible[id*='new-category-']")[0]);
        $("#button").val($("select:visible[id*='new-category-']")[0].selectedOptions[0].innerHTML)

    //}
    choosed($("#button"));
}