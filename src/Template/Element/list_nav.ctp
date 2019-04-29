<!-- 左侧导航列表 -->
<div class="zad-list-nav">
    <ul class="nav nav-stacked text-center">
        <li class="<?php if ($_ActiveNav_ == $_CurrentMenu_['url']) echo 'active'?>"><a href="<?php echo $_CurrentMenu_['url']?>"><?php echo $_CurrentMenu_['name']?></a></li>
        <?php foreach ($_CurrentMenu_['children'] as $item):?>
            <li class="<?php if ($_ActiveNav_ == $item['url']) echo 'active'?>"><a href="<?php echo $item['url']?>"><?php echo $item['name']?></a></li>
        <?php endforeach;?>
    </ul>
</div>
