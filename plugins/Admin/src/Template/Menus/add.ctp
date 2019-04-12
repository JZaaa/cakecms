<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Menus', 'action' => 'add'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="form-group">
        <label for="name" class="required">菜单名称</label>
        <input id="name" name="name" type="text" class="form-control" data-rule="required">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="parent_id">父菜单</label>
                <select id="parent_id" name="parent_id" class="form-control">
                    <option value="">顶级菜单</option>
                    <?php foreach ($parents as $key => $item):?>
                        <option value="<?php echo $key?>"><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="icon">图标</label>
                <input id="icon" name="icon" type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="plugin">plugin</label>
        <input id="plugin" name="plugin" type="text" class="form-control">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="controller">controller</label>
                <input id="controller" name="controller" type="text" class="form-control">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="action">action</label>
                <input id="action" name="action" type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="sort" class="required">排序</label>
        <input id="sort" name="sort" value="0" type="text" class="form-control" data-rule="required;integer(+0)">
    </div>
    <div class="form-group checkbox-primary">
        <input id="is_show" name="is_show" type="checkbox" checked value="1">
        <label for="is_show">显示</label>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
