/**
 * Created by jason.wang on 13-12-9.
 */

$(document).ready(function () {

    $("#subject").change(function(){
        url = $("#entry_appendix").val();
            $.ajax({
                url:url,
                type: "POST",
                datatype: "json",
                data : {"Name": $("#subject").val()},
                success:function(html){
                    jQuery("#appendix").html(html)
                }
            });
        });
    $('#entry_date input').datepicker({
        format: "yyyymm",
        minViewMode: 1,
        language: "zh-CN",
        autoclose: true
    })
    .on('changeDate', function(ev){
            var date =  $('#entry_date input').val();
            url = $("#entry_appendix").val();
        $.ajax({
            type: "POST",
            url: $("#entry_num_pre").val(),
            data : {"entry_prefix": $('#entry_date input').val()},
            success: function(msg){
                if(msg!=0)
                    $("#tranNumber").attr('value', date+msg);
                $("#Transition_entry_num_prefix").attr('value', date);
                $("#Transition_entry_num").attr('value', msg);
            }
        });
    });
});
