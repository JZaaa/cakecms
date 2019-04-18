<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Routers', 'action' => 'edit', $id])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="form-group">
        <label for="name">名称</label>
        <input id="name" name="name" value="<?php echo $data->name?>" type="text" class="form-control">
    </div>
    <div class="form-group">
        <label for="parent_id">父级</label>
        <select id="parent_id" name="parent_id" class="chosen-select form-control" data-toggle="selectpicker">
            <option value="0">顶级</option>
            <?php foreach ($parents as $key => $item):?>
                <option value="<?php echo $key?>" <?php if ($key == $data['parent_id']) echo 'selected'?>><?php echo $item?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label for="router">路由</label>
        <input id="router" name="router" value="<?php echo $data->router?>" type="text" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="sort">排序</label>
        <input id="sort" name="sort" value="<?php echo $data->sort?>" type="text" class="form-control" data-rule="required;integer(+0)">
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
