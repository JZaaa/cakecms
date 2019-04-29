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