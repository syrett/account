/**
 * Created by jason.wang on 2015-08-06.
 */

$(window).load(function () {
    Metronic.alert({
        container: '#portlet-info', // alerts parent container(by default placed after the page breadcrumbs)
        //place: $('#alert_place').val(), // append or prepent in container
        type: 'info',  // alert's type
        message: '在导入银行或现金前，请先完成其他模块',  // alert's message
        close: 1, // make alert closable
        reset: 1, // close all previouse alerts first
        //focus: 1, // auto scroll to the alert after shown
        //closeInSeconds: 4, // auto close after defined seconds
        icon: 'bell-o custom-i' // put icon before the message
    });
});