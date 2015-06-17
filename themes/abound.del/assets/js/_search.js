/**
 * Created by jason.wang on 14-01-14.
 */

//$(document).ajaxStop($("select[id^='Transition']").select2());
$(document).ready(function () {
    $('#tran_search input').datepicker({
        format: "yyyymmdd",
        language: "zh-CN",
        autoclose: true
    })
});