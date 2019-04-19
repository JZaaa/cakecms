<div class="zad-header">
    <?php echo $this->Util->getBtn(
        [
            'name' => '新增',
            'class' => 'btn-primary',
            'url' => ['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'add'],
            'toggle' => 'dialog'
        ]
    )?>
</div>
<div class="zad-content">

    <table class="table table-hover table-bordered table-condensed text-center">
        <thead>
        <tr>
            <th>路由</th>
            <th>名称</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td class="text-left"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;|--&nbsp;&nbsp;',$item->level - 1) , $item->router?></td>
                <td><?php echo $item->name?></td>
                <td><?php echo $item->sort?></td>
                <td>
                    <?php echo $this->Util->getBtn(
                        [
                            'name' => '编辑',
                            'class' => 'btn-info btn-sm',
                            'url' => ['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'edit', $item->id],
                            'toggle' => 'dialog'
                        ],
                        [
                            'name' => '删除',
                            'class' => 'btn-danger btn-sm',
                            'url' => ['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'delete', $item->id],
                            'toggle' => 'doajax'
                        ]
                    )?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>