/**
 * Created by jason.wang on 07/07/14.
 */

$(document).ready(function () {
    $("#fm").change(function (){
        $("#tm").val($(this).val());
        $("#tm").select2();

    })
})