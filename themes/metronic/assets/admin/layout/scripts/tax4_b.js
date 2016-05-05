/**
 * Created by - on 23/02/14.
 */

$(document).ready(function () {

    $('#date').datepicker({
        dateFormat: 'yymmdd'
    })

    $('table input').change(function () {
        var nth = 3;

        var input19 = $(this).closest('table').find('tr[item=19] td:nth-child(' + nth + ') input').val();
        var input17 = $(this).closest('table').find('tr[item=17] td:nth-child(' + (nth + 1) + ') input').val();
        input19 = ('' != input19)?input19:0;
        input17 = ('' != input17)?input17:0;
        var input1 = $(this).closest('table').find('tr[item=1] td:nth-child(' + (nth+2) + ')').html();
        var input3 = $(this).closest('table').find('tr[item=3] td:nth-child(' + nth + ')').html();

        var input2 = $(this).closest('table').find('tr[item=2] td:nth-child(' + nth + ') input').val();
        input2 = ('' != input2)?input2:0;

        $(this).closest('table').find('tr[item=9] td:nth-child(' + nth + ')').html(input1 - input2 - input3);

        var input9 = $(this).closest('table').find('tr[item=9] td:nth-child(' + nth + ')').html();
        var input10 = $(this).closest('table').find('tr[item=10] td:nth-child(' + nth + ')').html();
        input9 = ('' != input9)?input9:0;
        input10 = ('' != input10)?input10:0;

        $(this).closest('table').find('tr[item=11] td:nth-child(' + nth + ')').html(input9 * input10 / 100);

        var input11 = $(this).closest('table').find('tr[item=11] td:nth-child(' + nth + ')').html();
        var input15 = $(this).closest('table').find('tr[item=15] td:nth-child(' + (nth + 1) + ')').html();
        input11 = ('' != input11)?input11:0;
        input15 = ('' != input15)?input15:0;

        $(this).closest('table').find('tr[item="16-1"] td:nth-child(' + nth + ')').html(((input11 * input15)/100).toFixed(2));

        var input161 = $(this).closest('table').find('tr[item="16-1"] td:nth-child(' + nth + ')').html();
        var input162 = $(this).closest('table').find('tr[item="16-2"] td:nth-child(' + nth + ')').html();
        

        $(this).closest('table').find('tr[item="20-1"] td:nth-child(' + nth + ')').html(input161 - input17 - input19);
        $(this).closest('table').find('tr[item="20-2"] td:nth-child(' + nth + ')').html(input162 - input17 - input19);

})
});

$(window).bind("load", function () {
    $('table input').bind('keyup', function () {
        checkInputPrice2(this)
    });
});