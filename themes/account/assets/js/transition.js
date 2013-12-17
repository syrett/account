/**
 * Created by jason.wang on 13-12-9.
 */

$(document).ready(function () {
    $("select[id^='Transition']").select2();
    $("select[id$='entry_subject']").change(function () {
        var number = $(this).next().val();
        url = $("#entry_appendix").val();
        $.ajax({
            url: url,
            type: "POST",
            datatype: "json",
            data: {"subject": $(this).val(), "number": number},
            success: function (json) {
                obj = JSON.parse(json)
                jQuery("#appendix_" + number).css('display', 'inherit')
                $("#Transition_"+number+"_entry_appendix_type").val(obj.type)
                jQuery("#appendix_" + number).html(obj.html)
                $("select[id^='Transition']").select2();
            },
            error: function (xhr, err) {
                alert("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                alert("responseText: " + xhr.responseText);
            }
        });
    });
    $('#entry_date input').datepicker({
        format: "yyyymm",
        minViewMode: 1,
        language: "zh-CN",
        autoclose: true
    })
        .on('changeDate', function (ev) {
            var date = $('#entry_date input').val();
            url = $("#entry_appendix").val();
            $.ajax({
                type: "POST",
                url: $("#entry_num_pre").val(),
                data: {"entry_prefix": $('#entry_date input').val()},
                success: function (msg) {
                    if (msg != 0)
                        $("#tranNumber").attr('value', date + msg);
                    $("#entry_num_prefix").attr('value', date);
                    $("#entry_num").attr('value', msg);
                }
            });
        });
});


var addRow = function () {
//    var number = (parseInt($("#number").val()) + 1).toString();
    var number = $("#number").val();
    var html = "<div id='row_" + number + "' class='row v-detail'> " +
        "<div class=col-md-3 > " +
        "<input class='form-control input-size' name='Transition[" + number + "][entry_memo]' id='Transition_" + number + "_entry_memo' type='text'>" +
        "</div>" +

        "<div class='col-md-1'><select id='Transition_" + number + "_entry_transaction'name=Transition[" + number + "][entry_transaction] >" +
        "<option value=0 >借</option><option value='1'>贷</option>" +
        "</select></div>" +
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
        '<div class="col-md-1"><input class="form-control input-size" name="Transition[' + number + '][entry_amount]" id="Transition_' + number + '_entry_amount' +
        '" type="text" /></div>' +
        "<div class='col-md-4'><span id='appendix_" + number + "' style='display: none; float: left'></span>" +
        '<input style="width: 60%" class="form-control input-size" maxlength="100" name="Transition[' + number + '][entry_appendix]" id="Transition_' + number + '_entry_appendix" type="text">' +
        "<button type='button' class='close' aria-hidden='true' name='" + number + "' onclick='rmRow(this)'>&times;</button></div></div>"

    $("#transitionRows").append(html)
    number = (parseInt($("#number").val()) + 1).toString();
    $("#number").val(number)
    $('select[id^="Transition"]').select2();
}

var rmRow = function (ob) {
    var number = ob.name
    $("#row_" + number).remove();
}
