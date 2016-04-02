/**
 * Created by jason.wang on 2015-08-06.
 */

$(document).ready(function () {
    $("div").on("blur", "input[id*='_amount_']", function () {
        var id = $(this.parentNode.parentNode).find("input[id^='id_']")[0].value;
        checkInputAmount(this);
        var base = parseFloat($("#base_amount_" + id).val());
        var base_2 = parseFloat($("#base_2_amount_" + id).val());
        var salary = parseFloat($("#tran_salary_amount_" + id).val());
        var bonus = parseFloat($("#tran_bonus_amount_" + id).val());
        var benefit = parseFloat($("#tran_benefit_amount_" + id).val());
        var payment = salary + bonus + benefit;
        var total = (salary + bonus).toFixed(2);
        if (isNaN(total))
            total = '0.00';
        var social_personal = Math.ceil(base * 10.5 / 10) / 10;
        var provident_personal = Math.ceil(base_2 * 7 / 100);
        var social_company = Math.ceil(base * 35 / 10) / 10;
        var provident_company = Math.ceil(base_2 * 7 / 100);
        var before_tax = Math.round((payment - social_personal - provident_personal) * 100) / 100;
        var personal_tax = getPersonalTax(before_tax);
        var after_tax = Math.round((before_tax - personal_tax) * 100) / 100;
        $("#tran_total_amount_" + id).val(total);
        $("#tran_social_personal_" + id).val(social_personal.toFixed(2));
        $("#tran_provident_personal_" + id).val(provident_personal.toFixed(2));
        $("#tran_before_tax_" + id).val(before_tax.toFixed(2));
        $("#tran_personal_tax_" + id).val(personal_tax.toFixed(2));
        $("#tran_after_tax_" + id).val(after_tax.toFixed(2));
        $("#tran_social_company_" + id).val(social_company.toFixed(2));
        $("#tran_provident_company_" + id).val(provident_company.toFixed(2));
        $("#entry_amount_" + id).val(payment);
    });
    $("tr td:nth-child(3)").nextAll().find("input").css("text-align", "right");
});

$(window).load(function () {
    if ($("#first").attr('value') == 'empty')
        $("#first").click();
})