<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'add'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="form-group">
        <label for="name">名称</label>
        <input id="name" name="name" value="" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="parent_id">父级</label>
        <select id="parent_id" name="parent_id" class="chosen-select form-control" data-toggle="selectpicker">
            <option value="">顶级</option>
            <?php foreach ($parents as $key => $item):?>
                <option value="<?php echo $key?>"><?php echo $item?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="router">路由</label>
        <input id="router" name="router" value="" type="text" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="sort">排序</label>
        <input id="sort" name="sort" value="0" type="text" class="form-control" data-rule="required;integer(+0)">
    </div>
    <div class="form-group">
        <div class="label label-danger">初始化仅三级路由有效，请设置为 Plugin.Admin 方式 ,会自动生成基础路由</div>
    </div>
    <div class="form-group checkbox-primary">
        <input type="checkbox" id="init" name="init" value="1">
        <label for="init">初始化</label>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
