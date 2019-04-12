<div class="zad-header">
    <button class="btn btn-primary" type="button" data-remote="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'add'])?>" data-toggle="dialog">新增</button>
</div>
<div class="zad-content">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <td>栏目</td>
            <td>链接</td>
            <td>操作</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td>
                    <?php
                    echo $item->name;
                    if ($item->is_show != 1) {
                        echo '<span class="label">隐藏</span>';
                    }
                    ?>

                </td>
                <td>
                    <?php
                    if (!empty($item->controller) && !empty($item->action)) {
                        echo $this->Url->build(['plugin' => $item->plugin, 'controller' => $item->controller, 'action' => $item->action], true);
                    }
                    ?>
                </td>
                <td>
                    <?php if ($item->is_root != 1):?>
                    <button class="btn btn-primary btn-sm" type="button" data-remote="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'edit', $item->id])?>" data-toggle="dialog">编辑</button>
                    <button class="btn btn-primary btn-sm" type="button" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'delete', $item->id])?>" data-toggle="doajax">删除</button>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>