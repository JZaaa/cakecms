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
                <div class="list list-condensed">
                    <div class="items">
                        <?php
                        foreach ($data as $item):?>
                            <div class="item">
                                <div class="item-content">
                                    <?php if (!empty($item->thumb)):?>
                                        <div class="media pull-left">
                                            <img src="<?php echo $this->Url->webroot($item->thumb)?>" alt="">
                                        </div>
                                    <?php endif;?>
                                    <div class="text">
                                        <h4>
                                            <a style="<?php if ($item->color) echo 'color: ', $item->color , '';?>" href="<?php echo $this->Url->build(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'view', $item->id])?>">
                                                <?php echo $item['title']?>
                                                <?php if ($item['istop'] == 1):?>
                                                    <span class="label label-badge label-danger small label-outline">置顶</span>
                                                <?php endif;?>
                                            </a>
                                        </h4>
                                        <?php echo $item->abstract?>
                                    </div>
                                </div>
                                <div class="item-footer text-right">
                                <span class="text-muted">
                                    <?php echo $item->date?>
                                </span> &nbsp;&nbsp;
                                    <span class="text-muted">
                                    <i class="icon-eye-open"></i> <?php echo $item->visit?>
                                </span>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <?php echo $this->MyPage->show()?>
                </div>
            <?php endif;?>

        </div>
    </div>

</div>
