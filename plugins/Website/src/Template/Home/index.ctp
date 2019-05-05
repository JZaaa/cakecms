<?php if(count($sliders)):?>
    <div id="indexSlider" class="carousel slide" data-ride="carousel">
        <!-- 圆点指示器 -->
        <ol class="carousel-indicators">
            <?php foreach($sliders as $key => $item):?>
                <li data-target="#indexSlider" data-slide-to="<?php echo $key?>" class="<?php if ($key==0) echo 'active'?>"></li>
            <?php endforeach;?>
        </ol>

        <!-- 轮播项目 -->
        <div class="carousel-inner">
            <?php foreach($sliders as $key => $item):?>
                <a class="item <?php if ($key==0) echo 'active'?>" href="<?php echo !empty($item->url) ? $item->url : 'javascript:;'?>">
                    <img src="<?php echo $this->Url->webroot($item->pic)?>" alt="<?php echo $item->sub?>">
                </a>
            <?php endforeach;?>

        </div>
    </div>
<?php endif;?>
<?php foreach ($data as $key => $item):?>
    <div class="<?php if ($key%2) echo 'bg-muted'?>">
        <div class="container">
            <?php if (is_array($item)): // 列表 ?>
                <div class="article">
                    <header>
                        <h1 class="text-blue text-center"><?php echo $item['title']?></h1>
                    </header>
                    <section class="content">
                        <div class="row">
                            <?php $i = 0;foreach ($item as $value): if (is_object($value) || is_array($value)):$i++;?>
                                <div class="col-md-6">
                                    <div class="item">
                                        <div class="item-heading">
                                            <h4 ><a class="text-default" href="<?php echo $this->Url->build(['plugin' => 'Website', 'controller' => 'Page', 'action' => 'view', $value->id])?>"><?php echo $value['title']?></a></h4>
                                        </div>
                                        <div class="item-content">
                                            <div class="text small">
                                                <?php echo $this->Text->truncate(
                                                    !empty($value['abstract']) ?
                                                        $value['abstract'] :
                                                        strip_tags($value['content'])
                                                    , 50);?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (!($i%2)):?>
                                    <div class="clearfix"></div>
                                <?php endif;?>
                            <?php endif;endforeach;?>
                        </div>
                    </section>
                </div>
            <?php else: // 单页?>
                <div class="article text-center">
                    <header>
                        <h1 class="text-blue"><?php echo $item['title']?></h1>
                    </header>
                    <section class="content">
                        <?php echo !empty($item['abstract']) ? $item['abstract'] : $this->Text->truncate(
                            strip_tags($item['content']),
                            200
                        );?>
                    </section>
                </div>
            <?php endif;?>
        </div>
    </div>
<?php endforeach;?>
