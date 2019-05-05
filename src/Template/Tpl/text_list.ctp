<?php echo $this->element('page_banner')?>
<div class="container">
    <div class="space"></div>
    <div class="row">
        <?php $hasNav = !empty($_CurrentMenu_['children']);?>
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
                        foreach ($data as $item):
                            if ($item->color) {
                                $style = 'color: ' .$item->color;
                            } else {
                                $style = 'color: #353535';
                            }
                            $url = $this->Url->build(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'view', $item->id]);
                            ?>
                            <div class="item">
                                <div class="item-content">
                                    <div class="text">
                                        <a style="<?php echo $style?>" href="<?php echo $url?>">
                                            <?php echo $item['title']?>
                                            <?php if ($item['istop'] == 1):?>
                                                <span class="label label-badge label-danger">置顶</span>
                                            <?php endif;?>
                                            <span class="pull-right"> <?php echo date('Y-m-d', strtotime($item['date']))?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;unset($style, $url);?>
                    </div>
                    <?php echo $this->MyPage->show()?>
                </div>
            <?php endif;?>

        </div>
    </div>

</div>
