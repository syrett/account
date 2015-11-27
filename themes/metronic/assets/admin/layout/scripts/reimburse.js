/**
 * Created by jason.wang on 2015-08-06.
 */

$(window).load(function () {
    if($("#hasPreOrder").val()==1){
       $(".porder").show()
    }
    if ($("#first").attr('value') == 'empty')
        $("#first").click();
})