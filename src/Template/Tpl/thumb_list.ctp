<?php echo $this->element('page_banner')?>
<div class="container">
    <div class="space"></div>
    <div class="row">
        <?php $hasNav = (count($_CurrentMenu_) > 1);?>
        <?php if ($hasNav):?>
            <div class="col-xs-12 col-sm-3">
                <?php echo $this->element('list_nav')?>
            </div>
        <?php endif;?>
        <div class="col-xs-12  <?php if ($hasNav) echo 'col-sm-9 hairline-left'?>">
            <?php
            if (!count($data)) : echo $this->MyPage->noData();
            else :
            ?>
            <div class="cards">
                <?php
                foreach ($data as $item):
                if ($item->color) {
                    $style = 'color: ' .$item->color;
                } else {
                    $style = 'color: #353535';
                }
                $url = $this->Url->build(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'view', $item->id]);
                ?>
                <div class="col-xs-6 col-md-3">
                    <a class="card" href="<?php echo $url?>">
                        <div class="bg-img-response" style="
                            height: 200px;
                            width: 100%;
                            background-image: url('<?php echo $this->Url->webroot($item->thumb)?>')
                        ">
                </div>
                <div class="card-heading text-ellipsis"><strong style="<?php echo $style?>"><?php echo $item['title']?></strong></div>
                </a>
            </div>
        <?php endforeach;unset($style, $url);?>
        </div>
    <?php echo $this->MyPage->show()?>
    <?php endif;?>

    </div>
</div>

</div>
