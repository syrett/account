/**
 * Created by jason.wang on 13-12-6.
 */
$(document).ready(function () {
    //一级科目无法添加同级科目
    //科目表

    var data = ['abcd','test'];
    //data[1] = '同级科目';
    //data[2] = '子科目';
    $("body").delegate("select[id$='sbj_number']", "change",function () {
        val = $(this).val();
        type = $("#sbj_type").val();
        while(val==""){
            setTimeout(val = $(this).val(),100)
        }
        if($(this).val().length==4&&type==1){
            $("#sbj_type").val(2).select2();
            alert('一级科目无法添加同级科目，已自动选择为子科目');
        }

    });

    //同级科目，子科目
    $("body").delegate("#sbj_type", "change",function () {
        type = $(this).val();
        val = $("#Subjects_sbj_number").val();
        while(val==""){
            setTimeout(val = $(this).val(),100)
        }
        if($("#Subjects_sbj_number").val().length==4&&type==1){
            $("#sbj_type").val(2).select2();
            alert('一级科目无法添加同级科目，已自动选择为子科目');
        }

    });
});
