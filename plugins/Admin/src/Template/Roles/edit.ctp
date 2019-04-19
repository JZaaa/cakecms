<div class="zad-content">
    <form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'edit', $id])?>" method="post" data-toggle="ajaxform" autocomplete="off">
        <input type="hidden" name="id" value="<?php echo $data->id?>">
        <div class="form-group">
            <label for="name" class="required">角色名称</label>
            <input id="name" name="name" value="<?php echo $data->name?>" type="text" class="form-control" data-rule="required">
        </div>
        <div class="form-group">
            <label for="description">描述</label>
            <input id="description" name="description" value="<?php echo $data->description?>" type="text" class="form-control">
        </div>
        <h2>角色权限</h2>
        <?php foreach ($routers as $plugin):?>
            <fieldset>
                <table class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th colspan="2">
                            <?php echo !empty($plugin->name) ? $plugin->name : $plugin->router?>
                        </th>
                    </tr>
                    </thead>
                    <?php foreach ($plugin->children as $controller):
                        if (empty($controller->children)) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td><?php echo !empty($controller->name) ? $controller->name : $controller->router?></td>
                            <td>
                                <?php foreach ($controller->children as $action):?>
                                    <div class="checkbox-primary inline-block">
                                        <input id="<?php echo $action->router?>" <?php if (isset($roles[$action->router])) echo 'checked'?> name="role_router[]" type="checkbox" value="<?php echo $action->router?>">
                                        <label for="<?php echo $action->router?>"><?php echo !empty($action->name) ? $action->name : $action->router?></label>
                                    </div>&nbsp;&nbsp;
                                <?php endforeach;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </fieldset>
        <?php endforeach;?>
        <div class="form-group text-right">
            <a class="btn" href="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Roles', 'action' => 'index'])?>">取消</a>
            <button type="submit" class="btn btn-info">提交</button>
        </div>
    </form>
</div>
