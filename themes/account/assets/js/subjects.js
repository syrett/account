/**
 * Created by jason.wang on 13-12-6.
 */
$(document).ready(function () {
    $("#Subjects_sbj_name").blur(function(){
        if ($("#Subjects_sbj_name").val()==""){
            $("#Subjects_sbj_name").addClass("error");
            $("#sbj_name_msg").html("科目名称 不能为空");
        }
        if ($("#Subjects_sbj_name").val()!=""){
            $("#Subjects_sbj_name").removeClass("error");
            $("#sbj_name_msg").html("");
        }
    })
});