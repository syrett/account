/**
 * Created by - on 23/02/14.
 */

$(document).ready(function () {

    $('#date').datepicker({
        dateFormat: 'yymmdd'
    })
    var type = $("#type").val();
    $('table input').change(function () {
        var b = /[^_]$/;
        var option = b.exec($(this).attr('id'))[0];
        var nth = 3;
        switch (option) {
            case 'A':
                nth = 3;
                break;
            case 'C':
                nth = 4;
                break;
        }
        var input2 = parseFloat($(this).closest('table').find('tr[item=2] td:nth-child(' + nth + ')').html());
        var input3 = parseFloat($(this).closest('table').find('tr[item=3] td:nth-child(' + nth + ')').html());
        var input4 = parseFloat($(this).closest('table').find('tr[item=4] td:nth-child(' + nth + ')').html());
        var input5 = parseFloat($(this).closest('table').find('tr[item=5] td:nth-child(' + nth + ') input').val());
        var input6 = parseFloat($(this).closest('table').find('tr[item=6] td:nth-child(' + nth + ') input').val());
        var input7 = parseFloat($(this).closest('table').find('tr[item=7] td:nth-child(' + nth + ') input').val());
        var input8 = parseFloat($(this).closest('table').find('tr[item=8] td:nth-child(' + nth + ') input').val());

        input2 = !isNaN(input2)?input2:0;
        input3 = !isNaN(input3)?input3:0;
        input4 = !isNaN(input4)?input4:0;
        input5 = !isNaN(input5)?input5:0;
        input6 = !isNaN(input6)?input6:0;
        input7 = !isNaN(input7)?input7:0;
        input8 = !isNaN(input8)?input8:0;
        //4行+5行-6行-7行-8行
        $(this).closest('table').find('tr[item=9] td:nth-child(' + nth + ')').html(input4 + input5 - input6 - input7 - input8);

        var input9 = parseFloat($(this).closest('table').find('tr[item=9] td:nth-child(' + nth + ')').html());
        var input10 = parseFloat($(this).closest('table').find('tr[item=10] td:nth-child(' + nth + ') input').val());

        input9 = !isNaN(input9)?input9:0;
        input10 = !isNaN(input10)?input10:0;
        // 9*10

        $(this).closest('table').find('tr[item=11] td:nth-child(' + nth + ')').html(input9 * input10 / 100);

        var input11 = parseFloat($(this).closest('table').find('tr[item=11] td:nth-child(' + nth + ')').html());
        var input13 = parseFloat($(this).closest('table').find('tr[item=13] td:nth-child(' + nth + ')').html());
        var input12 = parseFloat($(this).closest('table').find('tr[item=12] td:nth-child(' + nth + ') input').val());
        var input14 = parseFloat($(this).closest('table').find('tr[item=14] td:nth-child(' + nth + ') input').val());
        input11 = !isNaN(input11)?input11:0;
        input13 = !isNaN(input13)?input13:0;
        input12 = !isNaN(input12)?input12:0;
        input14 = !isNaN(input14)?input14:0;
        //11行-12行-13行-14行

        $(this).closest('table').find('tr[item=15] td:nth-child(' + nth + ')').html(input11 - input12 - input13 - input14);

        var input19 = parseFloat($(this).closest('table').find('tr[item=19] td:nth-child(' + nth + ') input').val());
        input19 = !isNaN(input19)?input19:0;
        $(this).closest('table').find('tr[item=20] td:nth-child(' + nth + ')').html((input19 / ((type=='month')?12:4)).toFixed(2));

        var input20 = parseFloat($(this).closest('table').find('tr[item=20] td:nth-child(' + nth + ')').html());
        var input21 = parseFloat($(this).closest('table').find('tr[item=21] td:nth-child(' + nth + ') input').val());
        input20 = !isNaN(input20)?input20:0;
        input21 = !isNaN(input21)?input21:0;
        $(this).closest('table').find('tr[item=22] td:nth-child(' + nth + ')').html((input20 * input21 / 100).toFixed(2));

        var input22 = parseFloat($(this).closest('table').find('tr[item=22] td:nth-child(' + nth + ')').html());
        var input23 = parseFloat($(this).closest('table').find('tr[item=23] td:nth-child(' + nth + ') input').val());
        input22 = !isNaN(input22)?input22:0;
        input23 = !isNaN(input23)?input23:0;
        $(this).closest('table').find('tr[item=24] td:nth-child(' + nth + ')').html((input22 - input23).toFixed(2));

    })
});

$(window).bind("load", function () {
    $('table input').bind('keyup', function () {
        checkInputPrice2(this)
    });
});