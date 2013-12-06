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