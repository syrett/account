/**
 * Created by jason.wang on 13-12-6.
 */

//check
function checkInputNum(ob) {
    var invalidChars = /[^0-9]/gi
    if(invalidChars.test(ob.value)) {
        ob.value = ob.value.replace(invalidChars,"");
    }
}
/*
金额数据格式
 */
function checkInputAmount(ob) {
    var invalidChars = /^-?[1-9]+\.?\d?\d?$|^-?0\.\d?\d?$/;
    if(!invalidChars.test(ob.value)) {
        var b = /-?[1-9]?\d*\.?\d?\d?|-?0\.\d?\d?/;
        ob.value = b.exec(ob.value);
    }
    if($(ob).nextAll("span[class='label-warning']").length > 0){
        $(ob).nextAll("span[class='label-warning']").html("");
    }
}
//没有负数
var checkInputPrice = function(ob) {
    var invalidChars = /^[1-9]+\.?\d?\d?$|^0\.\d?\d?$/;
    if(!invalidChars.test(ob.value)) {
        var b = /[1-9]?\d*\.?\d?\d?|0\.\d?\d?/;
        ob.value = b.exec(ob.value);
    }
}
//有负数
var checkInputPrice2 = function(ob) {
    var invalidChars = /^-?[1-9]+\.?\d?\d?$|^0\.\d?\d?$/;
    if(!invalidChars.test(ob.value)) {
        var b = /-?[1-9]?\d*\.?\d?\d?|0\.\d?\d?/;
        ob.value = b.exec(ob.value);
    }
}
function checkinput1(ob){
    checkInputPrice(ob);
    sumAmount(ob);
}
function checkinput2(ob){
    checkInputNum(ob);
    sumAmount(ob);
}

function sumAmount(ob){
    var element = $(ob).parent().parent().find("input[id*='tran_amount_']")[0];
    var price_2 = typeof(element)!='undefined'?element.value:0;
    var element = $(ob).parent().parent().find("input[id*='tran_price_']")[0];
    var price = typeof(element)!='undefined'?element.value:price_2;
    var element = $(ob).parent().parent().find("input[id*='tran_count_']")[0];
    var count = typeof(element)!='undefined'?element.value:1;
    if(count =='')
        $($(ob).parent().parent().find("[id*='tran_amount_']")[0]).html(0);
    else{
        price = parseFloat(price);
        count = parseInt(count);
        $($(ob).closest('tr').find("[id^='tran_amount_']")[0]).html(toAmount(price*count));
    }
}
