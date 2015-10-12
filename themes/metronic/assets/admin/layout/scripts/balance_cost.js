/**
 * Created by dell on 2015/10/12.
 * 期初余额清空函数JS文件
 */
function truncate(type){
    var url = $("#url_truncate").val();
    $.ajax({
        url: url,
        type: "POST",
        datatype: "json",
        data: {"type": type},
        success: function (data) {
            if (data != "") {
                obj = JSON.parse(data)
                alert(obj.msg);
                if(obj.status=='success')
                    window.location.reload();
            }
        }
    });
}