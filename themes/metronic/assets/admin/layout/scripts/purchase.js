/**
 * Created by jason.wang on 2015-08-06.
 */

var arr = Array('1601', '1801', '1701');
$(document).ready(function () {
    //商品采购的采购用途，如果选了已经存在的商品，之前选择了库存商品中的某一项，则以后库存商品中的其他项都隐藏
    $("table").delegate("select[id*='tran_entry_name_']", "change", function () {
        updateUsefor(this);
    });
});
$(window).load(function () {
    //如果是固定资产，需要选择使用部门
    $("table").delegate("select[id*='tran_subject_']", "change", function () {
        var department_id_show = false;
        $.each($("select[id*='tran_subject_']"), function (key, obj) {
            var sbj = $(obj).val();
            var row = key;
            if (in_array(sbj.substr(1, 4), arr)) {
                department_id_show = true;
                $("select[id='department_id_" + row + "']").select2();
            } else
                $("select[id='department_id_" + row + "']").select2("destroy").hide();
        })
        if (department_id_show) {
            $("[id*='department_id_']").removeClass("hidden");
        } else
            $("[id*='department_id_']").addClass("hidden");
    });

    $.each($("select[id*='tran_subject_']"), function (key, obj) {
        var sbj = $(obj).val();
        var row = key;
        if (in_array(sbj.substr(1, 4), arr)) {
            $("[id*='department_id_']").removeClass("hidden");
            $("select[id='department_id_" + row + "']").select2();
        } else
            $("select[id='department_id_" + row + "']").select2("destroy").hide();
    })
})
function updateUsefor(element, line) {
    var url = $("#get-usefor").val();
    var id = line ? line : $(element.parentNode.parentNode).find("input[id^='id_']")[0].value;
    var name = $("#tran_entry_name_" + id).val()
    $.ajax({
        url: url,
        type: "POST",
        datatype: "json",
        data: {"name": name},
        success: function (data) {
            var data = JSON.parse(data);
            $("#tran_subject_" + id).children().remove();
            $.each(data, function (number, name) {
                $("#tran_subject_" + id).append($("<option></option>").attr("value", number.toString()).text(name))
            })
            $("#tran_subject_" + id).select2("updateResults");
            $("#tran_subject_" + id).select2();
        }
    })

}
function Not_Found(type, term, line) {
    var $not_found = '<div class="nomatch"><a href="#" onclick="return create(\'' + type + '\',\'' + term + '\', \'' + line + '\')">' + term + '  <span>新建</span></a></div>';
    return $not_found;
}
function create(type, term, line) {
    if (type == "vendor") {
        var data = {
            name: term
        }
        var vendor = createVendor(data);
        if (vendor != '0' && $("select[id*='tran_appendix_id_'] option[value='" + vendor + "']").length == 0) {
            $("select[id*='tran_appendix_id_']").append($("<option></option>").attr("value", vendor).text(term));
            $("select[id*='tran_appendix_id_']").select2("updateResults");
        }
        $("select[id*='tran_appendix_id_']").select2("close");
        $("select[id*='tran_appendix_id_" + line + "']").select2("val", vendor);
    } else if (type == "stock") {
        $("select[id*='tran_entry_name_']").append($("<option></option>").attr("value", term).text(term));
        $("select[id*='tran_entry_name_']").select2("updateResults");
        $("select[id*='tran_entry_name_']").select2("close");
        $("select[id*='tran_entry_name_" + line + "']").select2("val", term);
    } else if (type == "subject") {
        var data = {
            name: term,
            subject: 1405
        }
        var subject = createSubject(data);
        if (subject != '0' && $("select[id*='tran_subject_'] option[value='" + subject + "']").length == 0) {
            $("select[id*='tran_subject_']").append($("<option></option>").attr("value", subject).text(term));
            $("select[id*='tran_subject_']").select2("updateResults");
        }
        $("select[id*='tran_appendix_id_']").select2("close");
        $("select[id*='tran_appendix_id_" + line + "']").select2("val", subject);
    }
    //更新采购用途
    updateUsefor(this, line);
}
function addPurchase(){
    addRow();
    var item = $("#data_import tr[id!='trSetting']:last input[id^='id_']").val();
    $("#tran_appendix_id_" + item).select2({'formatNoMatches':function(term){return Not_Found("vendor",term,item);}})
    $("#tran_entry_name_" + item).select2({'formatNoMatches':function(term){return Not_Found("stock",term,item);}})
}