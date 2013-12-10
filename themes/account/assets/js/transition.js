/**
 * Created by jason.wang on 13-12-9.
 */

$(document).ready(function () {

    $("select[id^='Transition_entry_subject']").change(function(){
        var number = $(this).next().val();
        url = $("#entry_appendix").val();
            $.ajax({
                url:url,
                type: "POST",
                datatype: "json",
                data : {"Name": $(this).val()},
                success:function(html){
                    jQuery("#appendix_"+number).css('display', 'inherit')
                    jQuery("#appendix_"+number).html(html)
                },
                error: function(xhr,err){
                    alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
                    alert("responseText: "+xhr.responseText);
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
var addRow = function (){
    alert(222)
}
var rmRow = function (ob){
    var number = ob.name
    $("#row_"+number).remove();
}
