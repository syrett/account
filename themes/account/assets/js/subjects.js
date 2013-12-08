/**
 * Created by jason.wang on 13-12-6.
 */
$(document).ready(function () {
    $("input[name='Subjects[sbj_cat]']").keyup(function () {
        var ob = this;
        var invalidChars = /[^1-5]/gi
        if (invalidChars.test(ob.value)) {
            ob.value = ob.value.replace(invalidChars, "");
        }
    })
});
