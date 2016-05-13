<style>
a {
    color: gray;
}

a:hover {
    color: red;
}

#article-div {
    background-color: #ffffff;
    margin-top: 1em;
    padding: .5em 2em 2em;
    min-height: 560px;
}

#article-content > p {
    line-height: 2em;
}
</style>
<div>
    <span style="margin-right: .5em;"><a href="/">老法师首页</a></span>
    &gt;
    <span style="margin: 0 .5em;">
        <a href="/#tab_law_cent">法律法规</a>
    </span>
    &gt;
    <span style="margin: 0 .5em;">
        <?php
        $link_cat = '';
        switch($article->category) {
            case 0:
                $link_cat = '会计';
                break;
            case 1:
                $link_cat = '税法';
                break;
            case 2:
                $link_cat = '经济';
                break;
        }
        echo $link_cat;
        ?>
    </span>
    &gt;
    <span style="margin-left: .5em;">正文</span>
</div>

<div id="article-div">
    <div class="" style="margin: 1em 0;">
        <div class="">
            <h3><?= $article->title ?></h3>
            <div class="text-muted">
                <?= date('Y-m-d H:i:s', $article->created_at); ?>
                <span class="glyphicon glyphicon-eye-open" title="浏览" style="margin-left: 2em;"></span>&nbsp;<?=$article->views;?>
            </div>
        </div>
    </div>
    <?php if ($article->snippet != '') { ?>
        <div class="alert alert-warning">
            <?php echo $article->snippet; ?>
        </div>
    <?php } ?>
    <div id="article-content" style="text-indent: 2em;">
        <?= $article->content; ?>
    </div>
</div>
