<script type="text/javascript">

    function save(){
        $('#progress_key').val(uniqid());
        open_progress_bar();
        return true;
    }
    function open_progress_bar()
    {
        $("#progressbar").progressbar({value: 0});
        show_progress();
    }

    function show_progress()
    {
        var url = '<?php echo Yii::app()->controller->createUrl("GetProgressBarData"); ?>';
        var progress_key = $('#progress_key').val();
        var edate = $('#edate').val();
        $.getJSON(url + "&key=" + progress_key + "&date=" + edate, function(data) {
            var done = parseInt(data.done);
            var total = parseInt(data.total);
            var percentage = Math.floor(100 * done / total);
            if (percentage > 100)
                percentage = 100;
            $("#progressbar").progressbar( "value", percentage);
            var percentage_txt = percentage + "%";
            $("#percentage").text(percentage_txt);
            if (percentage == 100) {
                alert(<?= Yii::t('import', '已经结账成功') ?>);
                location.reload();
            } else if(percentage == 0) {
                alert(<?= Yii::t('import', '还有凭证未审核，请通过其他账号操作') ?>);
            } else {
                show_progress();
            }
        });
    }

    function uniqid (prefix, more_entropy) {
        // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
        // +    revised by: Kankrelune (http://www.webfaktory.info/)
        // %        note 1: Uses an internal counter (in php_js global) to avoid collision
        // *     example 1: uniqid();
        // *     returns 1: 'a30285b160c14'
        // *     example 2: uniqid('foo');
        // *     returns 2: 'fooa30285b1cd361'
        // *     example 3: uniqid('bar', true);
        // *     returns 3: 'bara20285b23dfd1.31879087'
        if (typeof prefix === 'undefined') {
            prefix = "";
        }

        var retId;
        var formatSeed = function (seed, reqWidth) {
            seed = parseInt(seed, 10).toString(16); // to hex str
            if (reqWidth < seed.length) { // so long we split
                return seed.slice(seed.length - reqWidth);
            }
            if (reqWidth > seed.length) { // so short we pad
                return Array(1 + (reqWidth - seed.length)).join('0') + seed;
            }
            return seed;
        };

        // BEGIN REDUNDANT
        if (!this.php_js) {
            this.php_js = {};
        }
        // END REDUNDANT
        if (!this.php_js.uniqidSeed) { // init seed with big random int
            this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
        }
        this.php_js.uniqidSeed++;

        retId = prefix; // start with prefix, add current milliseconds hex string
        retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
        retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
        if (more_entropy) {
            // for more entropy we add a float lower to 10
            retId += (Math.random() * 10).toFixed(8).toString();
        }

        return retId;
    }

</script>