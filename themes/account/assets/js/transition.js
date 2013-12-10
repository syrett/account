/**
 * Created by jason.wang on 13-12-9.
 */

$(document).ready(function () {

    $("select[id^='Transition_entry_subject']").change(function(){
        var number = $(this).next().val();
        url = $("#entry_appendix").val();
            $.ajax({
                url:url,
                type: "POST",
                datatype: "json",
                data : {"Name": $(this).val()},
                success:function(html){
                    jQuery("#appendix_"+number).css('display', 'inherit')
                    jQuery("#appendix_"+number).html(html)
                },
                error: function(xhr,err){
                    alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
                    alert("responseText: "+xhr.responseText);
                }
            });
        });
    $('#entry_date input').datepicker({
        format: "yyyymm",
        minViewMode: 1,
        language: "zh-CN",
        autoclose: true
    })
    .on('changeDate', function(ev){
        var date =  $('#entry_date input').val();
        url = $("#entry_appendix").val();
        $.ajax({
            type: "POST",
            url: $("#entry_num_pre").val(),
            data : {"entry_prefix": $('#entry_date input').val()},
            success: function(msg){
                if(msg!=0)
                    $("#tranNumber").attr('value', date+msg);
                $("#Transition_entry_num_prefix").attr('value', date);
                $("#Transition_entry_num").attr('value', msg);
            }
        });
    });
});
var addRow = function (){
    var number = (parseInt($("#number").val()) + 1).toString();

    var $html = "<div id='row_"+number+"' class=row v-detail> \
        \<div class=col-md-3 >  \
        \<input class='form-control input-size' name='Transition[entry_memo]["+number+"]' id='Transition_entry_memo_"+number+"' type='text'> \
        \</div> \
        \<div class='col-md-1'> \
        \<div class='select2-container' id='s2id_Transition_entry_transaction_"+number+"'><a href='javascript:void(0)' onclick='return false;' class='select2-choice' tabindex='-1'>   " +
        "<span class='select2-chosen'>借</span><abbr class='select2-search-choice-close'></abbr>   <span class='select2-arrow'><b></b></span></a>" +
        "<input class='select2-focusser select2-offscreen' type='text' id='s2id_autogen1'>" +
        "<div class='select2-drop select2-display-none select2-with-searchbox'>   " +
        "<div class='select2-search'><input type='text' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' class='select2-input'></div><ul class='select2-results'></ul></div>" +
        "</div></div>" +
        "<div class='col-md-3'>"
                <?php
        $data = $this->actionListFirst();
        $this->widget('Select2', array(
            'name' => 'Transition[entry_subject][$i]',
            'id' => 'Transition_entry_subject_$i',
            'data' => $data,
            'htmlOptions' => array('class' => 'v-subject'),
        ));
        ?>
            <input type='hidden' value='<?= $i ?>'/>
        </div>
        <div class='col-md-1'>
        <?php echo $form->textField($model, 'entry_amount[$i]', array('class' => 'form-control input-size')); ?>
        </div>
        <div class='col-md-4'>
            <span id='appendix_<?= $i; ?>' style='display: none; float: left'>

            </span>

        <?php echo $form->textField($model, 'entry_appendix[$i]', array('style' => 'width: 60%', 'class' => 'form-control input-size', 'maxlength' => 100)); ?>

            <button type='button' class='close' aria-hidden='true' name='<?=$i?>' onclick='rmRow(this)'>&times;</button>
        </div>
    </div>
}
var rmRow = function (ob){
    var number = ob.name
    $("#row_"+number).remove();
}
