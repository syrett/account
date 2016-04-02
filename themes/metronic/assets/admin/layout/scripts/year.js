/**
 * Created by jason.wang on 2015-08-06.
 */

$(document).ready(function () {
    $("div").on("blur", "input[id*='employee_year_']", function () {
        var tr = $(this).closest('tr');
        var id = $(this).closest('tr').find("input[id^='employee_id_']").val();
        checkInputAmount(this);
        //12个月的工资，每个月单独计算应缴税款
        var after_tax = parseFloat($(this).val()==''?0:$(this).val());
        var abs = 0;
        $.each($(tr).find('label[id^="salary_"]'), function(){
            if($(this).html() != 0)
                abs ++ ;
        })
        if( abs > 0){
            var amount = after_tax/abs;
            var month = 1;
            var tax = 0;
            while (month < 13){
                //当月有工资才计算
                if($('#salary_'+ id + '_' + month).html() != 0){
                    var salary_amount = parseFloat($('label[id^="salary_' + id + '_' + month + '"]').html());
                    salary_amount = salary_amount + amount;
                    var personal_tax = getPersonalTax(salary_amount);
                    tax += personal_tax - parseFloat($("#paidTax_"+ id + "_" + month).val());
                }
                month++;
            }

        }else{  //如果没有发过工资，年终奖按1个月算
            var tax = getPersonalTax(after_tax);
        }
        after_tax -= tax;
        $("#tax_" + id).val(tax.toFixed(2));
        $("#afterTax_" + id).val(after_tax.toFixed(2));
    });
});
