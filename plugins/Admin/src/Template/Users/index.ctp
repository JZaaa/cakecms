<div class="zad-header">
    <form autocomplete="off" method="get" class="form-inline">
        <div class="form-group input-control has-label-left">
            <input type="text" class="form-control" name="username" value="<?php echo $username?>">
            <label class="input-control-label-left">用户名:</label>
        </div>
        <button type="submit" class="btn btn-info">查询</button>
        <?php echo $this->Util->getBtn(
            [
                'name' => '新增',
                'class' => 'btn-primary',
                'url' => ['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'add'],
                'toggle' => 'dialog'
            ]
        )?>
    </form>
</div>
<div class="zad-content">
    <div>
        <table class="table table-hover table-bordered text-center">
            <thead>
            <tr>
                <th>用户名</th>
                <th>系统角色</th>
                <th>昵称</th>
                <th>状态</th>
                <th>登录次数</th>
                <th>最后登录ip</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $item):?>
                <tr>
                    <td><?php echo $item->username?></td>
                    <td><?php echo $item->role->name?></td>
                    <td><?php echo $item->nickname?></td>
                    <td><?php echo $item->status == 1 ? '正常' : '冻结'?></td>
                    <td><?php echo $item->login_count?></td>
                    <td><?php echo $item->login_ip?></td>
                    <td>
                        <?php if ($item->role->is_super != 1 || $SUPER) {
                            echo $this->Util->getBtn(
                                [
                                    'name' => '编辑',
                                    'class' => 'btn-primary btn-sm',
                                    'url' => ['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'edit', $item->id],
                                    'toggle' => 'dialog'
                                ],
                                [
                                    'name' => '删除',
                                    'class' => 'btn-danger btn-sm',
                                    'url' => ['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'delete', $item->id],
                                    'toggle' => 'doajax'
                                ]
                            );
                        }?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php echo $this->MyPage->show()?>
</div>