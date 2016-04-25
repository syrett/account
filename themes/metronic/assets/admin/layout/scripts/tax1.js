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
            case 'B':
                nth = 4;
                break;
            case 'C':
                nth = 5;
                break;
            case 'D':
                nth = 6;
                break;
        }
        var input1 = $(this).closest('table').find('tr[item=1] td:nth-child(' + nth + ')').html();
        var input4 = $(this).closest('table').find('tr[item=4] td:nth-child(' + nth + ')').html();
        var input6 = $(this).closest('table').find('tr[item=6] td:nth-child(' + nth + ')').html();
        var input8 = $(this).closest('table').find('tr[item=8] td:nth-child(' + nth + ')').html();
        //栏次10是另一类别，table结构上，第一行tr会多一个td,
        var input10 = $(this).closest('table').find('tr[item=10] td:nth-child(' + (nth + 1) + ')').html();

        var input2 = $(this).closest('table').find('tr[item=2] td:nth-child(' + nth + ') input').val();
        var input5 = $(this).closest('table').find('tr[item=5] td:nth-child(' + nth + ') input').val();
        var input7 = $(this).closest('table').find('tr[item=7] td:nth-child(' + nth + ') input').val();
        var input9 = $(this).closest('table').find('tr[item=9] td:nth-child(' + nth + ') input').val();
        var input11 = $(this).closest('table').find('tr[item=11] td:nth-child(' + nth + ') input').val();
        var input13 = $(this).closest('table').find('tr[item=13] td:nth-child(' + nth + ') input').val();

        $(this).closest('table').find('tr[item=3] td:nth-child(' + nth + ')').html(input1 - input2);
        $(this).closest('table').find('tr[item=12] td:nth-child(' + nth + ')').html(input10 - input11);

        var input12 = $(this).closest('table').find('tr[item=12] td:nth-child(' + nth + ')').html();
        $(this).closest('table').find('tr[item=14] td:nth-child(' + nth + ')').html(input12 - input13);
    })
});

$(window).bind("load", function () {
    $('table input').bind('keyup', function () {
        checkInputPrice(this)
    });
});