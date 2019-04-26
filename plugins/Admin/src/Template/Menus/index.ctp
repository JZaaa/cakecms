<div class="zad-header">
    <?php echo $this->Util->getBtn(
        [
            'name' => '新增',
            'class' => 'btn-primary',
            'url' => ['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'add'],
            'toggle' => 'dialog'
        ]
    )?>
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
                        $options = ['plugin' => $item->plugin, 'controller' => $item->controller, 'action' => $item->action];
                        if (!empty($item->extend)) {
                            $options[] = $item->extend;
                        }
                        echo $this->Url->build($options, true);
                    }
                    ?>
                </td>
                <td>
                    <?php if ($item->is_root != 1) {
                        echo $this->Util->getBtn(
                            [
                                'name' => '编辑',
                                'class' => 'btn-primary btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'edit', $item->id],
                                'toggle' => 'dialog'
                            ],
                            [
                                'name' => '删除',
                                'class' => 'btn-danger btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'delete', $item->id],
                                'toggle' => 'doajax'
                            ]
                        );
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>