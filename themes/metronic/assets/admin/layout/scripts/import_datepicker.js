/**
 * Created by pdwjun on 2015/5/10.
 */

$(window).load(function() {
    //var date = new Date($("#dp1").val().substring(0, 4), $("#dp1").val().substring(4, 6), $("#dp1").val().substring(6, 8))

    $("input[name$='\[entry_date\]']").attr('readonly',true);
    $('body').on('focus',"input[name$='\[entry_date\]']", function(){
        $(this).datepicker({
            dateFormat: "yymmdd",
            minDate: getDate()

        });
    });
})
function getDate(){
    var startDate = $("#dp_startdate").val();
    var year = startDate.substring(0, 4);
    var month = startDate.substring(4, 6);
    var date = new Date(year, month - 1, 1);
    date.setMonth(date.getMonth() + 1);
    return date;
}