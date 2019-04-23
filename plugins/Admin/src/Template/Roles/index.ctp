<div class="zad-header">
    <form autocomplete="off" method="get" class="form-inline">
        <div class="form-group input-control has-label-left">
            <input type="text" class="form-control" name="name" value="<?php echo $name?>">
            <label class="input-control-label-left">角色名称:</label>
        </div>
        <button type="submit" class="btn btn-info">查询</button>
        <?php echo $this->Util->getBtn(
            [
                'name' => '新增',
                'class' => 'btn-primary',
                'url' => ['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'add'],
                'toggle' => 'redirect'
            ]
        )?>
    </form>
</div>
<div class="zad-content">
    <table class="table table-hover table-bordered text-center">
        <thead>
        <tr>
            <th>角色名称</th>
            <th>描述</th>
            <th>超级权限</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $item):?>
            <tr>
                <td><?php echo $item->name?></td>
                <td><?php echo $item->description?></td>
                <td><?php echo ($item->is_super == 1) ? '是' : '否'?></td>
                <td>
                    <?php if ($item->is_super != 1 || $SUPER):?>
                        <?php echo $this->Util->getBtn(
                            [
                                'name' => '编辑',
                                'class' => ' btn-info btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'edit', $item->id],
                                'toggle' => 'redirect'
                            ]
                        )?>
                    <?php endif;?>
                    <?php if ($item->is_super != 1):?>
                        <?php echo $this->Util->getBtn(
                            [
                                'name' => '删除',
                                'class' => 'btn-danger btn-sm',
                                'url' => ['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'delete', $item->id],
                                'toggle' => 'doajax'
                            ]
                        )?>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <?php echo $this->MyPage->show()?>
</div>