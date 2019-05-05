<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $this->Url->webroot('/favicon.ico')?>" rel="Shortcut Icon">
    <title><?php echo $_SiteCache_['title']['value_field']?></title>
    <meta name="keywords" content="<?php echo $_SeoKeywords_?>">
    <meta name="description" content="<?php echo $_SeoDescription_?>">
    <link href="<?php echo $this->Url->webroot('assets/zui/css/zui.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/chosen/chosen.min.css')?>" rel="stylesheet">
    <?php echo $this->fetch('css')?>
    <link href="<?php echo $this->Url->webroot('css/website/website.css')?>" rel="stylesheet">
</head>
<body>
<div id="zad-wrap">
    <nav class="navbar" role="navigation" id="zad-header">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#zad-header-menus">
                    <span class="sr-only">切换导航</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo $this->Url->build(['plugin' => 'Website', 'controller' => 'Home', 'action' => 'index'])?>"><?php echo $_SiteCache_['title']['value_field']?></a>
            </div>
            <div class="collapse navbar-collapse" id="zad-header-menus">
                <ul class="nav navbar-nav">
                    <?php
                    foreach ($_SiteMenus_ as $item):
                        ?>
                        <li class="<?php if ($_ActiveMenu_ == $item['url']) echo 'active'?>">
                            <a href="<?php echo $item['url']?>"><?php echo $item['name']?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </nav>
    <?php echo $this->fetch('content');?>
    <div id="footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <?php
                    $text = formatEnter($_SiteCache_['footer_left']['value_field']);
                    $header = $text[0];
                    unset($text[0]);
                    ?>
                    <h3><?php echo $header?></h3>
                    <?php if (!empty($text)):?>
                        <ul>
                            <?php foreach ($text as $item):?>
                                <li><?php echo $item?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;unset($text, $header);?>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <?php
                    $text = formatEnter($_SiteCache_['footer_right']['value_field']);
                    $header = $text[0];
                    unset($text[0]);
                    ?>
                    <h3><?php echo $header?></h3>
                    <?php if (!empty($text)):?>
                        <ul>
                            <?php foreach ($text as $item):?>
                                <li><?php echo $item?></li>
                            <?php endforeach;?>
                        </ul>
                    <?php endif;unset($text, $header);?>
                </div>
            </div>
        </div>
        <div class="copyright">
            <?php echo $_SiteCache_['copyright']['value_field']?>
        </div>
    </div>
</div>
<script src="<?php echo $this->Url->webroot('js/jquery.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/js/zui.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/lib/chosen/chosen.min.js')?>"></script>
<?php echo $this->fetch('js_before')?>
<script src="<?php echo $this->Url->webroot('js/website.js')?>"></script>
<?php echo $this->fetch('js')?>
</body>
</html>
