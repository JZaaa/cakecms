<form action="<?php echo $this->Url->build(['plugin' => 'Admin', 'controller' => 'Users', 'action' => 'add'])?>" method="post" data-toggle="ajaxform" autocomplete="off">
    <div class="form-group">
        <label for="username" class="required">用户名</label>
        <input id="username" name="username" value="" type="text" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="password" class="required">密码</label>
        <input id="password" name="password" value="" type="password" class="form-control" data-rule="required">
    </div>
    <div class="form-group">
        <label for="nickname" class="required">昵称</label>
        <input type="text" id="nickname" name="nickname" value="" class="form-control" data-rule="required">
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="role_id">用户角色</label>
                <select id="role_id" name="role_id" class="chosen-select form-control" data-toggle="selectpicker" data-rule="required">
                    <?php foreach ($roles as $key => $item):?>
                        <option value="<?php echo $key?>"><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="role_id">状态</label>
                <select id="status" name="status" class="chosen-select form-control" data-toggle="selectpicker">
                    <?php foreach ($status as $key => $item):?>
                        <option value="<?php echo $key?>"><?php echo $item?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="submit" class="btn btn-info">提交</button>
    </div>
</form>
