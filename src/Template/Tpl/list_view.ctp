<?php echo $this->element('page_banner')?>
<div class="container">
    <article class="article">
        <header>
            <h1 class="text-center"><?php echo $data->title?></h1>
            <?php if (!empty($data->source) && !empty($data->author) && !empty($data->date)):?>
                <dl class="dl-inline">
                    <?php if (!empty($data->source)):?>
                        <dt>来源：</dt>
                        <dd><?php echo $data->source?></dd>
                    <?php endif;?>
                    <?php if (!empty($data->author)):?>
                        <dt>作者：</dt>
                        <dd><?php echo $data->author?></dd>
                    <?php endif;?>
                    <?php if (!empty($data->date)):?>
                        <dt>发布日期：</dt>
                        <dd><?php echo $data->date?></dd>
                    <?php endif;?>
                </dl>
            <?php endif;?>
            <?php if (!empty($data->abstract)):?>
                <section class="abstract">
                    <p><strong>摘要：</strong><?php echo $data->abstract?></p>
                </section>
            <?php endif;?>
        </header>
        <section class="content">
            <?php echo $data->content?>
        </section>
        <footer>
            <ul class="pager pager-justify">
                <li class="previous <?php echo $round['prev']['class']?>"><a href="<?php echo $round['prev']['url']?>"><i class="icon-arrow-left"></i> <?php echo $round['prev']['title']?></a></li>
                <li class="next <?php echo $round['next']['class']?>"><a href="<?php echo $round['next']['url']?>"><?php echo $round['next']['title']?> <i class="icon-arrow-right"></i></a></li>
            </ul>
        </footer>
    </article>
</div>

