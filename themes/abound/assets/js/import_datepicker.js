/**
 * Created by pdwjun on 2015/5/10.
 */

$(document).ready(function () {
    //var date = new Date($("#dp1").val().substring(0, 4), $("#dp1").val().substring(4, 6), $("#dp1").val().substring(6, 8))

    var startDate = $("#dp_startdate").val();
    var year = startDate.substring(0, 4);
    var month = startDate.substring(4, 6);
    var date = new Date(year, month - 1, 1);
    date.setMonth(date.getMonth() + 1);

    $("input[name$='\[entry_date\]']").attr('readonly',true);
    $("input[name$='\[entry_date\]']").datepicker({
        dateFormat: "yymmdd",
        minDate: date
    })
})