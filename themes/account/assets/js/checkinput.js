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
        var b = /-?[1-9]+\.?\d?\d?|-?0\.\d?\d?/;
        ob.value = b.exec(ob.value);
    }
}
