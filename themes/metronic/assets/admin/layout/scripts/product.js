/**
 * Created by jason.wang on 2015-08-06.
 */

$(window).load(function () {
    $("div.box").delegate("select[id*='tran_appendix_id']", "change",function () {
        var reg = /\d+/;
        var item_id = reg.exec($(this).attr('id'));
        var url = $("#get-porder").val();
        $.ajax({
            url: url,
            type: "POST",
            datatype: "json",
            data: {"type": "client", "id": $(this).val()},
            success: function(data){
                data = JSON.parse(data);
                if(data != ''){
                    $("#preOrder_"+item_id).empty();
                    $.each(data, function(key, info){
                        $("#preOrder_"+item_id).append("<option value='"+key+"'>"+info+"</option>");
                    })
                    $(".porder").show();
                    $("#preOrder_"+item_id + ".psorder").show();

                    $("#preOrder_"+item_id).select2({
                        formatResult: function(data){
                            var order = JSON.parse(data.text);
                            var markup = '<div class="popovers" data-placement="left" data-container="body" data-trigger="hover" data-html="true"  data-original-title="' + order.date +'"'
                            + 'data-content="余额:' + order.amount + '<br>摘要:' + order.memo + '">' + data.id + '</div><script>$(".popovers").popover();<\/script>';
                            return markup;
                        },
                        formatSelection: function(order) {
                            $("[id*=\'popover\']").remove()
                            return order.id;
                        },
                        formatNoMatches: ''
                    });
                }else{
                    $("#preOrder_"+item_id).select2("destroy");
                    $("#preOrder_"+item_id).hide();
                    if($("[id*='s2id_preOrder_']").length==0)
                        $(".porder").hide();
                }
            }
        })
    })
})
function addProduct(){
    addRow();
    var item = $("#data_import tr[id!='trSetting']:last input[id^='id_']").val();
    $("#preOrder_" + item).select2("destroy").hide();
}