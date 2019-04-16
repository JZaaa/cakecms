<div class="zad-content">
    <div class="zad-header">
        <form autocomplete="off" method="get" class="form-inline">
            <div class="form-group input-control has-label-left">
                <input type="text" class="form-control" name="name" value="<?php echo $name?>">
                <label class="input-control-label-left">角色名称:</label>
            </div>
            <button type="submit" class="btn btn-info">查询</button>
            <button type="button" class="btn btn-primary" data-toggle="dialog" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'add'])?>">新增</button>
        </form>
    </div>
    <div>
        <table class="table table-hover table-bordered text-center">
            <thead>
            <tr>
                <th>角色名称</th>
                <th>描述</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $item):?>
                <tr>
                    <td><?php echo $item->name?></td>
                    <td><?php echo $item->description?></td>
                    <td>
                            <button type="button" class="btn btn-info btn-sm" data-toggle="dialog" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'edit', $item->id])?>">编辑</button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="doajax" data-url="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'delete', $item->id])?>">删除</button>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php echo $this->MyPage->show()?>
</div>