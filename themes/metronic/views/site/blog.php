<style>
 a {
     color: gray;
 }
a:hover {
    color: red;
}
</style>
<div>
    <span style="margin-right: .5em;"><a href="/">老法师首页</a></span>
    &gt;
    <span style="margin: 0 .5em;">
        <?php if($article->category == 1) {
            echo '<a href="/#tab_tax_cent">税务中心</a>';
        } else {
            echo '<a href="/#tab_law_cent">法律法规</a>';
        } ?>
    </span>
    &gt;
    <span style="margin-left: .5em;">正文</span>
</div>

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

<div style="text-indent: 2em;">
    <?= $article->content; ?>
</div>
