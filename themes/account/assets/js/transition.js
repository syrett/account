/**
 * Created by jason.wang on 13-12-9.
 */

//$(document).ajaxStop($("select[id^='Transition']").select2());
$(document).ready(function () {
    $("input[id$='_entry_amount']").blur(function(){    //自动添加小数点23.00
        if(!isNaN($(this).val())&&$(this).val()!="")
        {var a=parseFloat($(this).val());
        $(this).val(decimals(a))
        }
    })
    $("select[id^='Transition']").select2();
    $("div").on("load","select[id^='Transition']", function(){$(this).select2()})
    $("div").delegate("select[id$='entry_subject']", "change",function () {
        var number = $(this).next().val();
        url = $("#entry_appendix").val();
        $.ajax({
            url: url,
            type: "POST",
            datatype: "json",
            data: {"subject": $(this).val(), "number": number},
            success: function (json) {
                obj = JSON.parse(json)
                $("#appendix_" + number).css('display', 'inherit')
                $("#Transition_"+number+"_entry_appendix_type").val(obj.type)
                $("#appendix_" + number).html(obj.html)
                $("select[id='Transition_"+number+"_entry_appendix_id']").select2();
            },
            error: function (xhr, err) {
                alert("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                alert("responseText: " + xhr.responseText);
            }
        });
        //收入类 只能选贷 费用类 只能选借
        subjects(this,$("select[id='Transition_"+number+"_entry_transaction']"));

    });

    $('#transition_date input').datepicker({
        format: "yyyymmdd",
        language: "zh-CN",
        autoclose: true
    })
        .on('changeDate', function (ev) {
            var date = $('#transition_date input').val();

            var a = /\d{6}/;    //去除日期
            var prefix = a.exec(date);
            var b = /\d{2}$/;   //最后日期 day
            var day = b.exec(date)

            $.ajax({
                type: "POST",
                url: $("#entry_num_pre").val(),
                data: {"entry_prefix": prefix[0]},
                success: function (msg) {
                    if (msg != 0)
                        $("#tranNumber").attr('value', prefix[0] + msg);
                    $("#entry_num_prefix").attr('value', prefix[0]);
                    $("#entry_num").attr('value', msg);
                    $("#entry_day").attr('value',day);
                }
            });
        });
    $("select[id$='_entry_subject']").each(function(){
        var number = $(this).next().val();
        subjects(this,$("select[id='Transition_"+number+"_entry_transaction']"));
    })

//默认选择日期 无效
//    var dateString  = $('#transition_date input').val();
//    var year        = dateString.substring(0,4);
//    var month       = dateString.substring(4,6);
//    var day         = dateString.substring(6,8);
//    var date        = new Date(year, month-1, day);
//
//    $('#transition_date input').datepicker('setDate', date)
//    $('#transition_date input').datepicker('update')
});

var subjects = function(se,ob){ //todo:subjects
    if($(se).val()>=6000 && $(se).val()<=6399)
    {
        ob.attr('readonly', true);
        ob.select2('val',2);
    }
    else
    if($(se).val()>=6400 && $(se).val()<=6999)
    {
        ob.attr('readonly', true);
        ob.select2('val',1);
    }
    else{
        ob.attr('readonly', false);
    }
}

var decimals = function(varNumber){
    if (varNumber.toFixed)
    {
        // Browser supports toFixed() method
        varNumber = varNumber.toFixed(2)
    }else{
        // Browser doesn’t support toFixed() method so use some other code
        var div = Math.pow(10,2);
        varNumber = Math.round(varNumber * div) / div;
    }
    return varNumber;
}

var addRow = function () {
//    var number = (parseInt($("#number").val()) + 1).toString();
    var number = $("#number").val();
    var html = "<div id='row_" + number + "' class='row v-detail'> " +
        "<div class=col-md-3 > " +
        "<input class='form-control input-size' name='Transition[" + number + "][entry_memo]' id='Transition_" + number + "_entry_memo' type='text'>" +
        "</div>" +
        '<div class="col-md-3"><select class="v-subject" id="Transition_' + number + '_entry_subject" name="Transition[' + number + '][entry_subject]" >'
    $.ajax({
        type: "POST",
        url: $("#ajax_listfirst").val(),
        async: false,
        success: function (msg) {
            msg = $.parseJSON(msg);
            for (i = 0; i < msg.length; i++) {
                html += "<option value='" + msg[i][0] + "'>" + msg[i][1] + "</option>";
            }
        },
        error: function(msg){
          alert('服务器错误')
        }
    });
    html += '</select><input type="hidden" value="' + number + '"/></div>' +
        "<div class='col-md-1'><select id='Transition_" + number + "_entry_transaction'name=Transition[" + number + "][entry_transaction] >" +
        "<option value=1 >借</option><option value=2>贷</option>" +
        "</select></div>" +
        '<div class="col-md-1"><input class="form-control input-size" name="Transition[' + number + '][entry_amount]" id="Transition_' + number + '_entry_amount' +
        '" type="text" /></div>' +


        "<div class='col-md-4'>" +
        "<span id='appendix_" + number + "' style='display: none; float: left'></span>" +
        "<button type='button' class='close' aria-hidden='true' name='" + number + "' onclick='rmRow(this)'>&times;</button></div></div>"

    $("#transitionRows").append(html)
    $("select[id^='Transition_"+number+"']").select2();
    number = (parseInt($("#number").val()) + 1).toString();
    $("#number").val(number)
}

var rmRow = function (ob) {
    var number = ob.name
    $("#row_" + number).remove();
}
