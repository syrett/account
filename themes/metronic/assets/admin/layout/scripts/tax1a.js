/**
 * Created by - on 23/02/14.
 */

$(document).ready(function () {

    $('#date').datepicker({
        dateFormat: 'yymmdd'
    })

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
        var input11 = parseFloat($(this).closest('table').find('tr[item=11] td:nth-child(' + (nth+1) + ')').html());
        var input12 = parseFloat($(this).closest('table').find('tr[item=12] td:nth-child(' + nth + ')').html());

        var input13 = parseFloat($(this).closest('table').find('tr[item=13] td:nth-child(' + nth + ') input').val());
        var input14 = parseFloat($(this).closest('table').find('tr[item=14] td:nth-child(' + nth + ') input').val());
        var input15 = parseFloat($(this).closest('table').find('tr[item=15] td:nth-child(' + nth + ') input').val());
        var input16 = parseFloat($(this).closest('table').find('tr[item=16] td:nth-child(' + nth + ') input').val());

        input13 = !isNaN(input13)?input13:0;
        input14 = !isNaN(input14)?input14:0;
        input15 = !isNaN(input15)?input15:0;
        input16 = !isNaN(input16)?input16:0;
        if(option == 'A')
        $(this).closest('table').find('tr[item=17] td:nth-child(' + nth + ')').html((input12 + input13 - input14 - input15 + input16).toFixed(2));

        var input17 = $(this).closest('table').find('tr[item=17] td:nth-child(' + nth + ')').html();
        $(this).closest('table').find('tr[item=18] td:nth-child(' + nth + ')').html(option=='A'?(input17<input11?input17:input11):input12);

        var input18 = parseFloat($(this).closest('table').find('tr[item=18] td:nth-child(' + nth + ')').html());
        $(this).closest('table').find('tr[item=19] td:nth-child(' + nth + ')').html((input11 - input18).toFixed(2));

        if(option == 'A')
        $(this).closest('table').find('tr[item=20] td:nth-child(' + nth + ')').html((input17 - input18).toFixed(2));

        var input19 = parseFloat($(this).closest('table').find('tr[item=19] td:nth-child(' + nth + ')').html());
        var input21 = parseFloat($(this).closest('table').find('tr[item=21] td:nth-child(' + nth + ') input').val());
        var input22 = parseFloat($(this).closest('table').find('tr[item=22] td:nth-child(' + nth + ') input').val());
        var input23 = parseFloat($(this).closest('table').find('tr[item=23] td:nth-child(' + nth + ') input').val());
        input21 = !isNaN(input21)?input21:0;
        input22 = !isNaN(input22)?input22:0;
        input23 = !isNaN(input23)?input23:0;
        $(this).closest('table').find('tr[item=24] td:nth-child(' + nth + ')').html((input19 + input21 - input23).toFixed(2));

        var input24 = parseFloat($(this).closest('table').find('tr[item=24] td:nth-child(' + nth + ')').html());

        var input25 = parseFloat($(this).closest('table').find('tr[item=25] td:nth-child(' + nth + ') input').val());
        var input26 = parseFloat($(this).closest('table').find('tr[item=26] td:nth-child(' + nth + ') input').val());
        var input28 = parseFloat($(this).closest('table').find('tr[item=28] td:nth-child(' + nth + ') input').val());
        var input31 = parseFloat($(this).closest('table').find('tr[item=31] td:nth-child(' + nth + ') input').val());

        var input30 = parseFloat($(this).closest('table').find('tr[item=30] td:nth-child(' + nth + ')').html());
        input24 = !isNaN(input24)?input24:0;
        input25 = !isNaN(input25)?input25:0;
        input26 = !isNaN(input26)?input26:0;
        input28 = !isNaN(input28)?input28:0;
        input31 = !isNaN(input31)?input31:0;

        $(this).closest('table').find('tr[item=27] td:nth-child(' + nth + ')').html((input28 + input30 + input31).toFixed(2));

        var input27 = parseFloat($(this).closest('table').find('tr[item=27] td:nth-child(' + nth + ')').html());
        input27 = !isNaN(input27)?input27:0;
        $(this).closest('table').find('tr[item=32] td:nth-child(' + nth + ')').html((input24 + input25 + input26 - input27).toFixed(2));

        $(this).closest('table').find('tr[item=33] td:nth-child(' + nth + ')').html((input25 + input26 - input27).toFixed(2));
        $(this).closest('table').find('tr[item=34] td:nth-child(' + nth + ')').html((input24 - input28).toFixed(2));

        var input35 = parseFloat($(this).closest('table').find('tr[item=35] td:nth-child(' + nth + ') input').val());
        var input36 = parseFloat($(this).closest('table').find('tr[item=36] td:nth-child(' + nth + ') input').val());
        var input37 = parseFloat($(this).closest('table').find('tr[item=37] td:nth-child(' + nth + ') input').val());
        input36 = !isNaN(input36)?input36:0;
        input37 = !isNaN(input37)?input37:0;

        $(this).closest('table').find('tr[item=38] td:nth-child(' + nth + ')').html((input16 + input22 + input36 - input37).toFixed(2));


    })
});

$(window).bind("load", function () {
    $('table input').bind('keyup', function () {
        checkInputPrice(this)
    });
});