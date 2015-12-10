/**
 * Created by jason.wang on 2015-08-06.
 */

$(window).load(function () {
    Metronic.alert({
        container: '#portlet-info', // alerts parent container(by default placed after the page breadcrumbs)
        //place: $('#alert_place').val(), // append or prepent in container
        type: 'info',  // alert's type
        message: '在导入银行或现金前，请先完成其他模块',  // alert's message
        close: 1, // make alert closable
        reset: 1, // close all previouse alerts first
        //focus: 1, // auto scroll to the alert after shown
        //closeInSeconds: 4, // auto close after defined seconds
        icon: 'bell-o custom-i' // put icon before the message
    });
    if($("#first").attr('value')=='empty')
        $("#first").click();
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var ext = input.files[0].name.match(/[^\.]+$/);
        if(ext[0].toLowerCase()=='jpg'){   //选择了图片文件
            $("#show_image").removeClass('hidden');
            $("#show_image").show();
            var reader = new FileReader();
            var img = new Image();
            reader.onload = function (e) {
                img.src = e.target.result;
                var width = $("#head_image tbody tr").width();
                var height = width*img.height/img.width;
                $("[name='show_image_conf_w[]']").val(width/4);
                $("#head_image").css('background-image', "url("+e.target.result+")");
                $("#head_image tbody tr:nth-child(1)").height(height);
            };

            $("#head_image").colResizable({
                liveDrag:true,
                gripInnerHtml:"<div class='grip'></div>",
                draggingClass:"dragging",
                onResize:onSampleResized
            });

            reader.readAsDataURL(input.files[0]);
        }else{
            $("#show_image").hide();
        }
    }
}