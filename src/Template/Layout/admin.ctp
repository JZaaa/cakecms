<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CakeCMS</title>
    <link href="<?php echo $this->Url->webroot('assets/zui/css/zui.min.css')?>" rel="stylesheet">
    <link href="<?php echo $this->Url->webroot('css/admin.css')?>" rel="stylesheet">
    <?php echo $this->fetch('css')?>
</head>
<body>
<div class="container zad_container_main">
    <div class="zad_container_left">
        <a class="logo" href="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Home', 'action' => 'index'])?>">CakeCMS</a>
        <nav class="menu zad_menu" data-ride="menu">
            <ul id="zad_menu_tree" class="tree tree-menu" data-ride="tree" data-animate="true">
                <li><a href="#"><i class="icon icon-th"></i>首页</a></li>
                <li><a href="#"><i class="icon icon-user"></i>个人资料</a></li>
                <li>
                    <a href="#"><i class="icon icon-time"></i>更新时间</a>
                    <ul>
                        <li><a href="#">今天</a></li>
                        <li><a href="#">明天</a></li>
                        <li><a href="#">昨天</a></li>
                        <li><a href="#">本周</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="icon icon-trash"></i>垃圾篓</a></li>
                <li><a href="#"><i class="icon icon-list-ul"></i>全部</a></li>
                <li>
                    <a href="#"><i class="icon icon-tasks"></i>状态</a>
                    <ul>
                        <li>
                            <a href="#">已就绪</a>
                            <ul>
                                <li><a href="http://localhost:63343/zui-admin/index.html">已取消</a></li>
                                <li><a href="#">已关闭</a></li>
                            </ul>
                        </li>
                        <li><a href="#">进行中</a></li>
                        <li><a href="#">已完成</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    <div class="zad_container_right">
        <div class="zad_top_nav">
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?php echo $username?>
                        <span class="icon icon-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li><a href="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'logout'])?>">退出登录</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="zad_content">
            <?php echo $this->fetch('content') ?>
        </div>
        <div class="zad_footer">
            <div>
                JZaaa - CakeCMS
            </div>
        </div>
    </div>

</div>

<script src="<?php echo $this->Url->webroot('js/jquery.min.js')?>"></script>
<script src="<?php echo $this->Url->webroot('assets/zui/js/zui.min.js')?>"></script>
<?php echo $this->fetch('js_before')?>
<script src="<?php echo $this->Url->webroot('js/admin.js')?>"></script>
<?php echo $this->fetch('js')?>
</body>
</html>
