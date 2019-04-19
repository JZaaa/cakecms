<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CakeCMS</title>
    <link href="<?php echo $this->Url->webroot('assets/zui/css/zui.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/bootbox/bootbox.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/chosen/chosen.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('assets/zui/lib/chosenicons/zui.chosenicons.min.css')?>" rel="stylesheet">
    <?php echo $this->fetch('css')?>
    <link href="<?php echo $this->Url->webroot('css/admin.css')?>" rel="stylesheet">
</head>
<body>
<div id="zad_container_main" class="container zad_container_main load-indicator">
    <div class="zad_container_left">
        <a class="logo" href="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Home', 'action' => 'index'])?>">CakeCMS</a>
        <nav class="menu zad_menu" data-ride="menu">
            <ul id="zad_menu_tree" class="tree tree-menu" data-ride="tree" data-animate="true">
                <?php foreach ($MENUS as $item):
                    if (!empty($item->controller) && !empty($item->action)) {
                        $url =  $this->Url->build(['plugin' => $item->plugin, 'controller' => $item->controller, 'action' => $item->action], true);
                    } else {
                        $url = '#';
                    }
                    ?>
                    <li>
                        <a href="<?php echo $url?>">
                            <i class="icon <?php echo $item->icon?>"></i>
                            <?php echo $item->name?>
                        </a>
                        <?php if (!empty($item->children)):?>
                            <ul>
                                <?php foreach ($item->children as $value):
                                    if (!empty($value->controller) && !empty($value->action)) {
                                        $url =  $this->Url->build(['plugin' => $value->plugin, 'controller' => $value->controller, 'action' => $value->action], true);
                                    } else {
                                        $url = '#';
                                    }
                                    ?>
                                    <li><a href="<?php echo $url?>"><?php echo $value->name?></a></li>
                                <?php endforeach;?>
                            </ul>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
        </nav>
    </div>
    <div class="zad_container_right">
        <div class="zad_top_nav">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="javascript:;" style="color: #ea644a" data-toggle="doajax" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Cogs', 'action' => 'clearCache'])?>">清除缓存</a>
                </li>
                <li>
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php echo $USERNAME?>
                        <span class="icon icon-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu pull-right text-center">
                        <li><a href="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'logout'])?>">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="zad_body">
            <?php echo $this->fetch('content') ?>
        </div>
    </div>

</div>

<script src="<?php echo $this->Url->webroot('js/jquery.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/js/zui.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/lib/bootbox/bootbox.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/lib/chosen/chosen.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/lib/chosenicons/zui.chosenicons.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/validator/jquery.validator.min.js?local=zh-CN')?>"></script>
<?php echo $this->fetch('js_before')?>
<script src="<?php echo $this->Url->webroot('js/admin.js')?>"></script>
<?php echo $this->fetch('js')?>
</body>
</html>
