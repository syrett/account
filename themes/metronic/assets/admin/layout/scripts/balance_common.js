/**
 * Created by dell on 2015/9/29.
 * 期初明细数据共用JS文件
 */
$(window).bind("load", function () {
    $("td").on("blur","[id*='count'],[id*='worth'],[id*='in_price']", function(e){
        sumAmount();
    })
    sumAmount();
})
function sumAmount(){
    var total = 0;
    $.each($("[id*='count']"),function(key,obj){
        var count = $(obj).val();
        var amount = $(obj.parentNode).nextAll().find("[id*='in_price']").val();
        //if(typeof(amount)!="undefined")
        //    amount = amount.replace(',', '');
        //else{
        //    amount = $(obj.parentNode).nextAll().find("[id*='in_price']").val();
        //    amount = amount.replace(',', '');
        //}
        total += count*amount;
    })
    $("#total").html(total);
}