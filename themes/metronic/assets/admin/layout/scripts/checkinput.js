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
function checkInputPrice(ob) {
    var invalidChars = /^[1-9]+\.?\d?\d?$|^0\.\d?\d?$/;
    if(!invalidChars.test(ob.value)) {
        var b = /[1-9]?\d*\.?\d?\d?|0\.\d?\d?/;
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
    var price = $(ob).parent().parent().find("[id*='tran_price_']")[0].value;
    var count = $(ob).parent().parent().find("[id*='tran_count_']")[0].value;
    if(price == '' || count =='')
        $($(ob).parent().parent().find("[id*='tran_amount_']")[0]).html(0);
    else{
        price = parseFloat(price);
        count = parseInt(count);
        $($(ob).parent().parent().find("[id*='tran_amount_']")[0]).html(toAmount(price*count));
    }
}

function toAmount(price){
    if(price>0){
        price = price + 0.000001;
    }else if(price < 0)
        price = price - 0.000001;

    price = price * 100;
    price = parseInt(price);
    return price / 100;
}